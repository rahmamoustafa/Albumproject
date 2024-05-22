<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumResource;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AlbumController extends Controller
{

    function __construct()
    {
        return $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::all();
        $albums =  AlbumResource::collection($albums);
        return sendResponse($albums, 'list of albums');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $inputs = $request->all();
            $validator = Validator::make($inputs, [
                'name' => 'required|max:255',
            ]);
            if ($validator->fails()) {
                return sendError('complelte inputs required', $validator->errors());
            }
            $inputs['user_id'] = auth()->user()->id;
            $res = Album::create($inputs);
            return sendResponse(new AlbumResource($res), 'data is inserted successfully!');
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show($album)
    {
        $res = Album::find($album);

        if ($res) return sendResponse(new AlbumResource($res), 'data found');

        return sendError('data not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        try {
            $inputs = $request->all();
            $validator = Validator::make($inputs, [
                'name' => 'required|max:255',
            ]);
            if ($validator->fails()) {
                return sendError('complelte inputs required', $validator->errors());
            }
            $album->update($inputs);
            $album->save();
            return sendResponse(new AlbumResource($album), 'data is updated successfully!');
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        $album->delete();
        return sendResponse($album, 'data is deleted successfully!');
    }
}
