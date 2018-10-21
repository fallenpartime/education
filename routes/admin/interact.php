<?php
// 用户意见
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::get('/admin/interact/admonitions', [
        'uses' => '\App\Http\Admin\Controllers\Interact\AdmonitionController@index'
    ])->name('admonitions');
    Route::post('/admin/interact/admonition/reply', [
        'uses' => '\App\Http\Admin\Controllers\Interact\AdmonitionController@reply'
    ])->name('admonitionReply');
});
