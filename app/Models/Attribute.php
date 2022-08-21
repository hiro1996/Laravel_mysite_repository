<?php

namespace App\Models;

use GuzzleHttp\RetryMiddleware;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Attribute extends Model
{
    public function attributeModelGet($key) {
        switch ($key) {
            case 'attrpage':
                $contentstopmodal = new Contentstopmodal();
                $column = 1; 
                $needDB = [
                    'printorderjsids'
                ];
                $where = NULL;
                $select = [
                    'print_order'
                ];
                while ($column < count($contentstopmodal->contentstopmodalModelGet($needDB,$where,$select)) + 1) {

                    $attrkey = $contentstopmodal->contentstopmodalModelExist($column);

                    $allattrkey["q_explain"][$column] = $attrkey["q_explain"];
                    $allattrkey["q_body"][$column] = $attrkey["q_body"];
                    $allattrkey["name_id"][$column] = $attrkey["name_id"];

                    if ($attrkey["type_id"] == 1) {
                        $allattrkey["type_id"][$column] = 'radio';
                    } elseif ($attrkey["type_id"] == 2) {
                        $allattrkey["type_id"][$column] = 'checkbox';
                    } else {
                        $allattrkey["type_id"][$column] = 'text';
                    }

                    for ($i = 0;$i < count($attrkey["q_attribute"]);$i++) {
                        $allattrkey["q_attribute"][$column][$i] = $attrkey["q_attribute"][$i];
                        $allattrkey["attr_id"][$column][$i] = $attrkey["attr_id"][$i];
                    }
                    $column++;
                }

                $printorderjsid = new Printorderjsid();
                $where = NULL;
                $select = [
                    'previousidname',
                    'nextidname',
                    'modalshowidname',
                ];
                $printorderjsids = $printorderjsid->printorderjsidModelGet($where,$select);
    
                $i = 1;
                foreach ($printorderjsids as $print) {
                    $allattrkey["previous_id_name"][$i] = $print->previousidname;
                    $allattrkey["next_id_name"][$i] = $print->nextidname;
                    $allattrkey["modalshow_id_name"][$i] = $print->modalshowidname;
                    $i++;
                }
                return $allattrkey;
            case 'get':
                $attrributes = DB::table('attributes')->get();
                return $attrributes;
        }
    }

    public function attributeModelExist($attrwhere,$attr,$select) {
        $where = [
            $attrwhere => $attr
        ];
        $attrributes = DB::table('attributes')->select($select)->where($where)->get();
            
        foreach ($attrributes as $attrribute) {
            switch ($select) {
                case 'answer_id':
                    $ans_id = $attrribute->answer_id;
                    return $ans_id;
                case 'type_id':
                    $type_id = $attrribute->type_id;
                    return $type_id;
            }
        }
    }

    public function attributeSettingModelGet() {
        $attributessetting = DB::table('attributes')
            ->join('contentstopmodals',function($join) {
                $join->on('attributes.print_order','=','contentstopmodals.print_order')
                    ->where('contentstopmodals.q_body','LIKE','%ランキング%');
            })->select('attributes.q_attribute','attributes.attr_id')->get();
        return $attributessetting;
    }
}
