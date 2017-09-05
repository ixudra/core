<?php namespace Ixudra\Core\Console\Commands;


use Carbon\Carbon;
use Illuminate\Console\Command as LaravelCommand;
use Illuminate\Support\MessageBag;
use Symfony\Component\Console\Output\OutputInterface;

use DB;
use Exception;

abstract class BaseCommand extends LaravelCommand {

    /** @var MessageBag     Error messages that have been collected during the command execution */
    protected $messages;

    /** @var  Carbon        Timestamp when the command started execution of the main task */
    protected $startTime;

    /** @var  Carbon        Timestamp when the command finished execution of the main task */
    protected $endTime;


    public function __construct()
    {
        parent::__construct();

        $this->messages = new MessageBag();
    }


    /**
     * Fire the artisan command. When using this class as a base class, the fire or handle method should not be included
     * in your command as this will make this base class obsolete. Instead, you should implement the executeCommand and
     * move all your production code there. It will then be picked up by the fire() method and executed correctly.
     */
    public function handle()
    {
        $isSuccessful = true;

        // Register the time when the command started execution of the main task
        $this->startTime = Carbon::now();

        try {

            // Execute the main task of the command
            $this->executeCommand();

        } catch(Exception $e) {
            $isSuccessful = false;
        }

        // Register the time when the main task of the command was completed
        $this->endTime = Carbon::now();

        DB::table('command_history')->insert(
            array(
                'command'               => $this->getFullCommandName(),
                'start_time'            => $this->startTime,
                'end_time'              => $this->endTime,
                'is_successful'         => $isSuccessful,
            )
        );

        $this->printReport();
    }

    /**
     * Execute the main task of the artisan command. This method should contain all the production code that needs to
     * be executed when the command is triggered via artisan
     */
    abstract protected function executeCommand();

    /**
     * Reconstruct the full command name (including arguments and options) so we can store it in the database and check
     * it later if an error has occurred
     *
     * @return string
     */
    protected function getFullCommandName()
    {
        $name = $this->name;

        foreach( $this->getArguments() as $argument ) {
            $argumentName = $argument[ 0 ];
            $argumentValue = $this->input->getArgument($argumentName);

            if( strpos($this->name, '{'. $argumentName .'}') !== false ) {
                $name = str_replace('{'. $argumentName .'}', $argumentValue, $this->name);
            } else {
                $name .= ' '. $argumentValue;
            }
        }

        foreach( $this->getOptions() as $option ) {
            $key = $option[ 0 ];
            $name .= ' --'. $key .'='. $this->input->getOption( $key );
        }

        return $name;
    }

    /**
     * Print a message indicating that the command has started processing an entry in the data set that is being
     * processed. This can be used to easily notify the user of the progress of the artisan command
     *
     * @param   array $context      Contains a list of parameters that can be used to provide more useful information to the user
     */
    protected function printStartMessage(array $context = array())
    {
        if( $this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE ) {
            $this->info( $this->getStartMessage( $context ) );
        }
    }

    /**
     * Build a message indicating that the command has started processing an entry in the data set that is being
     * processed. This can be used to easily notify the user of the progress of the artisan command
     *
     * @param   array $context      Contains a list of parameters that can be used to provide more useful information to the user
     */
    abstract protected function getStartMessage(array $context = array());

    /**
     * Print a message indicating that the command has skipped processing an entry in the data set that is being
     * processed. This can be used to easily notify the user of the progress of the artisan command
     *
     * @param   array $context      Contains a list of parameters that can be used to provide more useful information to the user
     */
    protected function printSkippedMessage(array $context = array())
    {
        if( $this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE ) {
            $this->info( $this->getSkippedMessage( $context ) );
        }
    }

    /**
     * Build a message indicating that the command has started processing an entry in the data set that is being
     * processed. This can be used to easily notify the user of the progress of the artisan command
     *
     * @param   array $context      Contains a list of parameters that can be used to provide more useful information to the user
     */
    abstract protected function getSkippedMessage(array $context = array());

    /**
     * Print a message indicating that the command has successfully processed an entry in the data set that is being
     * processed. This can be used to easily notify the user of the progress of the artisan command
     *
     * @param   array $context      Contains a list of parameters that can be used to provide more useful information to the user
     */
    protected function printSuccessMessage(array $context = array())
    {
        if( $this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE ) {
            $this->info( $this->getSuccessMessage( $context ) );
        } else if( $this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE ) {
            $this->output->write('.');
        }
    }

    /**
     * Build a message indicating that the command has successfully processed an entry in the data set that is being
     * processed. This can be used to easily notify the user of the progress of the artisan command
     *
     * @param   array $context      Contains a list of parameters that can be used to provide more useful information to the user
     */
    abstract protected function getSuccessMessage(array $context = array());

    /**
     * Print a message indicating that the command has failed to process an entry in the data set that is being
     * processed. This can be used to easily notify the user of the progress of the artisan command
     *
     * @param   array $context      Contains a list of parameters that can be used to provide more useful information to the user
     */
    protected function printErrorMessage(array $context = array())
    {
        if( $this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE ) {
            $this->error( $this->getErrorMessage( $context ) );
        } else if( $this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE ) {
            $this->output->write('<error>F</error>');
        }
    }

    /**
     * Build a message indicating that the command has failed to process an entry in the data set that is being
     * processed. This can be used to easily notify the user of the progress of the artisan command
     *
     * @param   array $context      Contains a list of parameters that can be used to provide more useful information to the user
     */
    abstract protected function getErrorMessage(array $context = array());

    /**
     * Print a concise report describing if and which errors have occurred during the execution of the artisan command
     */
    protected function printReport()
    {
        $this->line(' --- ');
        if( !$this->errorOccurred() ) {
            $this->info('0 errors encountered.');
        } else {
            $this->error( count($this->messages->get('error')) .' error(s) encountered' );
            foreach( $this->messages->get('error') as $error ) {
                $this->error( $error );
            }
        }
    }

    /**
     * @return bool
     */
    protected function errorOccurred()
    {
        return $this->messages->has('error');
    }

    /**
     * @param   string $message     The error message that is supposed to be registered and returned to the user after execution is completed
     */
    protected function addError($message)
    {
        $this->messages->add( 'error', $message );
    }

}
