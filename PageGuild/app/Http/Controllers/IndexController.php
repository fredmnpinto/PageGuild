<?php

namespace App\Http\Controllers;

use App\Models\PageGuild;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        return view("index");
    }
}
