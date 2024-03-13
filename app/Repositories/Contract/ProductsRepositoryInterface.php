<?php

namespace App\Http\Repositories\Contract;

use App\Http\Requests\Products\CreateProductRequest;
use App\Models\Product;

interface ProductsRepositoryInterface
{
    public function create(CreateProductRequest $request): Product|false;
}
