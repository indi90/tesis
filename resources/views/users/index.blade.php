@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @include('flash::message')
                <div class="panel panel-info">
                    <div class="panel-heading">Management Data User <a href="{{ route('users.create') }}" class="btn btn-success btn-xs pull-right">Add User</a></div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="30" class="text-center">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin</th>
                            <th>Join Date</th>
                            <th width="120" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($users->count() == 0)
                            <tr>
                                <td colspan="7" class="text-center">Data is empty</td>
                            </tr>
                        @else
                            @foreach($users as $key => $user)
                                <tr>
                                    <td>{{ (($users->currentPage() - 1 ) * $users->perPage() ) + ($key+1) }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    @if($user->is_admin)
                                        <td><span class="label label-info">Yes</span></td>
                                    @else
                                        <td><span class="label label-danger">No</span></td>
                                    @endif
                                    <td>{{ $user->created_at->format('d-M-Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm" data-method="delete" data-confirm="Apakah Anda yakin menghapus data {{ $user->name }}?">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
