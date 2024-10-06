@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Product Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3">
            <strong>Name:</strong>
            {{ $product->title }}
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <strong>Vendor:</strong>
            {{ $product->vendor }}
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <strong>Product Type:</strong>
            {{ $product->product_type }}
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3">
            <strong>Status:</strong>
            {{ $product->status }}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Variants:</strong>
                {{-- @if (!empty($rolePermissions)) --}}
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Varient ID</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Policy</th>
                        <th>Sku</th>
                        <th>Weight</th>
                        <th>Weight Unit</th>
                        <th>Inventory Quantity</th>
                        <th width="280px">Action</th>
                    </tr>
                    @foreach ($product->variants as $key => $variant)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $variant->shopify_product_id }}</td>
                            <td>{{ $variant->title }}</td>
                            <td>{{ $variant->price }}</td>
                            <td>{{ $variant->inventory_policy }}</td>
                            <td>{{ $variant->sku }}</td>
                            <td>{{ $variant->weight }}</td>
                            <td>{{ $variant->weight_unit }}</td>
                            <td>{{ $variant->inventory_quantity }}</td>
                            <td>
                                {{-- @can('role-edit') --}}
                                <a class="btn btn-primary" href="{{ route('product-sync', $variant->id) }}">Sync</a>
                                {{-- @endcan --}}
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{-- @endif --}}
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Options:</strong>
                {{-- @if (!empty($rolePermissions)) --}}
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Option ID</th>
                        <th>Shopify Product ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Value</th>
                    </tr>
                    @foreach ($product->options as $key => $option)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $option->shopify_option_id }}</td>
                            <td>{{ $option->shopify_product_id }}</td>
                            <td>{{ $option->name }}</td>
                            <td>{{ $option->position }}</td>
                            <td>{{ $option->value }}</td>
                        </tr>
                    @endforeach
                </table>
                {{-- @endif --}}
            </div>
        </div>
    </div>
@endsection
