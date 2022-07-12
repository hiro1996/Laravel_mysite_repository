<?php
$title = 'トップページ';
?>

@include('include.header')

<div class="main box carousel-bg">
    <section class="p-5 mb-2 field text-black">
        <div class="notification is-info is-light">
            <div class="mb-2">
                <span class="tag is-danger">News</span>
            </div>
            <div>
                Bulma の使い方 日本語ドキュメントを公開しました！
            </div>
        </div>
        <div class="new-info">
            <h3 class="my-1">新着情報</h3>
            <div class="carousel slide" id="sample" data-ride="carousel">

            </div>
        </div>
    </section>

    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#configid">Modal Open</button>

    <div class="modal fade" id="configid" tabindex="-1" role="dialog" aria-labelledby="configid" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                @for ($i = 1;$i <= count($contentstop["attributes"]["q_explain"]);$i++) 
                <div class="modal-class" id='{{ $contentstop["attributes"]["modalshow_id_name"][$i] }}'>
                    <div class="modal-header">
                        @include('block.modaltitle')
                        @include('block.modalendtitle')
                    </div>
                    <div class="modal-body">
                        @include('modal.rankingconfigbody')
                    </div>
                    <div class="modal-footer">
                        @include('modal.rankingconfigfooter')
                    </div>
            </div>
            <input type="hidden" id="count" value="{{ count($contentstop['attributes']['q_explain']) }}">
            @endfor
        </div>
    </div>

    <div class="modal fade" id="configcompleteid" tabindex="-1" role="dialog" aria-labelledby="configid" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modalcomplete-body-sub">
                    <div class="modal-header">
                        <div class="text-center">
                            登録完了
                        </div>
                    </div>
                    <div class="modal-body">
                        登録、ありがとうございます。変更したい場合は、マイページから変更してください。
                    </div>
                    <div class="modal-footer">
                        <button id="modalcompletebutton" type="button" class="btn btn-primary btn-lg" data-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php
