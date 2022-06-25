
<div class="modal-body-sub">
    <div class="text-center">
        <div class="rankingconfig-word">
            @for ($j = 0;$j < count($contentstop['attributes']['q_attribute'][$i]);$j++)
                <div class="rank-class">
                    <div class="form-check">
                        @if ($contentstop['attributes']['type_id'][$i] != 'text')
                            <label class="form-check-label" for="{{ $contentstop['attributes']['attr_id'][$i][$j] }}">
                            <input class="form-check-input checkattr{{ $i }}" type="{{ $contentstop['attributes']['type_id'][$i] }}" id="{{ $contentstop['attributes']['attr_id'][$i][$j] }}" name="{{ $contentstop['attributes']['name_id'][$i] }}" value="{{ $contentstop['attributes']['attr_id'][$i][$j] }}" onclick="chkButton('check{{ $i }}')">
                            &nbsp;
                            &nbsp;
                            {{ $contentstop['attributes']['q_attribute'][$i][$j] }}</label>
                        @else
                            <div class="form-group">
                                <input class="form-control" type="{{ $contentstop['attributes']['type_id'][$i] }}" id="{{ $contentstop['attributes']['attr_id'][$i][$j] }}">
                            </div>
                        @endif
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>


    

