<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    public function postModelGet($wherecolumn1,$wheredata1,$wherecolumn2,$formula,$wheredata2) {
        $where1 = [
            $wherecolumn1 => $wheredata1
        ];
        $posts = DB::table('posts')->where($where1);
        if ($wherecolumn2 != NULL) {
            $posts = $posts->where($wherecolumn2,$formula,$wheredata2);
        }
        $posts = $posts->get();
        return $posts;
    }

    public function postModelInsert($loginid,$worksubid,$poststar,$postbody) {
        $insert = [
            'loginid' => $loginid,
            'worksubid' => $worksubid,
            'poststar' => $poststar,
            'postbody' => $postbody,
        ];
        DB::table('posts')->insert($insert);
    }

}
