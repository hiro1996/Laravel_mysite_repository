<div class="d-flex justify-content-around">
    <div class="form-group">    
        @if ($i != 1)
            @include('modal.modalbuttonprevious')
        @else
            @include('modal.modalbuttonempty')
        @endif
    </div>
</div>
<div class="d-flex justify-content-around">
    <div class="form-group">    
        @if ($i != count($contentstop['attributes']['q_explain']))
            @include('modal.modalbuttonnext')
        @else
            @include('modal.modalbuttoncomplete')
        @endif
    </div>
</div>