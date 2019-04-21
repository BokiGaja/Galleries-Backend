<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Http\Services\GalleryService;
use App\Http\Services\PictureService;
use App\Http\Services\ValidationService;
use App\Picture;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct(GalleryService $galleryService, PictureService $pictureService, ValidationService $validationService)
    {
        $this->galleryService = $galleryService;
        $this->pictureService = $pictureService;
        $this->validationService = $validationService;
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validationService->validateGallery($request);
        if (!is_string($validator)) {
            $newGallery = $this->galleryService->createGallery($request);
            foreach ($request->images as $image) {
                $this->pictureService->createPicture($image, $newGallery->id);
            }
            return response()->json($newGallery, 200);
        }

        return response()->json(['error' => $validator], 400);
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
            $validator = $this->validationService->validateGallery($request);
            if (!is_string($validator)) {
                foreach ($request->images as $image) {
                    Picture::where('gallery_id', $gallery->id)->delete();
                }
                foreach ($request->images as $image) {
                    $this->pictureService->createPicture($image, $gallery->id);
                }
                $gallery->update($request->all());
                return response()->json($gallery, 200);
            }
            return response()->json(['error' => $validator], 400);
        return response()->json(400);
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
