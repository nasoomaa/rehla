<?php

namespace Rehla\Dashboard\Http\Controllers;

use Illuminate\View\View;

class HelpController extends Controller
{
    /**
     * Display the help & resources page.
     */
    public function index(): View
    {
        return view('dashboard::help.index');
    }
}
