@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products Management</h2>
            </div>
            <div class="pull-right">
                {{-- @can('role-create') --}}
                <a class="btn btn-primary " href="{{ route('products-sync')}}">Sync Shopify</a>
                <form action="{{ url('product/delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger mt-1">Delete</button>
                </form>

                {{-- @endcan --}}
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Shopify Product ID</th>
            <th>Product Name</th>
            <th>Vendor</th>
            <th>Product Type</th>
            <th>Tags</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
        @foreach($products as $key => $product)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $product->shopify_product_id }}</td>
            <td>{{ $product->title }}</td>
            <td>{{ $product->vendor }}</td>
            <td>{{ $product->product_type }}</td>
            <td>{{ $product->tags }}</td>
            <td>{{ $product->status }}</td>
            <td>
                <a class="btn btn-info" href="{{ route('products.show', $product->id) }}">Show</a>
                {{-- @can('role-edit') --}}
                <a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}">Edit</a>
                {{-- @endcan --}}

                {!! Form::open(['method' => 'DELETE', 'route' => ['products.destroy', $product->id], 'style' => 'display:inline']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}

            </td>
        </tr>
    @endforeach
    </table>
    {!! $products->render() !!}
@endsection
