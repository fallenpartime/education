<?php
// 活动操作
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::match(['post'], '/admin/activity/show', [
        'uses' => '\App\Http\Admin\Controllers\Activity\OperateController@show'
    ])->name('activityShow');
    Route::match(['post'], '/admin/activity/remove', [
        'uses' => '\App\Http\Admin\Controllers\Activity\OperateController@remove'
    ])->name('activityRemove');
    Route::match(['post'], '/admin/activity/open', [
        'uses' => '\App\Http\Admin\Controllers\Activity\OperateController@open'
    ])->name('activityOpen');
});
// 投票问题
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::get('/admin/activity/questions', [
        'uses' => '\App\Http\Admin\Controllers\Activity\QuestionController@index'
    ])->name('questions');
    Route::match(['get', 'post'], '/admin/activity/question/info', [
        'uses' => '\App\Http\Admin\Controllers\Activity\QuestionController@info'
    ])->name('activityQuestionInfo');
});
// 网络投票活动
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::get('/admin/activity/polls', [
        'uses' => '\App\Http\Admin\Controllers\Activity\PollController@index'
    ])->name('polls');
    Route::match(['get', 'post'], '/admin/activity/poll/info', [
        'uses' => '\App\Http\Admin\Controllers\Activity\PollController@info'
    ])->name('activityPollInfo');
});
