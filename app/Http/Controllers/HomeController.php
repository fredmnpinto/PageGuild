<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ['books' => BookController::allBooks()]);
    }

    public function adminHome() {
        return view('home', ['books' => BookController::allBooks()]);
    }

    public function howTo() {
        return view('howTo');
    }
}
