<?php

    use Illuminate\Support\Facades\DB;
    use App\Models\Notification;

    if (session('loginid')) {
        $uservalue = DB::table('users')->where(['loginid' => session('loginid')])->get();

        foreach ($uservalue as $user) {
            $userid = $user->user_value_id;
        }
    }

    $url = "127.0.0.1:8000/";

    /**
    * ヘッダーの通知
    */

    $notification = new Notification();
    $notifications = $notification->notificationModelGet();
    $i = 0;
    foreach ($notifications as $noti) {
        $contentstop['notification_title'][$i] = $noti->notification_title;
        $contentstop['notification_img'][$i] = asset($noti->img);
        $i++;
    }
?>


<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/common.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/portal.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/post.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/nowemotion.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/attribute.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/genrepost.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/mypage.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/worksearch.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/workindetail.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/information.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/gojuon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/rankingconfig.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/statistics.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/js/gojuon.js') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/usersearch.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/adminpage.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/adminlink.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/setting.css') }}">
        <link rel="stylesheet" href="https://cdn.rawgit.com/jgthms/bulma/master/css/bulma.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/css/swiper.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="{{ $url }}datepicker/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css">
        <title>{{ $title }}</title>
    </head>

    <body>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{{ asset('assets/js/worksearchajax.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/usersearchajax.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/adminlink.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/contentstop.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/modal.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/workindetail.js') }}"></script>
        <script type="text/javascript" src="{{ $url }}datepicker/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="{{ $url }}datepicker/bootstrap-datepicker-1.9.0-dist/locales/bootstrap-datepicker.ja.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>      
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@next/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-1-1/js/6-1-1.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                    <ul class="navbar-nav navbar-light mr-auto">
                        <div class="container-fluid">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/top">トップページ</a>
                            </li>
                            <form class="d-flex">
                                <input class="form-control me-2" type="search" placeholder="キーワード検索" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">検索</button>
                            </form>
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="searchindetail" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    詳しく検索
                                </a>
                                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="searchindetail">
                                    <form class="px-4 py-3">
                                        <div class="row">
                                            <div class="col">
                                                <strong class="text-muted">作品名</strong>
                                                <div class="form-group">
                                                    <div class="text-center">
                                                        <input type="text" class="form-control" id="work" name="work" placeholder="作品名">
                                                    </div>
                                                </div>
                                                <strong class="text-muted">アーティスト名</strong>
                                                <div class="form-group">
                                                    <div class="text-center">
                                                        <input type="text" class="form-control" id="artist" name="artist" placeholder="アーティスト名">
                                                    </div>
                                                </div>
                                                <strong class="text-muted">キーワード</strong>
                                                <div class="form-group">
                                                    <div class="text-center">
                                                        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="キーワード">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <strong class="text-muted">作者名</strong>
                                                <div class="form-group">
                                                    <div class="text-center">
                                                        <input type="text" class="form-control" id="workname" name="workname" placeholder="作者名">
                                                    </div>
                                                </div>
                                                <strong class="text-muted">出版社</strong>
                                                <div class="form-group">
                                                    <div class="text-center">
                                                        <input type="text" class="form-control" id="publisher" name="publisher" placeholder="出版社">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <strong class="text-muted">五十音検索(文字をクリックで色が変わり、選択状態になります。複数選択可)</strong>
                                        @include('block.gojuonsearch')
                                        <div class="w-25 p-3 center-block text-center work-count font-weight-bold">
                                            25,5082 件
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="text-center searchbuttondivclass">
                                                <input onclick="searchajax()" type="button" id="searchbuttonid" class="btn btn-primary btn-block searchbuttonclass" value="検索">
                                            </div> 
                                        </div> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </ul>
                    <ul class="navbar-nav navbar-light ml-auto">
                        <div class="container-fluid">
                            <?php
                                $notifications = asset('assets/img/icon/top/notifications.jpg');
                            ?>
                            <li class="nav-item notification">
                                <a class="dropdown-toggle" href="#" id="notofication" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ $notifications }}" width="30" height="30">
                                </a>
                                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="notofication">
                                    @if(session('loginid'))
                                        <table class="table is-narrow">
                                            <tbody>
                                                @for ($i = 0;$i < count($contentstop['notification_title']);$i++)
                                                    <tr>
                                                        <td><img src="{{ $contentstop['notification_img'][$i] }}" class="notificationsclass" width="100" height="100"></td>
                                                        <td>{{ $contentstop['notification_title'][$i] }}</td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    @else
                                        ログインしてください
                                    @endif
                                </div>
                            </li>
                            @empty(session('loginid'))
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="/login">ログイン</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="/register">新規登録</a>
                                </li>
                            @else
                                @if($userid == 2)
                                    <li class="nav-item">
                                        <a class="nav-link" aria-current="page" href="/adminpage">管理者設定ページ</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" aria-current="page" href="/mypage">マイページ</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="#">ようこそ&nbsp;{{ session('loginid') }}さん</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="logout" aria-current="page" href="/logout">ログアウト</a>
                                </li>
                            @endempty
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/post">レビュー投稿</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/history">閲覧履歴</a>
                            </li>
                        </div>
                    </ul>
            </div>

            <script>
                var btn = document.getElementById('logout');

                btn.addEventListener('click',function() {
                    window.confirm('ログアウトしますか?');
                });
            </script>
        </nav>
    
        <style>
            .dropdown-menu {
                width: 650px;
                min-width: 20em;
            }
        </style>