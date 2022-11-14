@extends('admin.layouts.app')

@section('content-header')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <div>
            <h1 class="mt-4 h3">Edit '{{$food->name}}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb ">
                    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.food.index')}}">Food</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit food</div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.food.update', $food)}}">
                        @csrf
                        @method('PATCH')
                        @include('admin.food._fields')
                        <button type="submit" class="p-4 bg-blue-400">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
