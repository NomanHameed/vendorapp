<div class="container">
    <div class="row">
        <div class="col-lg-4 pt-3">
            <h5>Resources</h5>
            <p class="text-muted">Activate Resources to Sync with Google Sheets</p>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="mb-3">Activate Resources</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="d-flex flex-row">
                                <div class="mt-auto">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input resources" id="products"
                                               name="resources" value="products"
                                               @if(\App\AppHelper::alreadyExistResource($request['store_id'],'products')) checked="checked" @endif>
                                        <label class="custom-control-label h6" for="products">Sync Products</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input resources" id="collections"
                                               name="resources" value="collections"
                                               @if(\App\AppHelper::alreadyExistResource($request['store_id'],'collections')) checked="checked" @endif>
                                        <label class="custom-control-label h6" for="collections">Sync
                                            Collections</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input resources" id="customers"
                                               name="resources" value="customers"
                                               @if(\App\AppHelper::alreadyExistResource($request['store_id'],'customers')) checked="checked" @endif>
                                        <label class="custom-control-label h6" for="customers">Sync Customers</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input resources" id="orders"
                                               name="resources" value="orders"
                                               @if(\App\AppHelper::alreadyExistResource($request['store_id'],'orders')) checked="checked" @endif>
                                        <label class="custom-control-label h6" for="orders">Sync Orders</label>
                                    </div>
                                </div>
                                <div class="ml-auto mt-auto">
                                    <a @click.prevent="updateResources('{{ route('store-update-resources',['store_id'=>$request['store_id']]) }}');"
                                       class="btn btn-light border px-4" id="updateResourceBtn">
                                        Update Resource <i class="fas fa-save fs-12px"></i>
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
