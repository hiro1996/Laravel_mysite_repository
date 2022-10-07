<?php
    $url = "127.0.0.1:8000/";
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
        <link rel="stylesheet" href="{{ asset('assets/css/usersearch.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/adminpage.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/adminlink.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/setting.css') }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/css/swiper.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="{{ $url }}datepicker/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css">
        <title>{{ $title }}</title>
    </head>

    <body>
        <script src="https://kit.fontawesome.com/01acc973a4.js" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> 
        <script type="text/javascript" src="https://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{{ asset('assets/js/worksearchajax.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/usersearchajax.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/clickmakingcsv.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/adminlink.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/contentstop.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/modal.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/workindetail.js') }}"></script>
        <script type="text/javascript" src="{{ $url }}datepicker/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="{{ $url }}datepicker/bootstrap-datepicker-1.9.0-dist/locales/bootstrap-datepicker.ja.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>      
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@next/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-1-1/js/6-1-1.js"></script>
        <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
        <script src="/js/vue/v-pagination.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    
