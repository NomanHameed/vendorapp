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
                    <th>Product Type</th>
                    <th>Handle</th>
                    <th>Published Scope</th>
                    <th>Tags</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key => $product)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->shopify_product_id }}</td>
                        <td>{{ $product->vendor }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection
