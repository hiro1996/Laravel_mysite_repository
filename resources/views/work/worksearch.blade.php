<?php
    $title = '作品検索';
?>

@include('include.header')

    @include('block.title')

        <div class="row">
            <div class="col">
                @include('block.worksearchtitle')
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
                    <strong class="text-muted">五十音検索(文字をクリックで色が変わり、選択状態になります。)</strong>
                    @include('block.gojuonsearch')
                    <div class="form-group">
                        <div class="text-center searchbuttondivclass">
                            <input onclick="searchajax()" type="button" id="searchbuttonid" class="btn btn-primary btn-block searchbuttonclass" value="検索">
                        </div> 
                    </div> 
                @include('block.worksearchendtitle')
            </div>
            <div class="col col-lg-5">
                @include('block.worksearchtitle')
                    <strong class="kochiratitle">こちらはいかがですか？</strong>
                    <div class="form-group">
                        <div class="kochiraikaga">
                            <a href="/login" target="_blank"><img src="{{ asset('assets/img/work/anime/free.png') }}"></a>
                        </div>
                        <div class="kochiraname">
                            Free!!
                        </div>
                    </div>
                @include('block.worksearchendtitle')
            </div>
        </div>

        <div class="card" id="collapsesearchbuttonid">
        </div>

    @include('block.endtitle')

@include('include.footer')