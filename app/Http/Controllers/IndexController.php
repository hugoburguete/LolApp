<?php
namespace LolApplication\Http\Controllers;

class IndexController extends Controller
{
    /**
     * Index page of the application
     */
    public function index()
    {
        return view('index');
    }
}