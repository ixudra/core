<?php namespace Ixudra\Core\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

use Ixudra\Core\Traits\RedirectableTrait;

abstract class BaseController extends Controller {

    use DispatchesJobs, ValidatesRequests, RedirectableTrait;

}
