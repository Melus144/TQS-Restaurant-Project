@extends('admin.layouts.app')

@section('content-header')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <div>
            <h1 class="h3 mt-4">Create new food</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb ">
                    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.food.index')}}">Food</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create food</div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.food.store')}}">
                        @csrf
                        @include('admin.food._fields')
                        <div class="d-inline-block mt-3">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Create
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
