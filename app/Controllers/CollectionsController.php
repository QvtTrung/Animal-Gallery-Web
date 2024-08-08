<?php

namespace App\Controllers;

use App\SessionGuard as Guard;
use App\Models\Collection;

class CollectionsController extends Controller
{
    public function __construct()
    {
        if (!Guard::isUserLoggedIn()) {
            redirect('/login');
        }

        parent::__construct();
    }

    public function index()
    {
        $this->sendPage('collections/index', [
            'collections' => Guard::user()->collections
            ]);
    }

    public function create()
    {
        $this->sendPage('collections/create', [
            'errors' => session_get_once('errors'),
            'old' => $this->getSavedFormValues()
        ]);
    }

    public function store()
    {
        $data = $this->filterCollectionData($_POST);
        $model_errors = Collection::validate($data);
        if (empty($model_errors)) {
            $collection = new Collection();
            $collection->fill($data);
            $collection->user()->associate(Guard::user());
            $collection->save();

            redirect('/mycollections');
        }

        // Lưu các giá trị của form vào $_SESSION['form']
        $this->saveFormValues($_POST);

        // Lưu các thông báo lỗi vào $_SESSION['errors']
        redirect('/collections/create', ['errors' => $model_errors]);
    }

    protected function filterCollectionData(array $data)
    {
        return [
            'name' => $data['name'] ?? '',
            'notes' => $data['notes'] ?? ''
        ];
    }

    public function edit($collectionId)
    {
        $collection = Guard::user()->collections->find($collectionId);
        if (! $collection) {
            $this->sendNotFound();
        }

        $form_values = $this->getSavedFormValues();
        $data = [
            'errors' => session_get_once('errors'),
            'collection' => ( !empty($form_values) ) ?
                array_merge($form_values, ['id' => $collection->id]) :
                $collection->toArray()
        ];
        $this->sendPage('collections/edit', $data);
    }

    public function update($collectionId)
    {
        $collection = Guard::user()->collections->find($collectionId);
        if (! $collection) {
            $this->sendNotFound();
        }

        $data = $this->filterCollectionData($_POST);
        $model_errors = Collection::validate($data);
        if (empty($model_errors)) {
            $collection->fill($data);
            $collection->save();
            redirect('/mycollections');
        }

        $this->saveFormValues($_POST);
        redirect('/collections/edit/'.$collectionId, [
            'errors' => $model_errors
        ]);
    }

    public function destroy($collectionId)
    {
        $collection = Guard::user()->collections->find($collectionId);
        if (! $collection) {
            $this->sendNotFound();
        }
        
        $collection->delete();
        redirect('/mycollections');
    }
}
