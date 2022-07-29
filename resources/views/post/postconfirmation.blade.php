
<?php
    $title = 'レビュー投稿確認';
?>

@include('include.header')

    @include('block.title')

        <form action="/post/complete" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="input-group">
                            <strong class="text-muted">ニックネーム</strong>
                        </div>
                    </div>
                </div> 
                <div class="col">
                    <div class="form-group">
                        <div class="input-group">
                            <p class="text-center">{{ $postconf['nickname'] }}</p>
                            <input type="hidden" name="nickname" value="{{ $postconf['nickname']  }}">
                        </div>
                    </div>
                </div> 
            </div> 
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="input-group">
                            <strong class="text-muted">作品名</strong>
                        </div>
                    </div>
                </div> 
                <div class="col">
                    <div class="form-group">
                        <div class="input-group">
                            <p class="text-center">{{ $postconf['workname'] }}</p>
                            <input type="hidden" name="workname" value="{{ $postconf['workname'] }}">
                        </div>
                    </div>
                </div> 
            </div> 
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="input-group">
                            <strong class="text-muted">評価</strong>
                        </div>
                    </div>
                </div> 
                <div class="col">
                    <div class="form-group">
                        <div class="input-group">
                            <p class="text-center">{{ $postconf['poststar'] }}</p>
                            <input type="hidden" name="poststar" value="{{ $postconf['poststar'] }}">
                        </div>
                    </div>
                </div> 
            </div> 
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="input-group">
                            <strong class="text-muted">レビュー内容</strong>
                        </div>
                    </div>
                </div> 
                <div class="col">
                    <div class="form-group">
                        <div class="input-group">
                            <p class="text-center">{{ $postconf['postbody'] }}</p>
                            <input type="hidden" name="postbody" value="{{ $postconf['postbody'] }}">
                        </div>
                    </div>
                </div> 
            </div> 
            <div class="form-group">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block">送信</button>
                </div> 
            </div> 
            <div class="form-group">
                <div class="text-center">
                    <a class="btn btn-primary" href="/post" role="button">戻る</a>
                </div>
            </div>
        </form>
    
    @include('block.endtitle')

@include('include.footer')



