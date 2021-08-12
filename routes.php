<?php namespace Api;

use Route;

Route::group([
    'prefix' => '/api/{version}',
    'namespace' => 'Api\Http\Controllers',
], function () {

    Route::get('meta', function ($version) {
        return [
            'version' => $version,
        ];
    });

    Route::get('{resource}', 'Resources@index');

    Route::get('{resource}/{id}', 'Resources@show');

});