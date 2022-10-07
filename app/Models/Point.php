<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Point extends Model
{
    public function pointModelGet() {
        $num = 99048;
        $splitnum = str_split($num);

        for ($i = 0;$i < count($splitnum);$i++) {
            $where = [
                'number' => $splitnum[$i]
            ];
            $output[$i] = DB::table('points')->where($where)->get();
        }

        $points = [];
        for ($i = 0;$i < count($output);$i++) {
            foreach ($output[$i] as $op) {
                $points[$i] = $op->img;
            }
        }

        return $points;
    }

}
