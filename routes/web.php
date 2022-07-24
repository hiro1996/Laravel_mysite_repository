<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Middleware\ValidateSignature;


Auth::routes();

Route::match(['get','post'], '/top', 'App\Http\Controllers\Auth\LoginNewController@contentstop'); 

Route::post('/admincontentstop', 'App\Http\Controllers\AdminController@admincontentstop'); 

Route::get('/login', 'App\Http\Controllers\Auth\LoginNewController@login');

Route::get('/logout', 'App\Http\Controllers\Auth\LoginNewController@logout');

Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register');

// ログインIDをお忘れの場合画面
Route::get('/loginid_reset', 'App\Http\Controllers\Auth\ForgetController@forgetloginid');

// ログインID送信完了画面&メール送信
Route::post('/loginid_reset/complete', 'App\Http\Controllers\Auth\ForgetController@forgetloginidcomplete');

// パスワードをお忘れの場合画面
Route::get('/passwd_reset', 'App\Http\Controllers\Auth\ForgetController@forgetpass');

// パスワード送信完了画面&メール送信
Route::post('/passwd_reset/complete', 'App\Http\Controllers\Auth\ForgetController@forgetpasscomplete');

// リンククリック
Route::get('/passwd_reset/valid', 'App\Http\Controllers\Mail\MailController@forgetpassmailvalid')->name('passwd_reset.valid');

// 管理者用パスワード設定(新規作成)画面用URL送信
Route::get('/adminlink', 'App\Http\Controllers\AdminController@adminlink');

// 管理者用パスワード設定完了画面&メール送信
Route::post('/adminlink/complete', 'App\Http\Controllers\AdminController@adminlinkcomplete');

// リンククリック
Route::get('/admin_register/valid', 'App\Http\Controllers\AdminController@adminregister')->name('admin_authpage.valid');

// 管理者用パスワード設定完了
Route::get('/admin_register/complete', 'App\Http\Controllers\AdminController@adminregistercomplete');

// 期限切れ
Route::get('/invalid', 'App\Http\Controllers\Mail\MailController@invalidlink')->name('invalidlink');

Route::get('/attribute', 'App\Http\Controllers\MypageController@attribute');

Route::post('/attributecomplete', 'App\Http\Controllers\MypageController@attributecomplete');

Route::get('/work_search', 'App\Http\Controllers\WorkController@worksearch');

Route::post('/work_search/gojuonsearch', 'App\Http\Controllers\WorkController@worksearchajax');

Route::get('/work_history', 'App\Http\Controllers\WorkController@workhistory');

Route::get('/{url}/{url2}/{url3}', 'App\Http\Controllers\WorkController@workindetail');

Route::get('/mypage', 'App\Http\Controllers\MypageController@mypage');

Route::get('/stat', 'App\Http\Controllers\MypageController@statistics');

Route::get('/nickname_change', 'App\Http\Controllers\MypageController@nicknamechange');

Route::post('/nickname_change/complete', 'App\Http\Controllers\MypageController@nicknamechangecomplete');

Route::get('/passwd_change', 'App\Http\Controllers\MypageController@passwordchange');

Route::post('/passwd_change/complete', 'App\Http\Controllers\MypageController@passwordchangecomplete');

Route::get('/info', 'App\Http\Controllers\MypageController@information');

Route::get('/opinion', 'App\Http\Controllers\OpinionController@opinion');

Route::post('/opinion/conf', 'App\Http\Controllers\OpinionController@opinionconf');

Route::post('/opinion/complete', 'App\Http\Controllers\OpinionController@opinioncomplete');

Route::get('/setting', 'App\Http\Controllers\MypageController@setting');

Route::get('/nowemotion', 'App\Http\Controllers\NowemotionController@nowemotion');

Route::get('/post', 'App\Http\Controllers\PostController@post');

Route::post('/post/conf', 'App\Http\Controllers\PostController@postconf');

Route::post('/post/complete', 'App\Http\Controllers\PostController@postcomplete');

Route::get('/post_work_title', 'App\Http\Controllers\PostController@postworktitle');

Route::get('/rankingconfig', 'App\Http\Controllers\PortaltopController@rankingconfig');

Route::get('/user_search', 'App\Http\Controllers\AdminController@usersearch');

Route::get('/adminpage', 'App\Http\Controllers\AdminController@adminpage');

Route::post('/user_search/usersearch', 'App\Http\Controllers\AdminController@usersearchajax');

Route::get('/csv', 'App\Http\Controllers\AdminController@getcsv');

Route::get('/adminonetimepass', 'App\Http\Controllers\AdminController@adminonetimepass')->name('adminonetimepass');

Route::get('/adminaccount', 'App\Http\Controllers\AdminController@adminaccount');

Route::post('/adminaccount/setting', 'App\Http\Controllers\AdminController@adminaccountsetting');

Route::post('/mypage/setting', 'App\Http\Controllers\MypageController@mypagesetting');

Route::post('/contentstopmodal/complete', 'App\Http\Controllers\ModalController@contentstopmodalcomplete');

Route::post('/workindetail/favorite/add', 'App\Http\Controllers\WorkController@workindetailfavoriteadd');

Route::post('/workindetail/favorite/delete', 'App\Http\Controllers\WorkController@workindetailfavoritedelete');

Route::post('/genrepostcomplete', 'App\Http\Controllers\WorkController@workgenrepostcomplete');

Route::post('/workindetail/goodbutton/add', 'App\Http\Controllers\WorkController@workindetailgoodiconadd');

Route::post('/workindetail/goodbutton/delete', 'App\Http\Controllers\WorkController@workindetailgoodicondelete');

Route::get('/worksearchresult', 'App\Http\Controllers\WorkController@worksearchresult')->name('worksearchresult');

