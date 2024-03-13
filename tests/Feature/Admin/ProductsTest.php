<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\User;
use App\Services\Contract\FileStorageServiceInterface;
use App\Services\FileStorageService;
use Database\Seeders\AdminSeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function afterRefreshingDatabase()
    {
        $this->seed(PermissionSeeder::class);
        $this->seed(AdminSeeder::class);
    }
    public function test_create_product(): void
    {
        $file = UploadedFile::fake()->image('test_image.png');

        $data = array_merge(Product::factory()->make()->toArray(), ['thumbnail' => $file]);

        $this->instance(
            FileStorageServiceInterface::class,
            Mockery::mock(
                FileStorageService::class,
                function (MockInterface $mock) use ($file) {
                    $mock->shouldReceive('upload')
                        ->with($file, '')
                        ->once()
                        ->andReturn('image_uploaded.png');
                })
        );

        $response = $this->actionAs(User::role('admin')->first())
            ->post('admin.products.store', $data);

        $this->assertDatabaseHas(Product::class, [
            'title' => $data['title']
        ]);

        $product = Product::where('title', $data['title'])->first();
        $this->assertTrue(\Storage::has($product->thumbnail));

    }
}
