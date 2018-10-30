<?php
// 网络投票
Route::middleware(['web'])->group(function () {
    Route::match(['get', 'post'], '/front/activity/polls', [
        'uses' => '\App\Http\Front\Controllers\Activity\PollController@index'
    ])->name('front.polls');
    Route::get('/front/activity/poll/{code}', [
        'uses' => '\App\Http\Front\Controllers\Activity\PollController@info'
    ])->name('front.poll.info');
});
