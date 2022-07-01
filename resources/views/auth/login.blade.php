<?php
    $title = 'ログイン画面';
?>

@include('include.header')

    @include('block.title')

        <form action="/top" method="POST">
            @csrf
            <strong class="text-muted">ログインID</strong>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input class="form-control" placeholder="ログインID" type="text" name="loginid" value="{{ old('loginid') }}">
                </div> 
            </div> 
            @if($errors->has('loginid'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('loginid') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <strong class="text-muted">パスワード</strong>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input class="form-control" placeholder="パスワード" type="password" name="password">
                </div> 
            </div> 
            @if($errors->has('password'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('password') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">ログイン</button>
                <input type="hidden" name="login" value="on">
            </div> 
            <div class="form-group">
                <p class="text-center"><a href="/loginid_reset" class="btn">ログインIDをお忘れの方</a></p>
                <p class="text-center"><a href="/passwd_reset" class="btn">パスワードをお忘れの方</a></p>
                <p class="text-center"><a href="/register" class="btn">アカウントを作成</a></p>
            </div> 
        </form>

    @include('block.endtitle')

@include('include.footer')
