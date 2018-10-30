<?php
// 验证
Route::middleware(['web'])->group(function () {
    // 扫码验证
    Route::match(['get', 'post'], '/wechat/oauth/scan', [
        'uses' => '\App\Http\Wechat\Controllers\Oauth\OauthController@scan'
    ])->name('wechat.oauth.scan');
    // 授权登录
    Route::match(['get', 'post'], '/wechat/oauth/redirect', [
        'uses' => '\App\Http\Wechat\Controllers\Oauth\OauthController@redirectTo'
    ])->name('wechat.oauth.redirect');
});
