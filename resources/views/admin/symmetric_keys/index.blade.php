@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-6">
                <h1>Symmetric keys</h1>
            </div>
            <div class="col-6 text-end align-self-center">
                <a class="btn btn-dark" href="{{ route('admin.symmetrics.create') }}">Create</a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Description</th>
                            <th scope="col">Type</th>
                            <th scope="col">Bytes</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($keys as $key)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    <a href="{{ route('admin.symmetrics.show', $key) }}">
                                        {{ $key->description }}
                                    </a>
                                </td>
                                <td>{{ $key->type->name }}</td>
                                <td>{{ $key->bits->bytes() }}</td>
                                <td>
                                    <a
                                        class="btn"
                                        href="{{ route('admin.symmetrics.show', $key) }}">
                                        Show
                                    </a>
                                    <a
                                        class="btn"
                                        href="{{ route('admin.symmetrics.edit', $key) }}">
                                        Edit
                                    </a>
                                    <a
                                        href="#"
                                        class="btn"
                                        onclick="event.preventDefault(); if (confirm('Delete key?')) { document.getElementById('destroyForm{{ $loop->iteration }}').submit(); }">
                                        Delete
                                    </a>

                                    <form
                                        action="{{ route('admin.symmetrics.destroy', $key) }}"
                                        id="destroyForm{{ $loop->iteration }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No records</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col">
                {{ $keys->links() }}
            </div>
        </div>
    </div>
@endsection
