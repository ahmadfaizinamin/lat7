<?php
namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService 
{
    protected ProductRepositoryInterface $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAllCategory()
    {
        return $this->productRepo->getAll();
    }

    public function getByIdCategory(int $id)
    {
        return $this->productRepo->getById($id);
    }

    public function createCategory(array $data)
    {
        return $this->productRepo->create($data);
    }

    public function updateCategory(int $id, array $data)
    {
        return $this->productRepo->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->productRepo->delete($id);
    }
}