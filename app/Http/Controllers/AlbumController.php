<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class AlbumController extends Controller
{
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
        $data = $this->getAllAlbums();
        $albums = $data['albums'];
        $count = $data['count'];
        return view('home', ['albums' => $albums, 'count' => $count]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('album.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect('/album/create')
                ->withErrors($validator)
                ->withInput();
        }
        Album::create(['name' => $request->name, 'user_id' => auth()->user()->id]);
        return redirect('/');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $res = Album::findOrFail($id);
        return view('album.edit')->with('album', $res);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $res = Album::findOrFail($id);
        $res->update(['name' => $request->name]);
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $res = Album::findOrFail($id);
        $res->delete();
        return redirect('/');
    }


    public function getAlbums(Request $request)
    {
        $user = auth()->user();
        $data = $user->albums;
        // helpers
        return getDataTables($request, $data);
    }




    /**
     * function to get all Albums
     */

    public function getAllAlbums()
    {
        $all_albums = Album::all();
        $array_albums = [];
        $count_pic = [];
        foreach ($all_albums as $album) {
            array_push($array_albums, $album->name);
            array_push($count_pic, $album->pictures->count());
        }
        return ['albums' => $array_albums, 'count' => $count_pic];
    }
}
