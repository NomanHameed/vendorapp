<?php
$routeName = request()->route()->getName();
?>
<nav class="navbar navbar-expand bg-light navbar-light border-bottom fixed-top b-0 top-nav p-0">
    <div class="container">

        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link {{ $routeName=='products.index'?'active':'' }}" href="{{ route('products.index',$request ?? '') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $routeName=='roles.index'?'active':'' }}" href="{{ route('roles.index',$request ?? '') }}">Manage Role</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $routeName=='users.index'?'active':'' }}" href="{{ route('users.index',$request ?? '') }}">Users</a>
                </li>
            </ul>
            {{-- <li class="nav-item">
                <a class="nav-link update_stock_btn {{ $routeName=='update_stock'?'active':'' }}"
                    href="{{ route('update_stock',$request ?? '') }}">Orders</a>
            </li> --}}

            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                <button class="btn btn-primary">logout</button>
            </form>

        </div>
    </div>
</nav>
