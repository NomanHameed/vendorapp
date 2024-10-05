@extends('layouts.app')

@section('content')
    <main id="order-wrapper">
        <h1>Product List</h1>
        <a class="btn btn-primary " href="{{ route('products')}}">Sync Shopify</a>
        {{-- <form action="{{ url('product/delete') }}" method="POST">
            @method('DELETE')
            <button type="submit" class="btn btn-danger mt-1">Delete</button>
        </form> --}}

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Shopify Product ID</th>
                    <th>Product Name</th>
                    <th>Vendor</th>
                    <th>Product Type</th>
                    <th>Tags</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key => $product)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $product->shopify_product_id }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->vendor }}</td>
                        <td>{{ $product->product_type }}</td>
                        <td>{{ $product->tags }}</td>
                        <td>{{ $product->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection
