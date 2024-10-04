<div class="container">
    <div class="row">
        <div class="col-lg-4 pt-3">
            <h5>Account</h5>
            <p class="text-muted">Connect Google Account with your store</p>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="mb-3">Google Sheets</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="d-flex flex-row">
                                <div class="p-1 mr-2">
                                    <img
                                        src="{{ \App\AppHelper::getActiveSheetField($request['store_id'],'user_picture') }}"
                                        class="img-fluid img-thumbnail"
                                        onerror="{{ asset('images/no_avatar.png') }}"
                                        style="width: 39px;height: 39px;border-radius: 100%;">
                                </div>
                                <div class="p-1">
                                    <div>Sheet
                                        Name: {{ \App\AppHelper::getActiveSheetField($request['store_id'],'sheet_name') }}</div>
                                    <div>Email Account
                                        : {{ \App\AppHelper::getActiveSheetField($request['store_id'],'user_email') }}</div>
                                </div>
                                <div class="ml-auto mt-auto">
                                    <a @click.prevent="requestForGoogleSheetConnection();"
                                       id="googleSheetRequestSender"
                                       href="{{ route('google-sheet-request',['store_id'=>$request['store_id']]) }}"
                                       class="btn btn-light border px-4 connectToSheet">
                                        Re Connect  <i class="fas fa-sync-alt fs-12px" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