$thumbnail_top = asset('assets/img/icon/top/thumbnail_top.png');
?>
<article class="columns p-4 m-0">
    <div class="submenu column is-3">
        <aside class="article-shadow notification is-info is-light">
            <div class="mb-2">
                <span class="tag is-danger">News</span>
            </div>
            <div>
                ガチャを回しておすすめ作品を見ましょう
            </div>
        </aside>
        <aside class="article-shadow menu">
            <p class="menu-label">
                サービス
            </p>
            <ul class="menu-list">
                <li><a href="#">システム開発</a>
                    <ul>
                        <li><a href="#">基幹業務システム構築</a></li>
                        <li><a href="#">Webシステム構築</a></li>
                        <li><a href="#">データベース設計・構築</a></li>
                    </ul>
                </li>
                <li><a href="#">ソリューション</a></li>
                <li><a href="#">アウトソーシング</a></li>
                <li><a href="#">セミナー・研修</a></li>
            </ul>
            <p class="menu-label">
                パッケージ
            </p>
            <ul class="menu-list">
                <li><a href="#">ERP</a></li>
                <li><a href="#">Web決済システム</a></li>
                <li><a href="#">AIチャットボット</a></li>
            </ul>
            <p class="menu-label">
                コミュニティ
            </p>
            <ul class="menu-list">
                <li><a href="#">コメント</a></li>
                <li><a class="is-active" href="#">掲示板</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </aside>
    </div>

    <div class="column">
        <?php
        $rankingtitleleft = '';
        $rankingtitleright = '';
        ?>

        <section class="article-shadow allusersection" id="allusersection">
            <div class="p-3 contentstop-container">
                <div class="ranking">
                    <div class="contentstoptitle" id="contentstoptitle"><span class="contentstopbigtitle">{{ $contentstop['table_title'] }}</span></div>
                    @if(!empty($contentstop['button_name']))
                    <div class="d-flex justify-content-around">
                        <span>{{ $rankingtitleleft }}</span>
                        <span>{{ $rankingtitleright }}</span>
                        <button type="button" class="btn btn-primary" id="rankingbutton">{{ $contentstop['button_name'] }}</button>
                    </div>
                    @endif
                    <br>
                    <div class="alluser" id="alluser">
                        <div id="filmtable" class="tab-pane active">
                            <ul class="contenttopworklist-ul">
                                @for ($i = 0;$i <= 2;$i++) 
                                    <li class="contenttopworklist-li">
                                        <a href="{{ $contentstop['workall_url'][$i] }}">
                                            <img class="rankingimg" src="{{ $contentstop['workall_img'][$i] }}" alt="{{ $contentstop['workall_img'][$i] }}">
                                            <div class="worktitlename">
                                                {{ $contentstop['workall_title'][$i] }}
                                            </div>
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>


                    <div class="myuser" id="myuser">
                        @empty(session('loginid'))
                        <!--ログインしていない人-->
                        <div class="form-group">
                            <div class="text-center">
                                ログインすると見られるようになります。
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <a href="/login" class="btn btn-primary">ログイン</a>
                            </div>
                        </div>
                        @else
                        <!--ログインしている人-->
                        <div class="tabs is-centered">
                            <ul class="nav nav-tabs">
                                @for ($i = 0;$i < count($contentstop['worktype_list']);$i++) 
                                    <li class="nav-item">
                                        <a href="#{{ $contentstop['id_list'][$i] }}" class="nav-link {{ $contentstop['active_list'][$i] }}" data-toggle="tab">
                                            <span class="icon is-small">
                                                <i class="fas fa-{{ $contentstop['icon_list'][$i] }}" aria-hidden="true"></i>
                                            </span>
                                            <span>{{ $contentstop['tab_list'][$i] }}</span>
                                        </a>
                                    </li>
                                @endfor
                            </ul>
                        </div>

                        <div class="tab-content">
                            @for ($i = 0;$i < count($contentstop['worktype_list']);$i++) 
                            <div class="tab-pane {{ $contentstop['active_list'][$i] }}" id="{{ $contentstop['id_list'][$i] }}">
                                <article class="contents">
                                    <div class="p-3">
                                        <div class="d-flex justify-content-around">
                                            @for ($j = 0;$j < count($contentstop["work_img"][$i]);$j++) 
                                                <a href="{{ $contentstop['work_url'][$i][$j] }}">
                                                <div class="p-2">
                                                    <img src="{{ $contentstop['work_img'][$i][$j] }}" alt="{{ $contentstop['work_img'][$i][$j] }}" width="90" height="120">
                                                    <div class="worktitlename">
                                                        <span>{{ $contentstop['work_title'][$i][$j] }}</span>
                                                    </div>
                                                </div>
                                                </a>
                                            @endfor
                                        </div>
                                    </div>
                                </article>
                            </div>
                            @endfor
                        </div>
                        @endempty
                    </div>
                </div>
            </div>
        </section>

        @if ($contentstop["recentcheck_img"])
        <section class="article-shadow recentcheck">
            <div class="contentstop-container">
                <div class="p-3 contentstoptitle" id="contentstopcheck"><span class="contentstopbigtitle">最近チェックした作品</span></div>
                <div class="contentstop-container">
                    <article class="check">
                        <div class="p-3">
                            <div class="d-flex justify-content-around">
                                @for ($i = 0;$i < count($contentstop["recentcheck_img"]);$i++) 
                                    <div class="worknewdate">
                                        {{ $contentstop['worknew_date'][$i] }}
                                        <img class="recentimg" src="{{ $contentstop['recentcheck_img'][$i] }}">
                                        <div class="worktitlename">
                                            <b>{{ $contentstop['worknew_title'][$i] }}</b>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        @endif

        <section class="article-shadow ninki">
            <div class="contentstop-container">
                <div class="p-3 contentstoptitle" id="contentstopreserve"><span class="contentstopbigtitle">人気急上昇</span></div>
                <div class="contentstop-container">
                    <article class="check">
                        <div class="p-3">
                            <div class="d-flex justify-content-around">
                                @for ($i = 0;$i < count($contentstop["worknew_img"]);$i++)
                                    <div class="worknewdate">
                                        {{ $contentstop['worknew_date'][$i] }}
                                        <img class="reserveimg" src="{{ $contentstop['worknew_img'][$i] }}">
                                        <div class="worktitlename">
                                            <b>{{ $contentstop['worknew_title'][$i] }}</b>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="article-shadow reservation">
            <div class="contentstop-container">
                <div class="p-3 contentstoptitle" id="contentstopreserve"><span class="contentstopbigtitle">新着作品</span></div>
                <div class="contentstop-container">
                    <article class="check">
                        <div class="p-3">
                            <div class="d-flex justify-content-around">
                                @for ($i = 0;$i < count($contentstop["worknew_img"]);$i++)
                                    <div class="worknew">
                                        <div class="worknewdate">{{ $contentstop['worknew_date'][$i] }}</div>
                                        <a href="{{ $contentstop['worknew_url'][$i] }}">
                                        <img class="newimg" src="{{ $contentstop['worknew_img'][$i] }}">
                                        <div class="worktitlename">
                                            <b>{{ $contentstop['worknew_title'][$i] }}</b>
                                        </div>
                                        </a>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="article-shadow review">
            <div class="contentstop-container">
                <div class="p-3 contentstoptitle" id="contentstopreview"><span class="contentstopbigtitle">今日のレビューレポート</span></div>
                <div class="contentstop-container">
                    <article class="check">
                        <div class="p-3">
                            <div class="d-flex justify-content-around">
                                @for ($i = 0;$i < count($contentstop["worknew_img"]);$i++)
                                    <div class="worknewdate">
                                        {{ $contentstop['worknew_date'][$i] }}
                                        <img class="newimg" src="{{ $contentstop['worknew_img'][$i] }}">
                                        <div class="worktitlename">
                                            <b>{{ $contentstop['worknew_title'][$i] }}</b>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="article-shadow campaign">
            <div class="contentstop-container">
                <div class="p-3 contentstoptitle" id="contentstopcampaign"><span class="contentstopbigtitle">キャンペーン等</span></div>
                <div class="contentstop-container">
                    <article class="check">
                        <div class="p-3">
                            <div class="d-flex justify-content-around">
                                @for ($i = 0;$i < count($contentstop["worknew_img"]);$i++)
                                    <div class="worknewdate">
                                        {{ $contentstop['worknew_date'][$i] }}
                                        <img class="newimg" src="{{ $contentstop['worknew_img'][$i] }}">
                                        <div class="worktitlename">
                                            <b>{{ $contentstop['worknew_title'][$i] }}</b>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

    </div>
