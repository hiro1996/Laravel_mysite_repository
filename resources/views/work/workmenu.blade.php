<?php
    use App\Models\Worktype;
    use App\Models\Work;
    use Illuminate\Support\Facades\DB;

    $worktype = new Worktype();
    $work = new Work();
    $needDB = [];
    $where = NULL;
    $select = [
        'worktypeid',
        'worktype_name',
    ];
    $groupby = NULL;
    $orderby = NULL;
    $orderbyascdesc = NULL;
    $limit = NULL;
    $worktypes = $worktype->worktypeModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);


    foreach ($worktypes as $workt) {
        $worktypegenre[$workt->worktypeid] = $workt->worktype_name;
    }

    $queryurl = request()->fullUrl();
    $queryurl = urldecode($queryurl);

    $where = [];
    $workmenupublisherlabelauther_list = [];
    $needDB = [
        'works',
        'worksubs',
    ];
    $where = NULL;
    $select = [
        'worktypeid',
        'worktype_name',
        'category_name',
        'publisher',
        'publicationmagazine_label',
        'auther',
    ];
    $groupby = NULL;
    $orderby = NULL;
    $orderbyascdesc = NULL;
    $limit = NULL;
    $worktypesidemenus = $worktype->worktypeModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
    foreach ($worktypesidemenus as $workts) {
        if (strstr($queryurl,$workts->worktype_name)) {
            $needDB = [];
            $where = [['worktype_name','=',$workts->worktype_name]];
            $select = [
                'worktypeid'
            ];
            $groupby = NULL;
            $orderby = NULL;
            $orderbyascdesc = NULL;
            $limit = NULL;
            $worktypedatas = $worktype->worktypeModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
            foreach ($worktypedatas as $id) {
                $worktypeid = $id->worktypeid;
            }
            $where = ['work_type' => $workts->worktypeid];
        }
        if (strstr($queryurl,$workts->category_name)) {
            $where = ['category_name' => $workts->category_name];
        }
        if (strstr($queryurl,$workts->publisher) && ($workts->publisher != NULL)) {
            $where = ['publisher' => $workts->publisher];
        }
        if (strstr($queryurl,$workts->publicationmagazine_label) && ($workts->publicationmagazine_label != NULL)) {
            $where = ['publicationmagazine_label' => $workts->publicationmagazine_label];
        }
        if (strstr($queryurl,$workts->auther) && ($workts->auther != NULL)) {
            $where = ['auther' => $workts->auther];
        }
    }
    $select = [
        'work_type'
    ];
    $needDB = [
        'worksubs',
        'worktypes',
    ];
    
    $groupby = NULL;
    $orderby = NULL;
    $orderbyascdesc = NULL;
    $limit = NULL;
    $workmenus = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
    foreach ($workmenus as $workm) {
        $needDB = [
            'works',
        ];
        $where = [['work_type','=',$workm->work_type]];
        $select = [
            'worktype_name',
            'category_name',
            DB::raw('count(category_name) AS category_name_count')
        ];
        $groupby = [
            'worktype_name',
            'category_name',
        ];
        $orderby = NULL;
        $orderbyascdesc = NULL;
        $limit = NULL;
        $worktypemenus = $worktype->worktypeModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
        foreach ($worktypemenus as $worktm) {
            if ($worktm->worktype_name) {
                $worktypegenremenu[$worktm->worktype_name][$worktm->category_name] = $worktm->category_name_count;
            }
        }
    }

    $needDB = [
        'worksubs',
    ];
    $where = NULL;
    $select = [
        'publisher',
        DB::raw('count(publisher) AS publisher_count'),
    ];
    $groupby = ['publisher'];
    $orderby = 'publisher';
    $orderbyascdesc = 'ASC';
    $limit = NULL;
    $workmenupublishers = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
    foreach ($workmenupublishers as $publisher) {
        if ($publisher->publisher != NULL) {
            $workmenuspublisher['出版社'][$publisher->publisher] = $publisher->publisher_count;
        }
    }

    $needDB = [
        'worksubs',
    ];
    $where = NULL;
    $select = [
        'publicationmagazine_label',
        DB::raw('count(publicationmagazine_label) AS label_count'),
    ];
    $groupby = ['publicationmagazine_label'];
    $orderby = 'publicationmagazine_label';
    $orderbyascdesc = 'ASC';
    $limit = NULL;
    $workmenulabels = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
    foreach ($workmenulabels as $label) {
        if ($label->publicationmagazine_label != NULL) {
            $workmenuslabel['掲載誌・レーベル'][$label->publicationmagazine_label] = $label->label_count;
        }
    }

    $needDB = [
        'worksubs',
    ];
    $where = NULL;
    $select = [
        'auther',
        DB::raw('count(auther) AS auther_count'),
    ];
    $groupby = ['auther'];
    $orderby = 'auther';
    $orderbyascdesc = 'ASC';
    $limit = NULL;
    $workmenuauthers = $work->workModelGet($needDB,$where,$select,$groupby,$orderby,$orderbyascdesc,$limit);
    foreach ($workmenuauthers as $auther) {
        if ($auther->auther != NULL) {
            $workmenusauther['作者'][$auther->auther] = $auther->auther_count;
        }
    }
?>


<div class="submenu column is-3">
    <aside class="article-shadow menu">
        @foreach ($worktypegenremenu as $genre => $menu)
            <ul class="workmenu">
                <li class="workmenu-list">
                    <a href="{{ route('worksearchresult',['category_genre' => $genre]) }}">{{ $genre }}</a>
                    @foreach ($menu as $categorymenu => $categorycount)
                        <li class="workmenu-sublist"><a href="{{ route('worksearchresult',['category_genre' => $genre, 'category' => $categorymenu]) }}" class="workmenu-sublistlink">{{ $categorymenu }}({{ $categorycount }})</a></li>
                    @endforeach
                </li>
            </ul>
        @endforeach
    </aside>

    <aside class="article-shadow menu">
        @foreach ($workmenuspublisher as $publisher => $publishersub)
            <ul class="workmenu">
                <li class="workmenu-list">
                    {{ $publisher }}
                    @foreach ($publishersub as $pubsub => $count)
                        <li class="workmenu-sublist"><a href="{{ route('worksearchresult',['publisher' => $pubsub]) }}" class="workmenu-sublistlink">{{ $pubsub }}({{ $count }})</a></li>
                    @endforeach
                </li>
            </ul>
        @endforeach
    </aside>

    <aside class="article-shadow menu">
        @foreach ($workmenuslabel as $label => $labelsub)
            <ul class="workmenu">
                <li class="workmenu-list">
                    {{ $label }}
                    @foreach ($labelsub as $labsub => $count)
                        <li class="workmenu-sublist"><a href="{{ route('worksearchresult',['label' => $labsub]) }}" class="workmenu-sublistlink">{{ $labsub }}({{ $count }})</a></li>
                    @endforeach
                </li>
            </ul>
        @endforeach
    </aside>

    <aside class="article-shadow menu">
        @foreach ($workmenusauther as $auther => $authersub)
            <ul class="workmenu">
                <li class="workmenu-list">
                    {{ $auther }}
                    @foreach ($authersub as $authsub => $count)
                        <li class="workmenu-sublist"><a href="{{ route('worksearchresult',['auther' => $authsub]) }}" class="workmenu-sublistlink">{{ $authsub }}({{ $count }})</a></li>
                    @endforeach
                </li>
            </ul>
        @endforeach
    </aside>
</div>

