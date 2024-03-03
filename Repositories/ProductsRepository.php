<?php

namespace Repositories;

use App\Http\Requests\Products\CreateProductsRequest;
use App\Models\Product;
use DB;
use Illuminate\Support\Str;

class ProductsRepository implements \ProductsRepositoryInterface
{

    public function create(CreateProductsRequest $request): Product|false
    {
        try {
            DB::beginTransaction();
            $data = $this->formRequestData($request);
            $data['attributes'] = $this->addSlugToAttributes($data['$attributes']);

            $product = Product::create($data['$attributes']);

            DB::commit();

            return $product;
        }catch (\Exception $e){
            DB::rollBack();
            logs()->warning($e);
            return false;
        }
    }

    protected function formRequestData(CreateProductsRequest $request): array
    {
        return [
            'attributes' => collect($request->validated())->except(['categories'])->toArray(),
            'categories' => $request->get('categories', [])
        ];
    }

    protected function addSlugToAttributes(array $attributes): array
    {
        return array_merge(
            $attributes,
            ['slug' => Str::of($attributes['title'])->slug()->value()]
        );
    }
}
