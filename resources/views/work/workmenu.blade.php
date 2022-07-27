<?php
    use App\Models\Worktype;
    use App\Models\Work;


    $worktype = new Worktype();
    $work = new Work();
    $worktypes = $worktype->worktypeModelGet(NULL,NULL);

    foreach ($worktypes as $workt) {
        $worktypegenre[$workt->worktypeid] = $workt->worktype_name;
    }

    $queryurl = request()->fullUrl();
    $queryurl = urldecode($queryurl);

    $workmenuside_list = [];
    $worktypesidemenus = $worktype->worktypemenusideModelGet();
    //dd($worktypesidemenus);
    foreach ($worktypesidemenus as $workts) {
        if (strstr($queryurl,$workts->worktype_name)) {
            $workids = $work->workidModelGet('worktypes','worktype_name',$workts->worktype_name);
            foreach ($workids as $id) {
                $worktypeid = $id->worktypeid;
            }
            $workmenuside_list = ['work_type' => $workts->worktypeid];
        }
        if (strstr($queryurl,$workts->category_name)) {
            $workmenuside_list = ['category_name' => $workts->category_name];
        }
    }
    $workmenus = $work->worksearchresultModelGet($workmenuside_list);
    foreach ($workmenus as $workm) {
        $worktypemenus = $worktype->worktypemenuModelGet(['work_type' => $workm->work_type]);
        foreach ($worktypemenus as $worktm) {
            if ($worktm->worktype_name) {
                $worktypegenremenu[$worktm->worktype_name][$worktm->category_name] = $worktm->category_name_count;
            }
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
</div>

