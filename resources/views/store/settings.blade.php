@extends('layouts.app')

@section('content')

<section class="mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 pt-3">
                <h4>Fashion Biz</h4>
                <p class="text-muted">Fashion Biz price margin setting</p>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                    <form method="post" action="{{route('store.setting-update')}}" data-ajaxsave="1">
                        <input type="hidden" name="store_id" value="{{$store_id}}">
                        <div class="row gx-3">
                            <!-- <div class="col-md-6">
                                <label for="ac_number" class="col-form-label">Account Number <small class="text-muted">(User Name)</small></label>
                                <input type="number" id="ac_number" class="form-control" name="account_number" value="{{ $account_number ?? ''}}">
                            </div>
                            <div class="col-md-6">
                                <label for="api_key" class="col-form-label">API Key <small class="text-muted">(Password)</small></label>
                                <input type="password" id="api_key" name=" api_key" class="form-control" value="{{ $api_key ?? ''}}">
                            </div> -->
                        </div>

                        <div class="row gx-3 mt-2">
                            <!-- <div class="col-md-6">
                                <label class="col-form-label">New Products As</label>
                                <select class="form-select text-capitalize" name="new_product">
                                    <option {{ @$new_product == 'active' ? 'selected' : '' }}>active</option>
                                    <option {{ @$new_product == 'draft' ? 'selected' : '' }}>draft</option>
                                </select>
                                <small class="form-text text-muted">Import new products as Active or draft</small>
                            </div> -->
                            <div class="col-md-6">
                                <label class="col-form-label">Margin Type</label>
                                <select class="form-select text-capitalize" name="marrgin_type">
                                    <option {{ @$marrgin_type == 'percent' ? 'selected' : '' }} value="percent">Percentage (%)</option>
                                    <option {{ @$marrgin_type == 'fixed' ? 'selected' : '' }} value="fixed">Fixed ($)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="price_margin" class="col-form-label">Add Price Margin</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="price_margin" value="{{ $price_margin ?? ''}}" step="0.01">
                                    <div class="input-group-text">%</div>
                                </div>
                                <small class="form-text text-muted">Cost + Margin {{ @$new_product == 'fixed' ? '$' : '%' }}</small>
                            </div>
                            
                        </div>

                        <!-- <div class="row gx-3 mt-2">
                            <div class="col-md-6">
                                <label class="col-form-label">Unavailable Products</label>
                                <select class="form-select text-capitalize" name="na_product">
                                    <option {{ @$na_product == 'draft' ? 'selected' : '' }}>draft</option>
                                    <option {{ @$na_product == 'archived' ? 'selected' : '' }}>archived</option>
                                    <option {{ @$na_product == 'delete' ? 'selected' : '' }}>delete</option>
                                </select>
                                <small class="form-text text-muted">If any product is unavailable on S&S</small>
                            </div>
                        </div> -->

                        <!-- <div class="row">
                            <div class="col-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  id="import-cats" name="import_cats" value="1" {{ !isset($import_cats) || @$import_cats ? 'checked' : ''}}>
                                    <label class="form-check-label" for="import-cats">Import Categories as Collections</label>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  id="import_brands" name="import_brands" value="1" {{ !isset($import_brands) || @$import_brands ? 'checked' : ''}}>
                                    <label class="form-check-label" for="import_brands">Import Brands as product's vendors</label>
                                </div>
                            </div>
                        </div> -->

                        
                        <button type="submit" class="btn btn-primary mt-3">Update Settings</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection