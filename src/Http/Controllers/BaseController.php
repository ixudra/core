<?php namespace Ixudra\Core\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Ixudra\Core\Traits\RedirectableTrait;

abstract class BaseController extends Controller {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, RedirectableTrait;

}
