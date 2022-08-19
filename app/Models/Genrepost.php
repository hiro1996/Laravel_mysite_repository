<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Genrepost extends Model
{
    public function genrepostModelGet($where,$select) {
        $genreposts = DB::table('genreposts')
            ->where($where)
            ->select($select)
            ->get();
        return $genreposts;
    }

    public function genrepostModelSearch($whereColumn,$whereOutput,$select) {
        $where = [
            $whereColumn => $whereOutput,
        ];
        $output = DB::table('genreposts')->where($where)->get();

        switch ($select) {
            case 'genrepostid':
                foreach ($output as $op) {
                    $output = $op->genrepostid;
                }
            break;
            case 'genrepostselectid':
                foreach ($output as $op) {
                    $output = $op->genrepost_select_id;
                }
            break;
        }
        return $output;
    }
}
