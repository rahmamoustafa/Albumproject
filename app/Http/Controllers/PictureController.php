<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($album_id)
    {
        $album = Album::findOrFail($album_id);
        $all_albums = Album::all();
        $pictures = $album->pictures;

        return view('picture.show', ['album' => $album, 'pictures' => $pictures, 'all_albums' => $all_albums]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request, $id)
    {

        $album = Album::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'images' => 'required|image',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }
        $data = saveMultipleImages($request, 'images');
        foreach ($data as $i) {
            $album->pictures()->create([
                'name' => $i,
                'path' => 'images/' . $i,

            ]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy($picture)
    {
        $data = Picture::findOrFail($picture);
        $data->delete();
        return redirect()->back();
    }


    public function change_album(Request $request, $id)
    {
        $request;
        $picture = Picture::findOrFail($id);
        $album = Album::findOrFail($request->album);
        $picture->update(['album_id' => $request->album]);
        return redirect()->back();
    }

}
