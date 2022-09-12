@extends('layouts.app')

@section('content')
    <div class="form-info">
        @include('auth._registration',['style' => 'margin-left: auto;'])
    </div>
@endsection
