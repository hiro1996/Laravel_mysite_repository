<?php
    $title = 'ユーザー検索';
?>

@include('include.header')

    @include('block.title')

        <div class="usersearch">
            <strong class="text-muted">ログイン回数</strong>
            <div class="form-group">
                <div class="text-center">
                    <select name="logintimes" class="form-control">
                        <option value="">--選択してください--</option>
                        <option value="1">未ログイン</option>
                        <option value="2">2回以上</option>
                    </select>
                </div>
            </div>
            <strong class="text-muted">最終ログイン時との差</strong>
            <div class="form-group">
                <div class="text-center">
                    <select name="times" class="form-control">
                        <option value="">--選択してください--</option>
                        <option value="3">3ヶ月以上</option>
                        <option value="6">6ヶ月以上</option>
                        <option value="9">9ヶ月以上</option>
                        <option value="12">1年以上</option>
                    </select>
                </div>
            </div>
                <div class="form-group">
                    <div class="text-center searchbuttondivclass">
                        <input onclick="usersearchajax()" type="button" id="searchbuttonid" class="btn btn-primary btn-block searchbuttonclass" value="検索">
                    </div> 
                    <div id="csvid">
                        <input onclick="clickmakingcsv()" type="button" id="csvid" class="btn btn-primary btn-block searchbuttonclass" value="CSV出力">
                    </div>
                </div> 
            </div>
            <br>
            <div class="card" id="collapsesearchbuttonid">
            </div>
            
            <br>
        </div>

    @include('block.endtitle')

@include('include.footer')

