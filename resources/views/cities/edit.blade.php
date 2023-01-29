@extends('layouts.main')

@section('content')
    <h1 class="mt-4">Cities</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Update') }}
                    <a href="{{ route('cities.index') }}" class="float-end">Back</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('cities.update', $city->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <label for="state_id" class="col-md-4 col-form-label text-md-end">{{ __('State') }}</label>

                            <div class="col-md-6">
                                <select id="state_id" class="form-select @error('state_id') is-invalid @enderror" name="state_id" required autofocus aria-label="Default select example">
                                    @foreach ($states as $state)
                                        <option value="{{$state->id}}" {{ $state->id == $city->state_id ? 'selected' : ''}}>{{$state->name}}</option>
                                    @endforeach
                                  </select>

                                @error('state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $city->name) }}" required>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
