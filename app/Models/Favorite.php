<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Favorite extends Model
{
    public function favoriteModelInsert($worksubid) {
        $insert = [
            'loginid' => session('loginid'),
            'worksubid' => $worksubid,
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

    public function favoriteModelGet($needDB,$where,$select) {
        $favorites = DB::table('favorites');
        if (in_array('worksubs',$needDB)) {
            $favorites = $favorites->join('worksubs','favorites.worksubid','=','worksubs.id');
        }
        if (in_array('works',$needDB)) {
            $favorites = $favorites->join('works','worksubs.workid','=','works.workid');
        }
        $favorites = $favorites
            ->where($where)
            ->select($select)
            ->get();
        return $favorites;
    }
}
