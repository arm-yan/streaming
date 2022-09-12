<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class StreamDTO extends DataTransferObject
{
    public string $streamId;

    public ?string $status;

    public ?string $name;

    public ?string $description;
}
