<?php
// 学校
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::get('/admin/districts', [
        'uses' => '\App\Http\Admin\Controllers\DistrictController@index'
    ])->name('districts');
    Route::match(['get', 'post'], '/admin/district/info', [
        'uses' => '\App\Http\Admin\Controllers\DistrictController@detail'
    ])->name('districtInfo');
    Route::match(['post'], '/admin/district/show', [
        'uses' => '\App\Http\Admin\Controllers\DistrictController@show'
    ])->name('districtShow');
});