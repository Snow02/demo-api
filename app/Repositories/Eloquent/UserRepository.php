<?php
namespace App\Repositories\Eloquent;


use App\Repositories\Interfaces\UserRepositoryInterface;
class UserRepository extends Repository implements UserRepositoryInterface
{
    public function model()
    {
        // TODO: Implement model() method.
        return "App\Models\User";
    }
}