<?php namespace Ixudra\Core\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Redirect;

use Ixudra\Core\Traits\RedirectableTrait;

abstract class BaseController extends Controller {

    use DispatchesCommands, ValidatesRequests, RedirectableTrait;

}
