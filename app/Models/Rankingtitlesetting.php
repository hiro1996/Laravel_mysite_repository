<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rankingtitlesetting extends Model
{
    public function rankingtitlesettingModelGet($needDB,$where,$select) {
        $rankingflagconfigs = DB::table('rankingtitlesettings');
        if (in_array('rankingtablesettings',$needDB)) {
            $rankingflagconfigs = $rankingflagconfigs->join('rankingtablesettings','rankingtitlesettings.first_display_flag','=','rankingtablesettings.rankingtablesetting_default_flag');
        } 
        $rankingflagconfigs = $rankingflagconfigs
            ->where($where)
            ->select($select)
            ->get();
        return $rankingflagconfigs;
    }
}
