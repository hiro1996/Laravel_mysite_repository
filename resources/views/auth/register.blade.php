<?php
    $title = 'アカウント新規作成';
?>

@include('include.header')

    @include('block.title')

        <form action="/login" method="POST">
            @csrf
            <strong class="text-muted">ログインID</strong>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input class="form-control" placeholder="ログインID" type="text" name="loginid">
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
            <strong class="text-muted">Eメールアドレス</strong>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input class="form-control" placeholder="Eメールアドレス" type="email" name="email">
                </div> 
            </div> 
            @if($errors->has('email'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('email') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <strong class="text-muted">誕生日</strong>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input class="form-control" placeholder="誕生日" type="text" name="birthday">
                </div> 
            </div> 
            @if($errors->has('birthday'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('birthday') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <strong class="text-muted">ニックネーム</strong>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input class="form-control" placeholder="ニックネーム" type="text" name="nickname">
                </div> 
            </div> 
            @if($errors->has('nickname'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('nickname') as $error)
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
            <strong class="text-muted">パスワード確認</strong>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input class="form-control" placeholder="パスワード確認" type="password" name="password_confirmation">
                </div> 
            </div> 
            @if($errors->has('password_confirmation'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('password_confirmation') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">アカウント登録</button>
                <input type="hidden" name="register" value="user">
            </div> 
            <div class="form-group">
                <div class="text-center">
                    <a class="btn btn-primary" href="/login" role="button">戻る</a>
                </div>
            </div>
        </form>
    
    @include('block.endtitle')