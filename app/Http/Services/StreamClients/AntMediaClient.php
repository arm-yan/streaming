<?php

namespace App\Http\Services\StreamClients;

use App\DTO\import\CreateStreamDTO;
use App\DTO\StreamDTO;
use App\Http\Services\StreamClientInterface;
use GuzzleHttp\Client;

class AntMediaClient implements StreamClientInterface
{
    /**
     * Guzzle Client
     * @var Client
     */
    private Client $client;

    /**
     * Broadcast server endpoint
     *
     * @var string
     */
    private string $endpoint;

    /**
     * Errors array
     *
     * @var array
     */
    private array $error;

    public function __construct()
    {
        $this->endpoint = getenv('BROADCAST_SERVER').'/rest/v2';
        $this->client = new Client();
    }

    /**
     * Get broadcast by ID
     *
     * @param string $id
     * @return StreamDTO
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function getById(string $id): StreamDTO
    {
        //Get broadcast object from the broadcast platform
        $res = $this->client->request('GET', $this->endpoint.'/broadcasts/'.$id);

        $stream = json_decode($res->getBody()->getContents(), true);

        return new StreamDTO($stream);
    }

    /**
     * Create broadcast object in the broadcast platform
     *
     * @param CreateStreamDTO $data
     * @return StreamDTO
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function create(CreateStreamDTO $data): StreamDTO
    {
        $res = $this->client->request('POST', $this->endpoint.'/broadcasts/create', [
            'json' =>[
                'name' => $data->name,
                'description' => $data->description
            ]
        ]);

        $stream = json_decode($res->getBody()->getContents(), true);

        return new StreamDTO($stream);
    }

    /**
     * Updates broadcast object in the broadcast platform
     * @param StreamDTO $stream
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function update(StreamDTO $stream): bool
    {
        try {
            $res = $this->client->request('PUT', $this->endpoint.'/broadcasts/'.$stream->streamId, [
                'json' =>[
                    'name' => $stream->name,
                    'description' => $stream->description
                ]
            ]);
        } catch (\Exception $exception) {
            $this->error = [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ];

            return false;
        }

        $result = json_decode($res->getBody()->getContents(), true);

        return $result['success'];
    }

    /**
     * @return array
     */
    public function getError(): array
    {
        return $this->error;
    }
}
