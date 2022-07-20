<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Genderattention extends Model
{
    public function genderattentionModelGet() {
        $genderattentions = DB::table('genderattentions')->get();
        return $genderattentions;
    }
}
