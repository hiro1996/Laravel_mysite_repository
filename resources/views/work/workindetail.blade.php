<?php
$title = '作品詳細';
$img = asset($workdata['img']);

/**
 * get genre from url
 */
$url = url()->current();
$genre = explode('/', $url);
//$genre = $genre[4];
?>

@include('include.header')

<?php
$thumbnail_top = asset('assets/img/icon/top/thumbnail_top.png');
?>
<article class="columns p-4 m-0">
    
    @include('work.workmenu')

    <div class="column">
        <div class="ninkitag">人気急上昇↑↑</div>
        <strong class="worktitle">
            {{ $workdata['title'] }}
        </strong>
        <div class="worktitlefurigana">
            {{ $workdata['furigana'] }}
        </div>
        <article class="columns p-4 m-0 workindetailexplaining workindetailclass">       
            <div class="column is-6">
                <div class="thumbnailpic">
                    <img class="workdetailmainimg" src="{{ $img }}">
                </div>
                <div class="ranking">
                    <div class="monthlyranking d-flex justify-content-around">
                        <div class="monthlyrankingtitle">
                            月間ランキング  
                        </div>
                        <div class="monthlyrankingnum">
                            16位  
                        </div>
                    </div>
                    <div class="weeklyranking d-flex justify-content-around">
                        <div class="weeklyrankingtitle">
                            週間ランキング    
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
                        <span class="tag is-rounded is-medium is-primary">primary</span>
                        <span class="tag is-rounded is-medium is-danger">primary</span>
                        <span class="tag is-rounded is-medium is-warning">primary</span>
                        <span class="tag is-rounded is-medium is-link">primary</span>
                    </dt>
                </dl>
            </div>
        </article>

        <article class="workindetailclass">
            <strong class="explain-abstract">概要</strong>
            <div class="explain-favoritebtn">
                <div class="explain">
                    {{ $workdata['explaining'] }}
                </div>
            </div>
        </article>

        <div class="col table-category">
            <table border="1" width="200" height="60">
                <tr>
                    <td id="category1">{{ $workdata["genrepostanswers"][1][0] ?? '-' }}</td>
                    <td id="category2">{{ $workdata["genrepostanswers"][1][1] ?? '-' }}</td>
                </tr>
                <tr>
                    <td id="image1">{{ $workdata["genrepostanswers"][2][0] ?? '-' }}</td>
                    <td id="image2">{{ $workdata["genrepostanswers"][2][1] ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="col eachbtn">
            <div class="form-group">
                <div class="text-center">
                    @if (session('loginid'))
                    <button type="submit" class="{{ $favoriteclass }}" id="favoritebutton">{{ $favoritetext }}</button>
                    @else
                    <p class="text-danger">※ログインしてください
                        <button type="submit" class="{{ $favoriteclass }}" id="favoritebutton" disabled>{{ $favoritetext }}</button>
                    </p>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#genrepostmodal">ジャンル投票</button>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <canvas id="goodtimescanvas"></canvas>
            </div>
        </div>
        <br>
        <?php
        $amazon = asset('assets/img/icon/workindetail/amazonprime.png');
        $yahoo = asset('assets/img/icon/workindetail/yahoo.png');
        ?>
        <div class="row">
            <div class="col icon-otherpage">
                <a href="#"><img src="{{ $amazon }}" width="75" height="50" alt="amazon prime"></a>
                <span class="icontitle">Amazon Prime</span>
            </div>
            <div class="col icon-otherpage">
                <a href="#"><img src="{{ $yahoo }}" width="75" height="50" alt="yahoo calender"></a>
                <span class="icontitle">Yahoo Calender</span>
            </div>
        </div>


        @if (count($workdata['posts']) != 0)
        <?php $count = 1; ?>
        @foreach ($workdata['posts'] as $post)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        {{ $post->loginid }}
                    </div>
                    <div class="col">
                        レビュータイトル
                    </div>
                </div>
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col">
                        {{ $post->poststar }}
                    </div>
                    <div class="col">
                        {{ $post->postbody }}
                    </div>
                    <div class="col">
                        <button type="submit" id="goodid{{ $count }}" class="{{ $workdata['forurljudgeclass'][$count] }}"><img src="{{ $workdata['goodiconurl'][$count] }}" id="goodurlid{{ $count }}" class="goodurlclass{{ $count }}" width="20" height="20"></button><span id="countid{{ $count }}" class="countclass{{ $count }}">{{ $workdata["count"][$count] }}</span>
                        <input type="hidden" class="reviewclass{{ $count }}" id="reviewid{{ $count }}" value="{{ $count }}">
                        <input type="hidden" class="maxclass{{ $count }}" id="maxid" value="{{ count($workdata['posts']) }}">
                    </div>
                </div>
            </div>
        </div>
        <br>
        <?php $count++; ?>
        @endforeach
        @else
        <div class="nopost">
            レビューはありません。
        </div>
        @endif
    </div>
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
        var goodtimescanvas = document.getElementById('goodtimescanvas').getContext('2d');
        var myChart = new Chart(goodtimescanvas, {
            type: 'bar',
            data: {
                labels: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
                datasets: [{
                    label: 'ログイン回数',
                    data: [12, 19, 3, 17, 6, 3, 7, 8, 1, 2, 3],
                    backgroundColor: "rgba(23,15,151,0.4)"
                }]
            }
        });
    </script>

    <script>
        $("#closeid").click(function() {
            let checkbox = document.getElementsByClassName("checkclass");
            for (i = 0; i < checkbox.length; i++) {
                checkbox[i].checked = false;
            }
        });

        $('#genrepost').click(function() {
            let genrepost = document.getElementsByName("genre");
            let workid = document.getElementById("worksubid");
            genrepostcount = [];
            for (let i = 0; i < genrepost.length; i++) {
                if (genrepost[i].checked) {
                    genrepostcount.push(genrepost[i].value);
                }
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                //DBから検索結果を取得
                url: "/genrepostcomplete",
                type: "post",
                data: {
                    genrepost: genrepostcount,
                    workid: workid.value,
                },
                dataType: "json",
            }).done(function(response) {
                let category1 = document.getElementById("category1");
                let category2 = document.getElementById("category2");
                let image1 = document.getElementById("image1");
                let image2 = document.getElementById("image2");
                category1.innerText = response["genrepostdata"][1][0];
                category2.innerText = response["genrepostdata"][1][1];
                image1.innerText = response["genrepostdata"][2][0];
                image2.innerText = response["genrepostdata"][2][1];
            }).fail(function() {})
            console.log("エラ〜");
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