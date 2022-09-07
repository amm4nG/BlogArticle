<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ControllerHalamanUtama extends Controller
{
    public function index()
    {
        $articles = Artikel::latest('id')->paginate(5);
        return view('welcome', compact(['articles']));
    }
}