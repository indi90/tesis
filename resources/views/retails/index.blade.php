@extends('layouts.app')

@push('script-body')
<script>
    $("#all").click(function () {
        $('input[name="items[]"]').prop('checked', $(this).prop('checked'));
    });

    $('#delete').on('click', function (){
//        console.log($("#find-table input:checkbox:checked").map(function(){
//            return $(this).val();
//        }).get());
        $.ajax({
            url: '{{ route('retails.multiple_delete') }}',
            method: "POST",
            data: {
                '_token': $('meta[name=csrf-token]').attr('content'),
                retailID: $("#find-table input:checkbox:checked").map(function(){return $(this).val();}).get()
            },
            success: function (response) {
                window.location.replace('/admin/retails');
            }
        });
    });
</script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @include('flash::message')
                <div class="panel panel-info">
                    <div class="panel-heading">Management Data Retail <button type="button" class="btn btn-success pull-right btn-xs" data-toggle="modal" data-target="#addRetail">Add Retail</button></div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center" width="53">
                                <input id="all" type="checkbox">
                                <div class="btn-group dropdown m-0">
                                    <button type="button" class="btn btn-white btn-xs dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" id="delete">Delete</a></li>
                                    </ul>
                                </div>
                            </th>
                            <th>Label</th>
                            <th>Longitude</th>
                            <th>Latitude</th>
                            {{--<th>District</th>--}}
                            {{--<th>Sub District</th>--}}
                            <th width="120" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody id="find-table">
                        @if($retails->count() == 0)
                            <tr>
                                <td colspan="7" class="text-center">Data is empty</td>
                            </tr>
                        @else
                            @foreach($retails as $key => $retail)
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="items[]" value="{{ $retail->id }}"></td>
                                    <td>{{ $retail->label }}</td>
                                    <td>{{ $retail->longitude }}</td>
                                    <td>{{ $retail->latitude }}</td>
                                    {{--<td>{{ $retail->district }}</td>--}}
                                    {{--<td>{{ $retail->sub_district }}</td>--}}
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('retails.edit', $retail->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ route('retails.destroy', $retail->id) }}" class="btn btn-danger btn-sm" data-method="delete" data-confirm="Apakah Anda yakin menghapus data {{ $retail->label }}?">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{ $retails->links() }}
            </div>
        </div>
    </div>
    <div class="modal fade" id="addRetail" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title" id="title">Choose Add Method</h4>
                    <h4 class="modal-title" id="newTitle">Upload File</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" id="upload">Upload File</button>
                                <a href="{{ route('retails.create') }}" class="btn btn-info">Manual Add</a>
                            </div>
                        </div>
                        <div class="col-sm-8 col-sm-offset-2">
                            <form class="form-horizontal" action="{{ route('retails.store') }}" id="formUpload" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <input type="text" name="upload_file" value="true" hidden>
                                <div class="form-group">
                                    <label for="inputFile" class="col-sm-2 control-label">File</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="inputFile" name="file">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-body')
<script>
    $('#formUpload').hide();
    $('#newTitle').hide();
    $("#upload").click(function(){
        $(".btn-group").hide();
        $("#title").hide();
        $('#formUpload').show();
        $('#newTitle').show();
    });
    $('#addRetail').on('hidden.bs.modal', function () {
        location.reload();
    })
</script>
@endpush
