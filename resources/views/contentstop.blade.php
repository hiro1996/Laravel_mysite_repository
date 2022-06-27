<?php
    $title = 'トップページ';
?>

@include('include.header')

    <div class="p-5 mb-2 carousel-bg text-black">
        <h3 class="my-1">新着情報</h3>
        <div class="column is-full has-background-primary">
            <div class="carousel slide" id="sample" data-ride="carousel">
            
            </div>
        </div>
    </div>

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
                @endfor
            </div>
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

    <section class="ad">
        <div class="p-5 columns">
            <div class="column is-two-fifths">
                <div class="text-center">
                お家で何を見よう？自分にとってのおすすめの映画、おすすめの漫画、おすすめのアニメって何だろう？そんな疑問はありませんか？<br>
                本サイトは自分がどんなアニメ、漫画、映画を見たいかのおすすめを教えてくれるサイトです。<br>
                さらに、見た作品について「ここが面白い！」という感想があれば、「レビュ-投稿する」でレビュー投稿して、<br>
                その作品の面白さを他のユーザーに端的に知らせてあげよう！ネタバレはやめてね！<br>
                今週の全ユーザーおすすめランキングには、レビュー投稿された作品の面白度合いをポイント化してランキングを表示するよ！<br>
                あなたのおすすめランキングには、自分が気になるタグを設定しておくと、それに応じたおすすめランキングを表示するよ！<br>
                </div>
            </div>
            <div class="column is-three-fifths">
                <div class="card">
                    あああああ
                </div>
            </div>
        </div>
    </section>
        
    <?php
        $rankingtitleleft = '';
        $rankingtitleright = '';
    ?>
    
    <section class="allusersection" id="allusersection">
        <div class="contentstop-container">
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
                            @for ($i = 1;$i <= 6;$i++)
                                <li class="contenttopworklist-li">
                                    <a href="/work_indetail/{{ $contentstop['workfilm_url'][$i] }}">
                                        <img src="{{ $contentstop['workfilm_img'][$i] }}" alt="{{ $contentstop['workfilm_img'][$i] }}" width="200" height="150">
                                        <div class="worktitlename">
                                            {{ $contentstop['workfilm_title'][$i] }}
                                        </div>
                                    </a>
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>


            <div class="card myuser" id="myuser">
                <?php $film = "映画"; ?>
                <?php $comic = "漫画"; ?>
                <?php $anime = "アニメ"; ?>
                @empty(session('loginid')) <!--ログインしていない人-->
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
                @else <!--ログインしている人-->
                    <ul class="nav nav-tabs">
                        @isset($film)
                            <li class="nav-item">
                                <a href="#recommendfilmtable" class="nav-link" data-toggle="tab">映画</a>
                            </li>
                        @endisset
                        @isset($comic)
                            <li class="nav-item">
                                <a href="#recommendcomictable" class="nav-link" data-toggle="tab">漫画</a>
                            </li>
                        @endisset
                        @isset($anime)
                            <li class="nav-item">
                                <a href="#recommendanimetable" class="nav-link" data-toggle="tab">アニメ</a>
                            </li>
                        @endisset
                    </ul>
                    <div class="tab-content">
                    @isset($film)
                        <div id="recommendfilmtable" class="tab-pane active">
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="align-middle">Rank</th>
                                        <th class="align-middle">作品画像</th>
                                        <th class="align-middle">作品名</th>
                                        <th class="align-middle">前回の順位</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endisset
                    @isset($comic)
                        <div id="recommendcomictable" class="tab-pane">
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="align-middle">Rank</th>
                                        <th class="align-middle">作品画像</th>
                                        <th class="align-middle">作品名</th>
                                        <th class="align-middle">前回の順位</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endisset
                    @isset($anime)
                        <div id="recommendanimetable" class="tab-pane">
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="align-middle">Rank</th>
                                        <th class="align-middle">作品画像</th>
                                        <th class="align-middle">作品名</th>
                                        <th class="align-middle">前回の順位</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endisset    
                </div>
            @endempty
        </div>

        </article>
        </div>
    </section>

    @if (!empty($contentstop["img"]))
        <section>
            <div class="contentstop-container">
                <article class="card-body">
                    <h2 class="card-title text-center mb-4 mt-1">
                        <div class="workcheck" id="workcheck">最近チェックした作品</div>
                    </h2>
                    <div class="d-flex justify-content-around">
                        @for ($i = 0;$i < count($contentstop["img"]);$i++) 
                            <div class="p-2"><img src="{{ $contentstop['img'][$i] }}" width="90" height="120"></div>
                        @endfor
                    </div>
                </article>
            </div>
        </section>
    @endif


@include('include.footer')

<script>
    var contentstopmodals = <?php $attributes;?>

    /*
     * 質問モーダルの2つ目以降は非表示 
     * 次へボタンを初期非表示
     */
    $('#show1').show();
    for(let i = 2;i <= 4;i++) {
        $('#show' + i).hide();
    }
    $('#modalcomplete').hide();
    
    for (let i = 1;i <= 4;i++) {
        $('#idnext' + i + '').hide();
    }
    
    $(function() {
        /*
         * 次へボタン押下で、次の質問モーダル表示 
         * 前へボタン押下で、前の質問モーダル表示 
         */
        for(let i = 1;i < 4;i++) {    
            $('#idnext' + i + '').click(function() {
                $('.modal-class').not($(this).attr('id')).hide();
                $('.modal-body-sub').show();
                $('#show' + (i+1)).show();
            })
        }
       
        for(let i = 4;i > 1;i--) {    
            $('#idprevious' + i + '').click(function() {
                $('.modal-class').not($(this).attr('id')).hide();
                $('.modal-body-sub').show();
                $('#show' + (i-1)).show();
            })
        }
    })

    /*
     * 何かしらの質問チェックで次へボタンを出現
     */ 
    function chkButton($chk) {
        for (i = 1;i <= 4;i++) {
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

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
            
        }).fail(function(failresponse) {
            console.log("エラー");
        })
    })

    $('.completebutton').click(function() {
        $('#configid').modal('hide');
        $('#configcompleteid').modal('show');
        $('.modalcomplete-body-sub').show();
    })

    

    //$('#datepicker').datepicker();

    //イベントリスナーを登録 changeはテキストからフォーカスが外れた時に発生、inputはテキストに値を入れるたびに発生
    var gettext = document.querySelector('[id = "date"]');
    gettext.addEventListener("input",function(){
        if (this.value.length > 0) {
            $('#idnext2').show(); 
        } else {
            $('#idnext2').hide(); 
        }
    });
</script>