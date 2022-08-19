<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rankingweight extends Model
{
    public function rankingweightModelGet($where,$select) {  
        $rankingweights = DB::table('rankingweights')
            ->where($where)
            ->select($select)
            ->get();
        return $rankingweights;
    }
}
