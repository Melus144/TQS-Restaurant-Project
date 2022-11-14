@extends('admin.layouts.app')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
@endpush

@section('content-header')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <div>
            <h1 class="mt-4 h3">Food</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb ">
                    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Food</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{route('admin.food.create')}}" class="btn btn-sm btn-primary"><i
                    class="fas fa-plus"></i> Add Food</a>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <table id="foodTable" class="table">
                <thead class="card-header">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Units</th>
                    <th scope="col">Type</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Stock</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@include('admin.users.partials._index_js')
