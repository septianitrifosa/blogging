@extends('layouts.template')

@section('title', 'about')

@section('content')
    <div class="mt-4 p-5 bg-primary text-white rounded">
        <h1>{{ $title }}</h1>
        <p>{{ $description }}</p>
        {!! $button !!}
    </div>

@endsection
