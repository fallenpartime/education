<?php
Route::get('/admin/warn', [
    'as' => 'admin.warn',
    'uses' => '\App\Http\Admin\Controllers\Site\SiteController@warn'
]);
Route::get('/admin/login', [
    'uses' => '\App\Http\Admin\Controllers\Site\SiteController@login'
])->name('admin.login');
Route::get('/admin/check', [
    'uses' => '\App\Http\Admin\Controllers\Site\SiteController@check'
])->name('admin.check');
Route::get('/admin/qrcode', [
    'uses' => '\App\Http\Admin\Controllers\Site\SiteController@qrcode'
])->name('admin.qrcode');

Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::get('/admin/authorities', [
        'uses' => '\App\Http\Admin\Controllers\System\SystemController@authorities'
    ])->name('admin.authorities');
});
