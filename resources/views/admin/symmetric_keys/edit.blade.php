@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-6">
                <h1>Edit symmetric key</h1>
            </div>
            <div class="col-6 text-end align-self-center">
                <a class="btn btn-dark" href="{{ route('admin.symmetrics.index') }}">Back</a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col">
                <form action="{{ route('admin.symmetrics.update', $symmetricKey) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="description" class="form-label">Usage description</label>
                        <input
                            type="text"
                            class="form-control"
                            id="description"
                            name="description"
                            value="{{ old('description', $symmetricKey->description) }}"
                            aria-describedby="Key description"
                            maxlength="255"
                            required>
                        @error('description')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-outline-dark">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
