<?php

namespace App\DTO\import;

use Spatie\DataTransferObject\DataTransferObject;

class CreateStreamDTO extends DataTransferObject
{
    public int $userId;

    public ?string $name;

    public ?string $description;

    public ?string $preview;

    public ?string $streamId;

    public function setStreamId(string $streamId)
    {
        $this->streamId = $streamId;
    }
}
