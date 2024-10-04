@if (session()->has('success'))
    <div class="alert alert-success fade in alert-dismissible show" style="margin-top:18px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" style="font-size:20px">×</span>
        </button>
        <strong>Success!</strong> {!! session()->get('success') !!}
    </div>
@endif
