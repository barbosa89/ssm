@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-10">
                <h1><small>{{ $symmetricKey->description }}</small></h1>
            </div>
            <div class="col-2 text-end align-self-center">
                <a
                    href="#"
                    class="btn btn-outline-dark"
                    data-bs-toggle="modal"
                    data-bs-target="#destroyModal{{ $symmetricKey->id }}">
                    Delete
                </a>

                <a
                    class="btn btn-outline-dark ms-2"
                    href="{{ route('admin.symmetrics.edit', $symmetricKey) }}">
                    Edit
                </a>

                <a class="btn btn-dark ms-2" href="{{ route('admin.symmetrics.index') }}">Back</a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title font-weight-bold">Type</h5>
                                <p class="card-text">{{ $symmetricKey->type->name }}</p>
                            </div>
                            <div class="col-6">
                                <h5 class="card-title font-weight-bold">Bytes</h5>
                                <p class="card-text">{{ $symmetricKey->bits->bytes() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <key-split :secret-key='@json($symmetricKey)'></key-split>

        <x-destroy-modal
            :id="$symmetricKey->id"
            :route="route('admin.symmetrics.destroy', $symmetricKey)">
        </x-destroy-modal>
    </div>
@endsection
