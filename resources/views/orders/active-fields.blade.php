<ul id="sortable" class="list-unstyled list-group sortable-list">
    @php
        $storeActiveFields = \App\AppHelper::getStoreActiveFields($request['store_id'],'orders');
    @endphp
    @if(count($storeActiveFields)>0)
        @foreach($storeActiveFields as $field)
            <li class="list-group-item @if($field['active']==false) unactive @endif">
                <i class="fas fa-arrows-alt grag-icon"></i>
                <input type="text" value="{{ $field['name'] }}"
                       class="border-0 column_name"
                       name="default[{{$field['value']}}]">
                <i class="far {{ $field['active']==true?'fa-eye':'fa-eye-slash' }} float-right toggle-active mt-1"></i>
                <input type="hidden" value="{{ $field['active']==true?1:0 }}"
                       class="column_active"
                       name="active[{{$field['value']}}]">
            </li>
        @endforeach
    @endif
</ul>

