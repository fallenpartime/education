<?php

$api->version('v1', function ($api) {
    $api->get('helloworld', 'App\Api\Controllers\HelloController@index');
});
