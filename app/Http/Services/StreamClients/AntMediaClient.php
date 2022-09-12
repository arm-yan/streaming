<?php

namespace App\Http\Services\StreamClients;

use App\DTO\import\CreateStreamDTO;
use App\DTO\StreamDTO;
use App\Http\Services\StreamClientInterface;
use GuzzleHttp\Client;

class AntMediaClient implements StreamClientInterface
{
    private Client $client;

    private string $endpoint = 'http://89.22.229.228:5080/TestApp/rest/v2';

    private array $error;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $id
     * @return StreamDTO
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function getById(string $id): StreamDTO
    {
        $res = $this->client->request('GET', $this->endpoint.'/broadcasts/'.$id);
        $stream = json_decode($res->getBody()->getContents(), true);

        return new StreamDTO($stream);
    }

    /**
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
