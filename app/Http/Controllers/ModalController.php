<?php

namespace App\Http\Controllers;

use App\Models\Attributeanswer;
use App\Models\Attribute;
use App\Models\Attributetextanswer;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    public function contentstopmodalcomplete(Request $request, Attribute $attribute, Attributeanswer $attributeanswer, Attributetextanswer $attributetextanswer) {
        $modals = $request->only('modals','id','type');

        for ($i = 0;$i < count($modals["modals"]);$i++) {
            if (!empty($modals["id"][$i])) {
                $ans_id = $attribute->attributeModelExist('attr_id',$modals["modals"][$i],'answer_id');

                if ($modals["type"][$i] >= 3) {
                    $attributetextanswer->attributetextanswerModelInsert($ans_id,$modals["id"][$i]);
                } 
                $attributeanswer->attributeanswerModelInsert($ans_id);
            }
        }
    }
}
