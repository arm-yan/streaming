<?php
declare(strict_types=1);

namespace App\Http\Services;

use App\DTO\import\CreateUserDTO;
use App\Repository\Eloquent\UserRepository;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    /**
     * @var UserRepository
     */
    protected UserRepository $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateUserDTO $data
     * @return Model
     */
    public function create(CreateUserDTO $data): Model
    {
        return $this->repository->create($data);
    }
}
