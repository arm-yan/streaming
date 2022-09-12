@extends('layouts.app')

@section('content')
    <div class="form-info">
        <div class="row">
            <div class="col-md-4">
                <div class="w3_info">
                    <h1>Dashboard</h1>
                    <p class="sub-para">StreamKey: <b>{{ $stream->stream_id }}</b></p>
                    <h2>Details</h2>
                    <form action="{{ route('stream.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input name="name" type="text" placeholder="Name" value="{{ $stream->name }}">
                            @error('name')<div class="error-box"> {{ $message }} </div>@enderror
                        </div>
                        <div class="input-group">
                            <input name="description" type="text" placeholder="Description" value="{{ $stream->description }}">
                            @error('description')<div class="error-box"> {{ $message }} </div>@enderror
                        </div>
                        <h2>Preview Image</h2>

                        <div class="input-group">
                            <input name="preview" type="file">
                            @error('preview')<div class="error-box"> {{ $message }} </div>@enderror
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Update</button>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                @include('layouts.sidebar')
                <iframe width="100%" height="220" src="{{ getenv('BROADCAST_SERVER') }}/play.html?name={{ $stream->stream_id }}" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
@endsection
