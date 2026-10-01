<?php
namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserService
{
    protected UserRepositoryInterface $userRepo;
    protected $auth;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->auth = Auth::guard('api');
    }

    public function registerUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepo->create($data);

        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token,
            'expires_in' => config('jwt.ttl') * 60
        ];
    }

    public function loginUser(array $data)
    {
        $token = $this->auth->attempt($data);
        if (!$token) {
            throw new Exception('Email atau Password salah');
        }

        $user = $this->auth->user();

        return [
            'user' => $user,
            'token' => $token,
            'expires_in' => config('jwt.ttl') * 60
        ];
    }

    public function logoutUser()
    {
        $this->auth->logout();
    }
}