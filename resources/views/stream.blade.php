@extends('layouts.app')

@section('content')
    <div class="form-info">
        <div class="row">
            <div class="col-md-8" style="text-align: center">
                <div style="text-align: left; color: white">
                    @if($streamService->isBroadcasting($stream->stream_id))
                        <iframe width="100%" height="500" src="{{ getenv('BROADCAST_SERVER') }}/play.html?name={{ $stream['stream_id'] }}" frameborder="0" allowfullscreen></iframe>
                    @else
                        @if($stream->preview)
                            <img width="100%" height="220" src="{{ asset('images/'.$stream->preview) }}" alt="Stream is offline">
                        @else
                            <img width="100%" height="220" src="{{ asset('images/placeholder.png') }}" alt="Stream is offline">
                        @endif
                    @endif
                    Name: {{ $stream->name }}<br>
                    Author: {{ $stream->user->name }}<br>
                    Description: {{ $stream->description }}
                </div>
            </div>
            <div class="col-md-4">
                @include('layouts.sidebar')
            </div>
        </div>
    </div>
@endsection
