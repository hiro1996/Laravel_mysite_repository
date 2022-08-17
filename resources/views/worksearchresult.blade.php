<?php
$title = 'トップページ';
?>

@include('include.header')

<article class="columns p-4 m-0">
    
    @include('work.workmenu')

    @if ($worksearchresult['worksearchresult_img'])
    <div class="column">
        <section class="article-shadow campaign">
            <div class="contentstop-container">
                <div class="p-3 contentstoptitle" id="worksearchresult"><span class="contentstopbigtitle">検索結果：{{ $worksearchresult['worksearchresult_worktypename'][0] }}</span></div>
                <div class="contentstop-container">
                    <article class="check">
                        <div class="p-3">
                        @for ($i = 0;$i < count($worksearchresult['worksearchresult_img']);$i++)  
                            <div class="worksearchresult"> 
                            <article class="columns p-4 m-0 worksearchresultarea">   
                                <div class="column is-6">
                                    <div class="thumbnailpic">
                                        <a href="{{ $worksearchresult['worksearchresult_url'][$i] }}">
                                            <img class="worksearchresultimg" src="{{ $worksearchresult['worksearchresult_img'][$i] }}" alt="{{ $worksearchresult['worksearchresult_title'][$i] }}">
                                        </a>
                                    </div>
                                </div>
                                <div class="column">
                                    <strong class="worksearchresulttitle">
                                        {{ $worksearchresult['worksearchresult_title'][$i] }}
                                    </strong>
                                    <div class="worksearchresultfurigana">
                                        {{ $worksearchresult['worksearchresult_furigana'][$i] }}
                                    </div>
                                    <p class="result-rating-rate">
                                        <span class="star10_rating" data-rate="{{ $worksearchresult['worksearchresult_poststaravg'][$i] }}"></span>
                                        <span class="number_rating">{{ $worksearchresult['worksearchresult_poststaravg'][$i] }}</span>
                                    </p>
                                    <div class="worksearchresultgenre">
                                        ジャンル：<a href="{{ route('worksearchresult',['category_genre' => $worksearchresult['worksearchresult_worktypename'][$i]] ) }}">{{ $worksearchresult['worksearchresult_worktypename'][$i] }}</a>
                                    </div>
                                    <div class="worksearchresultcategory">
                                        カテゴリー：<a href="{{ route('worksearchresult',['category' => $worksearchresult['worksearchresult_categoryname'][$i]] ) }}">{{ $worksearchresult['worksearchresult_categoryname'][$i] }}</a>
                                    </div>
                                    <div class="worksearchresultpublisher">
                                        @if ($worksearchresult['worksearchresult_publisher'][$i] == '-')
                                            出版社：{{ $worksearchresult['worksearchresult_publisher'][$i] }}
                                        @else
                                            出版社：<a href="{{ route('worksearchresult',['publisher' => $worksearchresult['worksearchresult_publisher'][$i]] ) }}">{{ $worksearchresult['worksearchresult_publisher'][$i] }}</a>
                                        @endif
                                    </div>
                                    <div class="worksearchresultlabel">
                                        @if ($worksearchresult['worksearchresult_label'][$i] == '-')
                                            掲載誌・レーベル：{{ $worksearchresult['worksearchresult_label'][$i] }}
                                        @else
                                            掲載誌・レーベル：<a href="{{ route('worksearchresult',['label' => $worksearchresult['worksearchresult_label'][$i]] ) }}">{{ $worksearchresult['worksearchresult_label'][$i] }}</a>
                                        @endif
                                    </div>
                                    <div class="worksearchresultauther">
                                        @if ($worksearchresult['worksearchresult_auther'][$i] == '-')
                                            著者・作者：{{ $worksearchresult['worksearchresult_auther'][$i] }}
                                        @else
                                            著者・作者：<a href="{{ route('worksearchresult',['auther' => $worksearchresult['worksearchresult_auther'][$i]] ) }}">{{ $worksearchresult['worksearchresult_auther'][$i] }}</a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                            </div>
                        @endfor
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </div>
    @endif

</article>


@include('include.footer')
