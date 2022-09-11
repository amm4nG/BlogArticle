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
        $viewAll = Artikel::latest('id')->get();
        return view('home', compact(['artikel', 'viewAll']));
    }

    public function readMore(Request $request)
    {
        $article = Artikel::find($request->id);
        return response()->json([
            'description' => $article->description
        ]);
    }

    public function viewAll()
    {
        $viewAll = Artikel::latest('id')->get();
        $output = '';
        //file controller
        foreach ($viewAll as $view) {
            $description = substr($view->description, 0, 100);
            $output .= '
                <div class="col-md-4">
                    <div class="card mt-3">
                        <img class="card-img-top" src="storage/' . $view->image . '">
                        <div class="card-body">
                            <form id="form-like">
                                <input id="id-article-' . $view->id . '" type="hidden"
                                    value="' . $view->id . '"> 
                                <a class="nav-link" id="like-' . $view->id . '" href="">
                                <i class="bi bi-heart"></i> Like
                                </a>
                            </form> 
                            <p class="card-text mt-3" id="description-artikel-' . $view->id . '">
                                ' . $description . ' ..... 
                                <a data-bs-toggle="modal" data-bs-target="#read-more-' . $view->id . '"
                                    href="">Read More
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            ';
        }
        return response($output);
    }

    public function like(Request $request)
    {
        return response()->json([
            'idArticle' => $request->idPost
        ]);
    }
}