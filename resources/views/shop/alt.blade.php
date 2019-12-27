@extends('layouts.template')

@section('title', 'Shop Alternative')

@section('main')
    <h1>Shop - alternative listing</h1>
    
    @foreach($genres as $genre)
        <h2 value="{{ $genre->id }}">{{ucfirst($genre->name)}}</h2>

    @foreach($genre->records as $record)
        <ul>
            <li><a href="shop/{{ $record->id }}">{{ $record->artist }} - {{ $record->title }}</a> | Price:
                € {{ number_format($record->price,2) }} | Stock: {{ $record->stock }}
            </li>
        </ul>
    @endforeach
    @endforeach
@endsection
