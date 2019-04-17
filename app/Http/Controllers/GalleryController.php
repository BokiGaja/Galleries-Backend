<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Http\Services\CreationService;
use App\Http\Services\GalleryService;
use App\Http\Services\PictureService;
use App\Http\Services\ValidationService;
use App\Picture;
use App\User;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Gallery::with('user', 'pictures')->orderBy('id', 'DESC')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = ValidationService::validateGallery($request);
        if (!is_string($validator)) {
            $newGallery = CreationService::createGallery($request);
            foreach ($request->images as $image) {
                CreationService::createPicture($image, $newGallery->id);
            }
        } else {
            return response()->json(['error' => $validator]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        return $gallery->with('user', 'pictures', 'comments')->find($gallery->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validator = ValidationService::validateGallery($request);
        if (!is_string($validator)) {
            foreach ($request->images as $image) {
                Picture::where('imageUrl', $image)->delete();
            }
            foreach ($request->images as $image) {
                CreationService::createPicture($image, $gallery->id);
            }

            $gallery->update($request->all());
        } else {
            return response()->json(['error' => $validator]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
    }
}
