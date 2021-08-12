<?php namespace Api\Http\Controllers;

use Api\Classes\ApiManager;

class Resources extends Controller
{
    public function index($version, $resource)
    {
        $model = ApiManager::instance()->get($resource);

        return $model::all();
    }

    public function show($version, $resource, $id)
    {
        $model = ApiManager::instance()->get($resource);

        return $model::find($id);
    }
}