<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $statusLike = Like::where('idPost', $request->idPost)->where('idUserLiked', $request->idUserLiked);
        if ($statusLike->count() > 0) {
            $statusLike->delete();
            return response()->json([
                'status' => 'unlike'
            ]);
        } else {
            $like = new Like();
            $like->idUserLiked = $request->idUserLiked;
            $like->idPost = $request->idPost;
            $like->save();
            return response()->json([
                'status' => 'like'
            ]);
        }
    }
}