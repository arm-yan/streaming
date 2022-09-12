<?php

namespace App\Http\Services;

use App\DTO\import\CreateStreamDTO;
use App\DTO\StreamDTO;
use App\Http\Services\StreamClients\AntMediaClient;
use App\Repository\Eloquent\StreamRepository;
use Illuminate\Database\Eloquent\Model;

class StreamService
{
    /**
     * @var StreamRepository
     */
    protected StreamRepository $repository;

    private StreamClientInterface $client;

    /**
     * @param StreamRepository $repository
     */
    public function __construct(StreamRepository $repository, AntMediaClient $client)
    {
        $this->repository = $repository;
        $this->client = $client;
    }

    /**
     * @param CreateStreamDTO $data
     * @return Model
     */
    public function create(CreateStreamDTO $data): Model
    {
        $stream = $this->client->create($data);

        $data->setStreamId($stream->streamId);

        return $this->repository->create($data);
    }

    /**
     * @param string $id
     * @return StreamDTO
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function getStream(string $id): StreamDTO
    {
        return $this->client->getById($id);
    }

    /**
     * @param string $id
     * @return string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function getStreamStatus(string $id): string|null
    {
        $stream = $this->getStream($id);

        return $stream->status;
    }

    /**
     * @param string $id
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function isBroadcasting(string $id): bool
    {
        $stream = $this->getStream($id);

        return $stream->status == 'broadcasting';
    }

    /**
     * @param CreateStreamDTO $stream
     * @return bool|array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function update(CreateStreamDTO $stream): bool|array
    {
        if(!$this->repository->update($stream)) {
            return false;
        }

        $streamDTO = new StreamDTO([
            'streamId' => $stream->streamId,
            'name' => $stream->name,
            'description' => $stream->description
        ]);

        if(!$this->client->update($streamDTO)) {
            return $this->client->getError();
        }

        return true;
    }
}
