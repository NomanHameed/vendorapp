<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\User;
use Signifly\Shopify\Shopify;

class Products extends Component
{
    public function render()
    {
        $shopify =  new Shopify(
            env('SHOPIFY_ACCESS_TOKEN'),
            env('SHOPIFY_DOMAIN'),
            env('SHOPIFY_API_VERSION')
        );
        $cursor = $shopify->paginateProducts();
        dd($cursor);

        return view('livewire.products');
    }
}
