<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    public function postModelGet($worksubid) {
        $where = [
            'worksubid' => $worksubid
        ];
        $posts = DB::table('posts')->where($where)->get();
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
