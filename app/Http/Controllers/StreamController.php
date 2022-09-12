<?php

namespace App\Http\Controllers;

use App\DTO\import\CreateStreamDTO;
use App\Http\Requests\CreateStreamRequest;
use App\Http\Services\StreamService;
use App\Models\User;
use App\Repository\Eloquent\StreamRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Illuminate\Http\RedirectResponse;

class StreamController
{
    protected StreamService $streamService;

    protected StreamRepository $streamRepository;

    public function __construct(StreamService $streamService, StreamRepository $streamRepository)
    {
        $this->streamService = $streamService;
        $this->streamRepository = $streamRepository;
    }

    public function list()
    {
        return view('home', ['streams' => $this->streamRepository->all(), 'streamService' => $this->streamService]);
    }

    public function single(int $id)
    {
        return view('stream', ['stream' => $this->streamRepository->find($id), 'streamService' => $this->streamService]);
    }

    /**
     * @throws UnknownProperties
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function dashboard()
    {
        /** @var User $user */
        $user = Auth::user();
        $stream = $user->getStream();
        if(!$stream) {
            $data = new CreateStreamDTO([
                'userId' => $user->id
            ]);

            $stream = $this->streamService->create($data);
        }

        return view('user.dashboard', ['stream' => $stream]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws UnknownProperties
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(Request $request)
    {
        $imageName = null;

        if($request->hasFile('preview')) {
            $imageName = time().'.'.$request->preview->extension();
            $request->preview->move(public_path('images'), $imageName);
        }

        /** @var User $user */
        $user = Auth::user();
        $stream = $user->getStream();

        $streamData = new CreateStreamDTO([
            'userId' => $user->id,
            'streamId' => $stream->stream_id,
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'preview' => $imageName
        ]);

        $this->streamService->update($streamData);

        return back()->with(['stream' => $user->getStream()]);
    }
}
