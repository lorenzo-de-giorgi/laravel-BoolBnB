@extends('layouts.admin')

@section('title', 'Create Project')

@section('content')
    <section>
        <h2>{{$apartment->title}}</h2>
        <img src="{{asset('storage/' . $apartment->image)}}" alt="{{$apartment->title}}">
       
    </section>

@endsection