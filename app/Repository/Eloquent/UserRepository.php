<?php
declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\DTO\import\CreateUserDTO;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param CreateUserDTO $data
     * @return Model
     */
    public function create(CreateUserDTO $data): Model
    {
        $model = new $this->model;

        $model->name = $data->name;
        $model->email = $data->email;
        $model->password = bcrypt($data->password);
        $model->save();

        return $model;
    }

    public function find($id): ?Model
    {
        return $this->model->query()->where('id',$id)->first();
    }
}
