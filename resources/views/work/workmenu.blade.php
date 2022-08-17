<?php
    use App\Models\Worktype;
    use App\Models\Work;
use Illuminate\Support\Facades\DB;

    $worktype = new Worktype();
    $work = new Work();
    $worktypes = $worktype->worktypeModelGet(NULL,NULL);

    foreach ($worktypes as $workt) {
        $worktypegenre[$workt->worktypeid] = $workt->worktype_name;
    }

    $queryurl = request()->fullUrl();
    $queryurl = urldecode($queryurl);

    $workmenugenrecategory_list = [];
    $workmenupublisherlabelauther_list = [];
    $worktypesidemenus = $worktype->worktypemenusideModelGet();
    foreach ($worktypesidemenus as $workts) {
        if (strstr($queryurl,$workts->worktype_name)) {
            $workids = $work->workidModelGet('worktypes','worktype_name',$workts->worktype_name);
            foreach ($workids as $id) {
                $worktypeid = $id->worktypeid;
            }
            $workmenugenrecategory_list = ['work_type' => $workts->worktypeid];
        }
        if (strstr($queryurl,$workts->category_name)) {
            $workmenugenrecategory_list = ['category_name' => $workts->category_name];
        }
        if (strstr($queryurl,$workts->publisher) && ($workts->publisher != NULL)) {
            $workmenugenrecategory_list = ['publisher' => $workts->publisher];
        }
        if (strstr($queryurl,$workts->publicationmagazine_label) && ($workts->publicationmagazine_label != NULL)) {
            $workmenugenrecategory_list = ['publicationmagazine_label' => $workts->publicationmagazine_label];
        }
        if (strstr($queryurl,$workts->auther) && ($workts->auther != NULL)) {
            $workmenugenrecategory_list = ['auther' => $workts->auther];
        }
    }
    $select = [
        'work_type'
    ];
    $workmenus = $work->worksearchresultModelGet($workmenugenrecategory_list,$select);
    foreach ($workmenus as $workm) {
        $worktypemenus = $worktype->worktypemenuModelGet(['work_type' => $workm->work_type]);
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

