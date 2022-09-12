<?php

namespace App\Http\Services;

use App\DTO\import\CreateStreamDTO;
use App\DTO\StreamDTO;

interface StreamClientInterface
{
    public function getById(string $id): StreamDTO;

    public function create(CreateStreamDTO $data): StreamDTO;

    public function update(StreamDTO $stream): bool;
}
