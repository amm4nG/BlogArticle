<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $artikel = Artikel::latest('id')->paginate(3);
        return view('home', compact(['artikel']));
    }

    public function readMore(Request $request)
    {
        $article = Artikel::find($request->id);
        return response()->json([
            'description' => $article->description
        ]);
    }
}