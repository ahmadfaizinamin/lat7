<?php
namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Override;

class ProductRepository implements ProductRepositoryInterface
{
    protected Product $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    #[Override]
    public function getAll()
    {
        return $this->model->all();
    }

    #[Override]
    public function getById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    #[Override]
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    #[Override]
    public function update(int $id, array $data)
    {
        $product = $this->getById($id);
        
        $product->update($data);
        return $product;
    }

    #[Override]
    public function delete(int $id)
    {
        $product = $this->getById($id);
        
        return $product->delete();
    }
}