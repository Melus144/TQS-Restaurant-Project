@extends('admin.layouts.app')

@section('content-header')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <div>
            <h1 class="mt-4 h3">Edit '{{$user->firstname}} {{$user->lastname}}'</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb ">
                    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Users</a></li>
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
                <div class="card-header">Edit user</div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.users.update', $user)}}">
                        @csrf
                        @method('PATCH')
                        @include('admin.users._fields')
                        <div class="d-inline-block mt-3">
                            <x-submit-button/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
