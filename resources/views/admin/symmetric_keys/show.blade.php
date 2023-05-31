@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-8">
                <h1><small>{{ $symmetricKey->description }}</small></h1>
            </div>
            <div class="col-4 text-end align-self-center">
                <a
                    href="#"
                    class="btn btn-outline-dark"
                    onclick="event.preventDefault(); if (confirm('Delete key?')) { document.getElementById('destroyForm{{ $symmetricKey->id }}').submit(); }">
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

        <form
            action="{{ route('admin.symmetrics.destroy', $symmetricKey) }}"
            id="destroyForm{{ $symmetricKey->id }}"
            method="POST">
            @csrf
            @method('DELETE')
        </form>

        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-3">
                                <h5 class="card-title font-weight-bold">Key</h5>
                                <p class="card-text">{{ $symmetricKey->getKey() }}</p>
                            </div>
                            <div class="col-3">
                                <h5 class="card-title font-weight-bold">KCV</h5>
                                <p class="card-text">{{ $symmetricKey->kcv }}</p>
                            </div>
                            <div class="col-3">
                                <h5 class="card-title font-weight-bold">Type</h5>
                                <p class="card-text">{{ $symmetricKey->type->name }}</p>
                            </div>
                            <div class="col-3">
                                <h5 class="card-title font-weight-bold">Bytes</h5>
                                <p class="card-text">{{ $symmetricKey->bits->bytes() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-6">
                                <h5 class="card-title font-weight-bold">Cryptogram</h5>
                                <p class="card-text">{{ $symmetricKey->getCryptogram() }}</p>
                            </div>
                            <div class="col-6">
                                <h5 class="card-title font-weight-bold">Transport key KCV</h5>
                                <p class="card-text">{{ $symmetricKey->transport_key_kcv }}</p>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Component</th>
                                            <th scope="col">Component KCV</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($symmetricKey->components as $component)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $component->getComponent() }}</td>
                                                <td>{{ $component->kcv }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-12">
                                <button
                                    class="btn btn-outline-dark"
                                    onclick="event.preventDefault(); if (confirm('Refresh transport key?')) { document.getElementById('RefreshForm{{ $symmetricKey->id }}').submit(); }">
                                    Refresh transport key
                                </button>
                            </div>
                        </div>

                        <form
                            action="{{ route('admin.symmetrics.components.update', $symmetricKey) }}"
                            id="RefreshForm{{ $symmetricKey->id }}"
                            method="POST">
                            @csrf
                            @method('PATCH')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
