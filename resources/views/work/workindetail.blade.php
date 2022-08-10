<?php
    $title = '作品詳細';
?>

@include('include.header')

<article class="columns p-4 m-0">

    @include('work.workmenu')

    <div class="column">
        @if ($workdata['ninkitag'])
            <div class="ninkitag">人気急上昇↑↑</div>
        @endif
        <strong class="worktitle">
            {{ $workdata['title'] }}
        </strong>
        <div class="worktitlefurigana">
            {{ $workdata['furigana'] }}
        </div>
        
        <article class="columns p-4 m-0 workindetailexplaining workindetailclass">    
            
            
            <div class="column is-6">
            
                <div class="thumbnailpic">
                    <img class="workdetailmainimg" src="{{ $workdata['img'] }}">
                </div>
                <div class="ranking">
                    <div class="monthlyranking d-flex justify-content-around">
                        <div class="monthlyrankingtitle">
                            月間人気ランキング  
                        </div>
                        <div class="monthlyrankingnum">
                            16位  
                        </div>
                    </div>
                    <div class="weeklyranking d-flex justify-content-around">
                        <div class="weeklyrankingtitle">
                            週間人気ランキング    
                        </div>
                        <div class="weeklyrankingnum">
                            16位  
                        </div>
                    </div>
                </div>
            </div>
            <div class="column">
                @if ($workdata['newtag'])
                <div class="mb-2">
                    <span class="tag is-danger">NEW</span>
                </div>
                @endif
                <dl>                
                    <dt>カテゴリ</dt>
                    <dd>{{ $workdata['workgenre'] }}</dd>
                    <dt>ジャンル</dt>
                    <dd>青年マンガ</dd>
                    <dt>出版社</dt>
                    <dd>{{ $workdata['publisher'] }}</dd>
                    <dt>掲載誌・レーベル</dt>
                    <dd>{{ $workdata['publicationmagazine_label'] }}</dd>
                    <dt>著者・作者</dt>
                    <dd>{{ $workdata['auther'] }}</dd>
                    <dt class="tags categorytag">
                        <span class="tag is-rounded is-medium is-primary">かっこいい</span>
                        <span class="tag is-rounded is-medium is-danger">面白い</span>
                        <span class="tag is-rounded is-medium is-warning">感動</span>
                        <span class="tag is-rounded is-medium is-link">情熱</span>
                    </dt>
                </dl>
            </div>
        </article>
        <br>
        <section class="icon-group">
            <table border="0">
                <tr>
                    <td>
                    <a href="#"><img src="{{ $workdata['amazonprime'] }}" width="50" height="35" alt="amazon prime"></a>
                    </td>
                    <td>
                    <a href="#"><img src="{{ $workdata['yahoocalender'] }}" width="50" height="35" alt="yahoo calender"></a>
                    </td>
                </tr>
            </table>
                       
            <div class="text-center">
                @if (session('loginid'))
                    <button type="submit" class="{{ $favoriteclass }}" id="favoritebutton">{{ $favoritetext }}</button>
                @else
                    <button type="submit" class="{{ $favoriteclass }}" id="favoritebutton" disabled>ログインするとお気に入り登録ができます</button>
                @endif
            </div>
        </section>

        @if ($workdata['explaining'])
        <article class="workindetailclass">
            <strong class="explain-abstract">概要</strong>
            <div class="explain-favoritebtn">
                <div class="explain">
                    {{ $workdata['explaining'] }}
                </div>
            </div>
        </article>
        @endif

        <div class="col eachbtn">
            <div class="form-group">
                <div class="text-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#genrepostmodal">ジャンル投票</button>
                </div>
            </div>
        </div>

        

        @if ($workdata['postbody'])
            @for ($i = 0;$i < count($workdata['postdate']);$i++)
                <div class="workindetailpost">
                    <div class="worknewdate">
                        投稿日：<span class="workindetailpostdate">{{ $workdata['postdate'][$i] }}</span>
                        <div class="posttitle">
                            <span class="workindetailposttitle">タイトルタイトルタイトルタイトルタイトルタイトルタイトル</span>
                        </div>
                        <p class="result-rating-rate">
                            <span class="star5_rating" data-rate="{{ $workdata['poststar'][$i] }}"></span>
                            <span class="number_rating">{{ $workdata['poststar'][$i] }}</span>
                        </p>
                        <div class="workreviewpostbody">
                            <span>{{ $workdata['postbody'][$i] }}</span>
                        </div>
                    </div>
                </div>
            @endfor
        @endif
    </div>




    <div class="row">
        <div class="col">

        </div>

        @include('block.endtitle')

        @include('include.footer')

        <div class="modal fade" id="genrepostmodal" tabindex="-1" role="dialog" aria-labelledby="genrepostmodal" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div id="modal-title">
                            <div class="text-center">ジャンル投票</div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <h5>Q1. あなたの思うこの作品のカテゴリーを選んで下さい。</h5>
                        <div class="row">
                            @for ($i = 1;$i <= count($workdata["category"][1]);$i++) <div class="col">
                                @foreach ($workdata["category"][1][$i] as $cate)
                                <div class="genrepost-word-post">
                                    <div class="form-check-post form-check-inline">
                                        <input class="form-check-input-post checkclass" type="checkbox" id="{{ $cate }}" name="genre" value="{{ $cate }}">
                                        <label class="form-check-label-post" for="{{ $cate }}">{{ $cate }}</label>
                                    </div>
                                </div>
                                @endforeach
                        </div>
                        @endfor
                    </div>

                    <h5>Q2. あなたの思うこの作品のイメージを選んで下さい。</h5>
                    <div class="row">
                        @for ($i = 1;$i <= count($workdata["category"][2]);$i++) <div class="col">
                            @foreach ($workdata["category"][2][$i] as $cate)
                            <div class="genrepost-word-post">
                                <div class="form-check-post form-check-inline">
                                    <input class="form-check-input-post checkclass" type="checkbox" id="{{ $cate }}" name="genre" value="{{ $cate }}">
                                    <label class="form-check-label-post" for="{{ $cate }}">{{ $cate }}</label>
                                </div>
                            </div>
                            @endforeach
                    </div>
                    @endfor
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-around">
                    <div class="form-group">
                        <div class="text-center">
                            <button id="genrepost" type="button" class="btn btn-primary btn-lg genrepost" data-dismiss="modal">投票</button>
                            <input type="hidden" class="workclass" id="worksubid" value="{{ $workdata['worksubid'] }}">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-around">
                    <div class="form-group">
                        <div class="text-center">
                            <button id="closeid" type="button" class="btn btn-primary" data-dismiss="modal">閉じる</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <script>
        $('#favoritebutton').click(function() {
            var chgbutton = document.getElementById('favoritebutton');
            var getregistersrc = location.pathname;
            var getregistertitle = document.getElementsByClassName('worktitle');

            if (chgbutton.className == 'btn btn-primary btn-block') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/workindetail/favorite/add",
                    type: "post",
                    data: {
                        url: getregistersrc,
                        title: getregistertitle[0].innerText
                    },
                    dataType: "json",

                }).done(function(response) {
                    chgbutton.className = 'btn btn-secondary btn-block';
                    chgbutton.innerText = 'お気に入りに登録済み';
                }).fail(function(failresponse) {})
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/workindetail/favorite/delete",
                    type: "post",
                    data: {
                        url: getregistersrc,
                        title: getregistertitle[0].innerText
                    },
                    dataType: "json",

                }).done(function(response) {
                    chgbutton.className = 'btn btn-primary btn-block';
                    chgbutton.innerText = 'お気に入りに登録';
                }).fail(function(failresponse) {})
            }
        })
    </script>

    <script>
        let maxid = document.getElementById("maxid");

        for (let i = 1; i <= maxid.value; i++) {
            $('#goodid' + i).click(function() {
                let workid = document.getElementById("workid");
                let reviewid = document.getElementById("reviewid" + i);
                let goodid = document.getElementById("goodid" + i);
                let goodurlid = document.getElementById("goodurlid" + i);

                if (goodid.className == 'beforeclick' + i) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        //DBから検索結果を取得
                        url: "/workindetail/goodbutton/add",
                        type: "post",
                        data: {
                            workid: workid.value,
                            reviewid: reviewid.value,
                        },
                        dataType: "json",
                    }).done(function(response) {
                        let countid = document.getElementById("countid" + i);
                        let goodurlid = document.getElementById("goodurlid" + i);
                        let goodid = document.getElementById("goodid" + i);
                        goodid.className = 'afterclick' + i;
                        countid.innerText = response["count"];
                        goodurlid.src = response["icon"];
                    }).fail(function(failresponse) {
                        console.log("エラ〜");
                    })
                } else { //pushが含まれていない→アイコン黄(クリック済み)
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        //DBから検索結果を取得
                        url: "/workindetail/goodbutton/delete",
                        type: "post",
                        data: {
                            workid: workid.value,
                            reviewid: reviewid.value,
                        },
                        dataType: "json",
                    }).done(function(response) {
                        let countid = document.getElementById("countid" + i);
                        let goodurlid = document.getElementById("goodurlid" + i);
                        let goodid = document.getElementById("goodid" + i);
                        goodid.className = 'beforeclick' + i;
                        countid.innerText = response["count"];
                        goodurlid.src = response["icon"];
                    }).fail(function(failresponse) {
                        console.log("エラ〜");
                    })
                }
            })
        }
    </script>