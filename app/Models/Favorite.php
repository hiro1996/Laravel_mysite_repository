<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Favorite extends Model
{
    public function favoriteModelInsert($workid) {
        $insert = [
            'loginid' => session('loginid'),
            'workid' => $workid,
        ];
        DB::table('favorites')->insert($insert);
    }

    public function favoriteModelDelete($workid) {
        $where1 = [
            'loginid' => session('loginid'),
        ];
        $where2 = [
            'workid' => $workid
        ];
        DB::table('favorites')->where($where1)->orWhere($where2)->delete();
    }

    public function favoriteAllModelGet() {
        $where = [
            'loginid' => session('loginid')
        ];
        $favoritesdata = DB::table('favorites')->where($where)->get();
        return $favoritesdata;
    }

    public function favoriteModelGet($workid) {
        $favorites = DB::table('favorites')
            ->join('works',function($join) use ($workid) {
                $join->on('works.workid','=','favorites.workid')
                ->where('favorites.workid','=',$workid);
        })->get();
        return $favorites;
    }
}
