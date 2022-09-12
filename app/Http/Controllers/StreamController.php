<?php

namespace App\Http\Controllers;

use App\DTO\import\CreateStreamDTO;
use App\Http\Services\StreamService;
use App\Models\User;
use App\Repository\Eloquent\StreamRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class StreamController
{
    /**
     * @var StreamService
     */
    protected StreamService $streamService;

    /**
     * @var StreamRepository
     */
    protected StreamRepository $streamRepository;

    /**
     * @param StreamService $streamService
     * @param StreamRepository $streamRepository
     */
    public function __construct(StreamService $streamService, StreamRepository $streamRepository)
    {
        $this->streamService = $streamService;
        $this->streamRepository = $streamRepository;
    }

    /**
     * Returns the Page with the list of streams
     *
     * @return View
     */
    public function list(): View
    {
        return view('home', ['streams' => $this->streamRepository->all(), 'streamService' => $this->streamService]);
    }

    /**
     * Returns the Stream Page with all the details
     * @param int $id
     * @return View
     */
    public function single(int $id): View
    {
        return view('stream', ['stream' => $this->streamRepository->find($id), 'streamService' => $this->streamService]);
    }

    /**
     * Users stream dashboard page
     * If stream didnt exists, creates stream entity and
     * broadcast on broadcasting platform
     *
     * @throws UnknownProperties
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function dashboard()
    {
        //Get authorized user
        /** @var User $user */
        $user = Auth::user();

        //Try to get authorized users stream
        $stream = $user->getStream();
        if(!$stream) {
            //Create StreamDTO for new stream entity
            $data = new CreateStreamDTO([
                'userId' => $user->id
            ]);

            //Creates stream entity and broadcast on broadcasting platform
            $stream = $this->streamService->create($data);
        }

        //Return stream dashboard page with stream details
        return view('user.dashboard', ['stream' => $stream]);
    }

    /**
     * Handles stream details update for entity and broadcast
     *
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
