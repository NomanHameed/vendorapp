<div class="container">

    <div class="row">
        <div class="col-12 my-3 text-right">
            <a class="btn btn-sm btn-info" target="_blank"
               href="https://docs.google.com/spreadsheets/d/{{\App\AppHelper::getParentSheetId($request['store_id'])}}/edit#gid={{ \App\AppHelper::getInnerSheetId('orders',\App\AppHelper::getParentSheetId($request['store_id']),$request['store_id']) }}">View
                Sheet</a>
        </div>
        <div class="col-lg-4 pt-3">
            <h5>Sheet Settings</h5>
            <p class="text-muted">Update Google Sheets spreadsheets</p>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col align-self-center">
                            <h6 class="mb-3">Orders</h6>
                        </div>
                        <div class="col text-right align-self-center">
                            <p class="my-1"><strong class="text-info">{{ $totalOrders }}</strong> Orders Synced</p>
                        </div>
                    </div>
                    <div class="text-right my-2">
                        <a class="btn btn-sm btn-success" id="syncAllBtn"
                           @click.prevent="syncAll('{{ route('orders-sync',['store_id'=>$request['store_id']]) }}')">Sync
                            Orders <i class='fas fa-sync-alt fs-12px'></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
