<?php
$title = 'トップページ';
?>

@include('include.header')

<article class="columns p-4 m-0">
    
    @include('work.workmenu')

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
                                    <strong class="worksearchresulttitle">
                                        {{ $worksearchresult['worksearchresult_title'][$i] }}
                                    </strong>
                                    <div class="worksearchresultfurigana">
                                        {{ $worksearchresult['worksearchresult_furigana'][$i] }}
                                    </div>
                                    <p class="result-rating-rate">
                                        <span class="star10_rating" data-rate="4.8"></span>
                                        <span class="number_rating">4.8</span>
                                    </p>
                                    <div class="worksearchresultgenre">
                                        ジャンル：{{ $worksearchresult['worksearchresult_worktypename'][$i] }}
                                    </div>
                                    <div class="worksearchresultgenre">
                                        カテゴリー：{{ $worksearchresult['worksearchresult_categoryname'][$i] }}
                                    </div>
                                    <div class="worksearchresultlabel">
                                        掲載誌・レーベル：{{ $worksearchresult['worksearchresult_label'][$i] }}
                                    </div>
                                    <div class="worksearchresultauther">
                                        著者・作者：{{ $worksearchresult['worksearchresult_auther'][$i] }}
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="thumbnailpic">
                                        <a href="{{ $worksearchresult['worksearchresult_url'][$i] }}">
                                            <img class="worksearchresultimg" src="{{ $worksearchresult['worksearchresult_img'][$i] }}" alt="{{ $worksearchresult['worksearchresult_title'][$i] }}">
                                        </a>
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

</article>


@include('include.footer')
