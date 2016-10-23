@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @include('flash::message')
                <div class="panel panel-info">
                    <div class="panel-heading">Management Calculate Value</div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="30" class="text-center">#</th>
                            <th>Name</th>
                            <th>Value</th>
                            <th width="60" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($values->count() == 0)
                            <tr>
                                <td colspan="7" class="text-center">Data is empty</td>
                            </tr>
                        @else
                            @foreach($values as $key => $value)
                                <tr>
                                    <td>{{ (($values->currentPage() - 1 ) * $values->perPage() ) + ($key+1) }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->value }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('calculate_values.edit', $value->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{ $values->links() }}
            </div>
        </div>
    </div>
@endsection
