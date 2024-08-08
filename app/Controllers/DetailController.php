<?php

namespace App\Controllers;

use App\SessionGuard as Guard;
use App\Models\Image;

class DetailController extends Controller
{
    public function __construct()
    {
        if (!Guard::isUserLoggedIn()) {
            redirect('/login');
        }

        parent::__construct();
    }

    public function index($collectionId)
    {
        $collection = Guard::user()->collections->find($collectionId);
        if (!$collection) {
            $this->sendNotFound();
        }

        $images = Image::where('collection_id', $collectionId)->get();

        $this->sendPage('collections/detail', [
            'collection' => $collection,
            'images' => $images
        ]);
    }

    public function addToCollection($collectionId)
    {
        $collection = Guard::user()->collections->find($collectionId);
        if (!$collection) {
            $this->sendNotFound();
        }

        $data = $this->filterImagesData($_POST);
        $model_errors = Image::validate($data);
        if (empty($model_errors)) {
            $image = new Image();
            $image->fill($data);
            $image->collection()->associate($collection);
            $image->save();
        }
        redirect('/');
    }

    protected function filterImagesData(array $data)
    {
        return [
            'urls' => $data['urls'] ?? ''
        ];
    }

    public function removeFromCollection($collectionId, $imageId)
    {

        $collection = Guard::user()->collections->find($collectionId);
        if (!$collection) {
            $this->sendNotFound();
        }

        $image = $collection->image()->find($imageId);
        if (!$image) {
            $this->sendNotFound();
        }

        $image->delete();
        redirect('/mycollections/' . $collectionId);
    }
}
