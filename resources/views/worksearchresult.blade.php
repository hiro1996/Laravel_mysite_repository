<?php
$title = 'トップページ';
?>

@include('include.header')

<article class="columns p-4 m-0">
    
    @include('work.workmenu')

    <div class="column">
       

        <section class="article-shadow campaign">
            <div class="contentstop-container">
                <div class="p-3 contentstoptitle" id="worksearchresult"><span class="contentstopbigtitle">検索結果：キャンペーン等</span></div>
                <div class="contentstop-container">
                    <article class="check">
                        <div class="p-3">
                            <div class="worksearchresult"> 
                            <article class="columns p-4 m-0 worksearchresultarea">    
                                <div class="column is-6">
                                    <strong class="worksearchresulttitle">
                                        作品タイトル
                                    </strong>
                                    <div class="worksearchresultfurigana">
                                        作品ふりがな
                                    </div>
                                    <p class="result-rating-rate">
                                        <span class="star10_rating" data-rate="4.8"></span>
                                        <span class="number_rating">4.8</span>
                                    </p>
                                    <div class="worksearchresultgenre">
                                        ジャンル：
                                    </div>
                                    <div class="worksearchresultlabel">
                                        掲載誌・レーベル：
                                    </div>
                                    <div class="worksearchresultauther">
                                        著者・作者
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="thumbnailpic">
                                        <?php $list = ['id' => 3,'id2' => 9];?>
                                        <a href="{{ route('worksearchresult',$list) }}">
                                            <?php $img = asset('assets/img/icon/work/anime/haganenorenkinjutsushi.png');?>
                                            <img class="worksearchresultimg" src="{{ $img }}" alt="img">
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-around">
                                        <div class="">
                                            NEWタグ
                                        </div>
                                        <div class="">
                                            人気急上昇↑↑
                                        </div>
                                    </div>
                                </div>
                            </article>
                            </div>
                            

                        </div>
                    </article>
                </div>
            </div>
        </section>

    </div>

</article>


@include('include.footer')
