<?php
declare(strict_types=1);

namespace App\Repository;

use App\DTO\import\CreateUserDTO;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function create(CreateUserDTO $data): Model;
}
