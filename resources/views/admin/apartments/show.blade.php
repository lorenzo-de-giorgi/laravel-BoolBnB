@extends('layouts.admin')
@section('title', $apartment->title)

@section('content')
<section>
    <div class="d-flex justify-content-between align-items-center py-4">
        <h1>{{$apartment->title}}</h1>
        <div>
            <a href="{{route('admin.apartments.edit', $apartment->slug)}}" class="btn btn-secondary">Edit</a>
            <form action="{{route('admin.apartments.destroy', $apartment->slug)}}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button btn btn-danger"  data-item-title="{{ $apartment->title }}">
                 Delete apartment</i>
                </button>

            </form>
        </div>
    </div>
    <img class="w-50" src="{{asset('storage/'.$apartment->image)}}" alt="{{$apartment->title}}">
    <div>
        @if ($apartment->category)
            <h5>{{ $apartment->category->name }}</h5>
        @endif
    </div>
    <div>
        @if($apartment->technologies)
            @foreach ($apartment->technologies as $technology)
                <span class="badge text-bg-danger">{{$technology->name}}</span>
            @endforeach
        @endif
    </div>

    <p>{{$apartment->content}}</p>
</section>
@include('partials.modal-delete')
@endsection