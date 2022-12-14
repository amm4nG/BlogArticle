<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::latest('id')->get();
        return view('artikel', compact(['artikel']));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'image' => 'mimes:png,jpg,jpeg'
        ]);

        // error
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);
        } else {
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('uploads');
            } else {
                $path = '';
            }
            $artikel = new Artikel();
            $artikel->description = $request->description;
            // $artikel->date = date('d F Y, h:i:s A');
            $artikel->image = $path;
            $artikel->save();
            return response()->json([
                'image' => $path,
                'success' => 'Upload Artikel Berhasil'
            ]);
        }
    }
}