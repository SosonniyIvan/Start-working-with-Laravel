<?php

use App\Http\Requests\Products\CreateProductsRequest;
use App\Models\Product;

interface ProductsRepositoryInterface
{
    public function create(CreateProductsRequest $request): Product|false;
}
