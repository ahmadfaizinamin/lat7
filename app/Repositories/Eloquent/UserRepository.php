<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Override;

class UserRepository implements UserRepositoryInterface
{
    #[Override]
    public function create(array $data)
    {
        return User::create($data);
    }
}