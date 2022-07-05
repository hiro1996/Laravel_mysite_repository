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
                @for ($i = 1;$i <= count($contentstop["attributes"]["q_explain"]);$i++) <div class="modal-class" id='{{ $contentstop["attributes"]["modalshow_id_name"][$i] }}'>
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
<section class="columns p-4 m-0">
    <div class="submenu column is-4">
        <aside class="notification is-info is-light">
            <div class="mb-2">
                <span class="tag is-danger">News</span>
            </div>
            <div>
                Bulma の使い方 日本語ドキュメントを公開しました！
            </div>
        </aside>
        <aside class="box menu">
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

        <article class="box media allusersection" id="allusersection">
            <div class="p-3 contentstop-container">
                <article class="card-body">
                    <h2 class="card-title text-center mb-4 mt-1">
                        <div class="contentstoptitle" id="contentstoptitle">{{ $contentstop['table_title'] }}</div>
                    </h2>
                    @if(!empty($contentstop['button_name']))
                    <div class="d-flex justify-content-around">
                        <span>{{ $rankingtitleleft }}</span>
                        <span>{{ $rankingtitleright }}</span>
                        <button type="button" class="btn btn-primary" id="rankingbutton">{{ $contentstop['button_name'] }}</button>
                    </div>
                    @endif
                    <br>
                    <div class="card alluser" id="alluser">
                        <div id="filmtable" class="tab-pane active">
                            <ul class="contenttopworklist-ul">
                                @for ($i = 0;$i <= 2;$i++) <li class="contenttopworklist-li">
                                    <a href="{{ $contentstop['workall_url'][$i] }}">
                                        <img src="{{ $contentstop['workall_img'][$i] }}" alt="{{ $contentstop['workall_img'][$i] }}" width="200" height="150">
                                        <div class="worktitlename">
                                            {{ $contentstop['workall_title'][$i] }}
                                        </div>
                                    </a>
                                    </li>
                                    @endfor
                            </ul>
                        </div>
                    </div>


                    <div class="card myuser" id="myuser">
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
                            @for ($i = 0;$i < count($contentstop['worktype_list']);$i++) <ul id="{{ $contentstop['id_list'][$i] }}">
                                <li class="is-{{ $contentstop['active_list'][$i] }}">
                                    <a>
                                        <span class="icon is-small">
                                            <i class="fas fa-desktop" aria-hidden="true"></i>
                                        </span>
                                        <span>{{ $contentstop['tab_list'][$i] }}</span>
                                    </a>
                                </li>
                                </ul>
                                @endfor
                        </div>
                        <div class="tab-content">
                            @for ($i = 0;$i < count($contentstop['worktype_list']);$i++) <div id="{{ $contentstop['id_list'][$i] }}" class="tab-pane {{ $contentstop['active_list'][$i] }}">
                                <article class="card-body">
                                    <div class="p-3">
                                        <div class="d-flex justify-content-around">
                                            @for ($j = 0;$j < count($contentstop["work_img"][$i]);$j++) <a href="{{ $contentstop['work_url'][$i][$j] }}">
                                                <div class="p-2">
                                                    <img src="{{ $contentstop['work_img'][$i][$j] }}" alt="{{ $contentstop['work_img'][$i][$j] }}" width="90" height="120">
                                                    <div class="worktitlename">
                                                        {{ $contentstop['work_title'][$i][$j] }}
                                                    </div>
                                                </div>
                                                </a>
                                                @endfor
                                        </div>
                                    </div>
                                </article>
                                @endfor
                        </div>
                        @endempty
                    </div>
                </article>
            </div>
        </article>

        @if ($contentstop["recentcheck_img"])
        <section class="box media recentcheck">
            <div class="workcheck" id="workcheck">
                <h2 class="card-title text-center mb-4 mt-1">最近チェックした作品</h2>
            </div>
            <div class="contentstop-container">
                <article class="check">
                    <div class="p-3">
                        <div class="d-flex justify-content-around">
                            @for ($i = 0;$i < count($contentstop["recentcheck_img"]);$i++) 
                            <div class="p-2">
                                <img src="{{ $contentstop['recentcheck_img'][$i] }}" width="90" height="120">
                            </div>
                            @endfor
                        </div>
                    </div>
                </article>
            </div>
        </section>
        @endif
    </div>
</section>


@include('include.footer')

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