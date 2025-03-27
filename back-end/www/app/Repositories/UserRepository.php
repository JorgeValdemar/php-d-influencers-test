<?php
 
namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository
{ 
    public function create(array $data): Model
    {
        return User::create($data);
    }
}