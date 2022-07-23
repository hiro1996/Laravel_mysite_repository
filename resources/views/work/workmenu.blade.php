<?php
    use App\Models\Worktype;


    $worktype = new Worktype();
    $worktypes = $worktype->worktypeModelGet(NULL,NULL);

    foreach ($worktypes as $workt) {
        $worktypegenre[$workt->worktypeid] = $workt->worktype_name;
    }

    $worktypemenus = $worktype->worktypemenuModelGet();
    $i = 0;
    foreach ($worktypemenus as $menu) {
        $worktypegenremenu[$menu->worktype_name][$menu->category_name] = $menu->category_name_count;
    }
?>


<div class="submenu column is-3">
    <aside class="article-shadow notification is-info is-light">
        <div class="mb-2">
            <span class="tag is-danger">News</span>
        </div>
        <div>
            ガチャを回しておすすめ作品を見ましょう
        </div>
    </aside>
    <aside class="article-shadow menu">
        @foreach ($worktypegenremenu as $category => $menu)
            <ul class="workmenu">
                <li class="workmenu-list">
                    <a href="#">{{ $category }}</a>
                    @foreach ($menu as $categorymenu => $categorycount)
                        <li class="workmenu-sublist"><a href="#" class="workmenu-sublistlink">{{ $categorymenu }}({{ $categorycount }})</a></li>
                    @endforeach
                </li>
            </ul>
        @endforeach
    </aside>
</div>