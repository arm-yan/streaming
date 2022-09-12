<?php
declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\DTO\import\CreateStreamDTO;
use App\DTO\StreamDTO;
use App\Models\Stream;
use App\Repository\StreamRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class StreamRepository extends BaseRepository implements StreamRepositoryInterface
{

    /**
     * StreamRepository constructor.
     *
     * @param Stream $model
     */
    public function __construct(Stream $model)
    {
        parent::__construct($model);
    }

    /**
     * @param CreateStreamDTO $data
     * @return Model
     */
    public function create(CreateStreamDTO $data): Model
    {
        $model = new $this->model;

        $model->user_id = $data->userId;
        $model->name = $data->name;
        $model->description = $data->description;
        $model->preview = $data->preview;
        $model->stream_id = $data->streamId;

        $model->save();

        return $model;
    }



    public function find($id): ?Model
    {
        return $this->model->query()->where('id',$id)->first();
    }

    /**
     * @param CreateStreamDTO $stream
     * @return bool
     */
    public function update(CreateStreamDTO $stream): bool
    {
        $model = $this->model->query()->where('stream_id',$stream->streamId)->first();
        $model->name = $stream->name;
        $model->description = $stream->description;
        $model->preview = $stream->preview;

        return $model->save();
    }
}
