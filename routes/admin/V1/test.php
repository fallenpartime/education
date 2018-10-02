<?php

Route::get('/admin/test', [
    'as' => 'admintest',
    'uses' => '\App\Http\Admin\Controllers\Test\TestController@index'
])->middleware('admin.login.auth', 'admin.action.auth');

//$api->version('v1', function ($api) {
//    $api->get('helloworld', 'App\Api\Controllers\HelloController@index');
//});
