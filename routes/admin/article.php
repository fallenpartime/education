<?php
// 文章
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::get('/admin/article/news', [
        'uses' => '\App\Http\Admin\Controllers\Article\ArticleController@news'
    ])->name('news');
    Route::match(['get', 'post'], '/admin/article/info', [
        'uses' => '\App\Http\Admin\Controllers\Article\OperateController@detail'
    ])->name('articleInfo');
    Route::match(['post'], '/admin/article/show', [
        'uses' => '\App\Http\Admin\Controllers\Article\OperateController@show'
    ])->name('articleShow');
});