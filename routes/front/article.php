<?php
// 教育快讯
Route::middleware(['web'])->group(function () {
    Route::match(['get', 'post'], '/front/article/news', [
        'uses' => '\App\Http\Front\Controllers\Article\NewsController@index'
    ])->name('front.news');
    Route::get('/front/article/news/{code}', [
        'uses' => '\App\Http\Front\Controllers\Article\NewsController@info'
    ])->name('front.news.info');
});
