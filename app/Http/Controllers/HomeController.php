<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    private static function allBooks() {
        $query = DB::table('book')
            ->join('item', 'item.id', '=', 'book.item_id')
            ->where('item.flag_delete', '=', false);

        return $query->get('book.*');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ['books' => self::allBooks()]);
    }

    public function adminHome() {
        return view('home', ['books' => self::allBooks()]);
    }
}
