<?php
namespace App\Repository;

use App\DTO\import\CreateStreamDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface StreamRepositoryInterface
{
    public function create(CreateStreamDTO $data): Model;

    public function update(CreateStreamDTO $stream): bool;
}
