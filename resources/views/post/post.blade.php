
<?php
    $title = 'レビュー投稿する';
?>

@include('include.header')

    @include('block.title')

        <form action="/post/conf" method="POST">
            @csrf
            <strong class="text-muted">ニックネーム</strong>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input class="form-control" placeholder="ニックネーム" type="text" name="nickname" value="{{ $posts['nickname'] }}" readonly>
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
            <div class="row">
                <div class="col">
                    <strong class="text-muted">レビュー作品名</strong>  
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input class="form-control" placeholder="レビュー作品名(直接入力すると予測表示します)" type="text" id="worknameid" name="workname" value="{{ $posts['worktitle'] ?? '' }}" list="searchlist" autocomplete="on">
                            <datalist id="searchlist">
                                @for ($i = 0;$i < count($posts['wotkalltitle']);$i++)
                                    <option value="{{ $posts['wotkalltitle'][$i] }}"></option>
                                @endfor
                            </datalist>
                        </div> 
                    </div>
                    @if($errors->has('workname'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->get('workname') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label for="worktitle" class="col-sm-13 col-form-label">作品検索は<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#searchmodal">こちら</button></label>
                            </div>
                        </div> 
                    </div>
                </div>
            </div> 

            <div class="modal fade" id="searchmodal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="searchmodal" area-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="staticBackdropLabel">作品検索</h5>
                        </div>
                        <div class="modal-body">
                            @include('post.postworksearch')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                        </div>
                    </div>
                </div>
            </div>

            <strong class="text-muted">評価</strong>
            <div class="evaluation">
                <input id="star1" type="radio" name="poststar" value="10" />
                <label for="star1"><span class="text">最高</span>★</label>
                <input id="star2" type="radio" name="poststar" value="9" />
                <label for="star2"><span class="text"></span>★</label>
                <input id="star3" type="radio" name="poststar" value="8" />
                <label for="star3"><span class="text">良い</span>★</label>
                <input id="star4" type="radio" name="poststar" value="7" />
                <label for="star4"><span class="text"></span>★</label>
                <input id="star5" type="radio" name="poststar" value="6" />
                <label for="star5"><span class="text">普通+</span>★</label>
                <input id="star6" type="radio" name="poststar" value="5" />
                <label for="star6"><span class="text">普通-</span>★</label>
                <input id="star7" type="radio" name="poststar" value="4" />
                <label for="star7"><span class="text"></span>★</label>
                <input id="star8" type="radio" name="poststar" value="3" />
                <label for="star8"><span class="text">悪い</span>★</label>
                <input id="star9" type="radio" name="poststar" value="2" />
                <label for="star9"><span class="text"></span>★</label>
                <input id="star10" type="radio" name="poststar" value="1" />
                <label for="star10"><span class="text">最悪</span>★</label>
            </div>
            @if($errors->has('poststar'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('poststar') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <strong class="text-muted">レビュー内容</strong>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <textarea class="form-control" name="postbody" rows="5" placeholder="レビュー内容を250文字以内で入力"></textarea>
                </div> 
                <p class="text-danger">※ネタバレになる内容は、お控えいただくようよろしくお願いします。</p>
            </div> 
            @if($errors->has('postbody'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->get('postbody') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block">確認</button>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <a class="btn btn-primary" href="/top" role="button">戻る</a>
                </div>
            </div>
        </form>

    @include('block.endtitle')

@include('include.footer')

