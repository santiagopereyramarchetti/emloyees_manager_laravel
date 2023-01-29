@extends('layouts.main')

@section('content')
    <h1 class="mt-4">Deparments</h1>
    <div class="card p-0">
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <div class="card-header">
            <form method="GET" action="{{ route('deparments.index') }}" class="row gy-2 gx-3 align-items-center d-inline-flex">
                <div class="col-auto">
                  <label class="visually-hidden" for="autoSizingInput">Search</label>
                  <input type="search" name="search" class="form-control" id="autoSizingInput" placeholder="Name">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary float-end">Search</button>
                </div>
            </form>
            <a href="{{route('deparments.create')}}" class="btn btn-primary float-end">Create</a>
        </div>
        <div class="card-body">
            <table class="table table-light table-striped">
                <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deparments as $deparment)
                        <tr>
                            <th scope="row">{{$deparment->id}}</th>
                            <td>{{$deparment->name}}</td>
                            <td>
                                <a href="{{route('deparments.edit', $deparment->id)}}" class="btn btn-success">Edit</a>
                                <form class="d-inline" method="POST" action="{{route('deparments.destroy', $deparment->id)}}">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
@endsection