</article>


@include('include.footer')
<script>
    $('.tabsjsclass').click(function() {
        $('.contentsjs').not($('.tabsjsclass').attr('id')).hide();
    })
</script>


<script type="text/javascript">
    let count = document.getElementById('count');
    /*
     * 質問モーダルの2つ目以降は非表示 
     * 次へボタンを初期非表示
     */
    $('#show1').show();
    for (let i = 2; i <= count.value; i++) {
        $('#show' + i).hide();
    }
    $('#modalcomplete').hide();

    for (let i = 1; i <= count.value; i++) {
        $('#idnext' + i + '').hide();
    }

    $(function() {
        /*
         * 次へボタン押下で、次の質問モーダル表示 
         * 前へボタン押下で、前の質問モーダル表示 
         */
        for (let i = 1; i < count.value; i++) {
            $('#idnext' + i + '').click(function() {
                $('.modal-class').not($(this).attr('id')).hide();
                $('.modal-body-sub').show();
                $('#show' + (i + 1)).show();
            })
        }

        for (let i = count.value; i > 1; i--) {
            $('#idprevious' + i + '').click(function() {
                $('.modal-class').not($(this).attr('id')).hide();
                $('.modal-body-sub').show();
                $('#show' + (i - 1)).show();
            })
        }
    })

    /*
     * 何かしらの質問チェックで次へボタンを出現
     */
    function chkButton($chk) {
        for (i = 1; i <= count.value; i++) {
            if ($chk == 'check' + i) {
                chkList = [];
                let getCheck = document.getElementsByClassName('checkattr' + i);
                for (let i = 0; i < getCheck.length; i++) {
                    if (getCheck[i].checked) {
                        chkList.push(getCheck[i].id);
                    }
                }
                if (chkList.length > 0) {
                    $('#idnext' + i + '').show();
                } else {
                    $('#idnext' + i + '').hide();
                }
            }
        }
    }


    $('.completebutton').click(function() {
        let getradio = $("input[type='radio']").filter(":checked");
        let getcheck = $("input[type='checkbox']").filter(":checked");
        let gettext = $("input[type='text']");

        getchecklist = [];
        gettypelist = [];
        gettextidlist = [];
        for (let i = 0; i < getradio.length; i++) {
            getchecklist.push(getradio[i].value);
            gettypelist.push(1);
            gettextidlist.push("NONE");
        }
        for (let i = 0; i < getcheck.length; i++) {
            getchecklist.push(getcheck[i].value);
            gettypelist.push(2);
            gettextidlist.push("NONE");
        }
        for (let i = 0; i < gettext.length; i++) {
            getchecklist.push(gettext[i].id);
            gettypelist.push(3);
            gettextidlist.push(gettext[i].value);
        }
        console.log(getchecklist);
        console.log(gettypelist);
        console.log(gettextidlist);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //DBから検索結果を取得
            url: "/contentstopmodal/complete",
            type: "post",
            data: {
                modals: getchecklist,
                type: gettypelist,
                id: gettextidlist
            },
            dataType: "json",
        }).done(function(response) {
            $('#configid').modal('hide');
            $('#configcompleteid').modal('show');
            $('.modalcomplete-body-sub').show();
        }).fail(function(failresponse) {
            console.log("エラー");
        })
    })



    //$('#datepicker').datepicker();

    //イベントリスナーを登録 changeはテキストからフォーカスが外れた時に発生、inputはテキストに値を入れるたびに発生
    var gettext = document.querySelector('[id = "date"]');
    gettext.addEventListener("input", function() {
        if (this.value.length > 0) {
            $('#idnext2').show();
        } else {
            $('#idnext2').hide();
        }
    });
</script>