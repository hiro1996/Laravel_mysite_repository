<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    public function postModelGet($where,$select) {
        $posts = DB::table('posts')
            ->where($where);
        if ($select != NULL) {
            $posts = $posts->select($select);
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
            'created_at' => date('Y-m-d')
        ];
        DB::table('posts')->insert($insert);
    }

}
