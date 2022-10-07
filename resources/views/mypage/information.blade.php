<?php
    $title = '会員情報';
?>

@include('include.header')

    @include('block.title')

        <div class="row">
            <div class="col">
                @include('block.informationtitle')
                    <div class="circle">
                    </div>
                    <div class="form-group">
                        <div class="text-center searchbuttondivclass">
                            <input type="file" value="アイコン登録" id="searchbuttonid" class="btn btn-primary btn-block">
                        </div> 
                    </div> 
                    @include('block.informationinnertitle')
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <div class="input-group">
                                        <strong class="columnname">ニックネーム</strong>
                                    </div>
                                </div>
                            </div> 
                            <div class="col">
                                <div class="form-group">
                                    <div class="input-group">
                                        <p class="columndata">{{ $users->nickname }}</p>
                                    </div>
                                </div>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <div class="input-group">
                                        <strong class="columnname">年齢</strong>
                                    </div>
                                </div>
                            </div> 
                            <div class="col">
                                <div class="form-group">
                                    <div class="input-group">
                                        <p class="columndata">{{ $users->age }}</p>
                                    </div>
                                </div>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <div class="input-group">
                                        <strong class="columnname">最終ログイン</strong>
                                    </div>
                                </div>
                            </div> 
                            <div class="col">
                                <div class="form-group">
                                    <div class="input-group">
                                        <p class="columndata">{{ $users->last_display_login_time }}</p>
                                    </div>
                                </div>
                            </div> 
                        </div> 
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <div class="input-group">
                                        <strong class="columnname">本サイト訪問回数</strong>
                                    </div>
                                </div>
                            </div> 
                            <div class="col">
                                <div class="form-group">
                                    <div class="input-group">
                                        <p class="columndata">{{ $users->login_number_of_times }}回</p>
                                    </div>
                                </div>
                            </div> 
                        </div> 
                    @include('block.informationinnerendtitle')
                @include('block.informationendtitle')
            </div>
            <div class="col">
                @include('block.informationtitle')
                    <u><strong class="text-muted">現在のポイント</strong></u>
                    <div class="form-group">
                        <div class="text-center">
                            <br>
                            <p class="points">
                                <img src="{{ asset('assets/img/icon/information/point.png') }}" alt="ポイントの画像" class="pointimg" width="60pt" height="60pt">
                                &nbsp;
                                @for ($i = 0;$i < count($points);$i++) 
                                    <img src="{{ $points[$i] }}" alt="数値" class="pointimg" width="40pt" height="40pt">
                                @endfor    
                                pt
                            </p>
                        </div>
                    </div>
                    @include('block.informationinnertitle')
                        @for ($i = 1;$i < 6;$i++)
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <strong class="columnname">ポイント獲得履歴</strong>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <p class="columndata">ああああああああ</p>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        @endfor
                    @include('block.informationinnerendtitle')
                @include('block.informationendtitle')
            </div>
        </div>

            <div class="collapse card" id="searchbuttonid">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">作品名</th>
                            <th scope="col">カテゴリー</th>
                        </tr>
                    </thead>

                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>ハイキュー</td>
                                <td>閲覧日閲覧日</td>
                            </tr>
                        </tbody>
                        
                </table>
                <nav aria-label="Page navigation example text-center">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">前へ</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">次へ</a></li>
                    </ul>
                </nav>
            </div>

    @include('block.endtitle')

@include('include.footer')