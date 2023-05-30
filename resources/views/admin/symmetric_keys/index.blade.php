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
                            <th scope="col">Date</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($keys as $key)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $key->description }}</td>
                                <td>{{ $key->type->name }}</td>
                                <td>{{ $key->bits->bytes() }}</td>
                                <td>{{ $key->created_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-ligth dropdown-toggle custom-dropdown-toggle"
                                            type="button"
                                            id="dropdownMenuButton{{ $loop->iteration }}"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <em class="bi bi-three-dots" style="font-size: 1.5rem;"></em>
                                        </button>

                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $loop->iteration }}">
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="{{ route('admin.symmetrics.show', $key) }}">
                                                    Show
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="{{ route('admin.symmetrics.edit', $key) }}">
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    href="#"
                                                    class="dropdown-item"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#destroyModal{{ $loop->iteration }}">
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>

                                        <x-destroy-modal
                                            :id="$loop->iteration"
                                            :route="route('admin.symmetrics.destroy', $key)">
                                        </x-destroy-modal>
                                    </div>
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
