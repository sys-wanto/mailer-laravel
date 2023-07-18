@extends('layouts.app')

@section('content')
<div class="row">

    <div class="col-lg-2">
        <a href="{{ route('input_data.create') }}" class="btn btn-primary btn-rounded btn-fw"><i class="fa fa-plus"></i>
            Add Data</a>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        {{-- <form action="{{ url('import_data') }}" method="post" class="form-inline" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="input-group {{ $errors->has('importdata') ? 'has-error' : '' }}">
            <input type="file" class="form-control" name="importdata" required="">

            <span class="input-group-btn">
                <button type="submit" class="btn btn-success" style="height: 38px;margin-left: -2px;">Import</button>
            </span>
        </div>
        </form> --}}

    </div>
    <div class="col-lg-12">
        @if (Session::has('message'))
        <div class="alert alert-{{ Session::get('message_type') }}" id="waktu2" style="margin-top:10px;">
            {{ Session::get('message') }}</div>
        @endif
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <h4 class="card-title pull-left">Portal Data</h4>
                {{-- <a href="{{url('format_data')}}" class="btn btn-xs btn-info pull-right">Format data</a> --}}
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                            <tr>
                                <th>
                                    Tahun Data
                                </th>
                                <th>
                                    Data Utama
                                </th>
                                <th>
                                    Jenis Data
                                </th>
                                <th>
                                    Kategori Data
                                </th>
                                <th>
                                    Jumlah Data
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($input_datas as $input_data)
                            <tr>
                                <td>
                                    {{ $input_data->tahun_data->tahun_data }}
                                </td>
                                <td class="py-1">
                                    <a href="{{ route('input_data.show', $input_data->id) }}">
                                        {{ $input_data->data_utama->nama_data }}
                                    </a>
                                </td>
                                <td>
                                    {{ $input_data->jenis_data->nama_jenis_data }}
                                </td>
                                <td>
                                    <ul>
                                        @foreach($input_data->jenis_data->kategori_datas as $value)
                                        <li>{{$value->nama_kategori_data}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    {{ $input_data->jumlah_data }}
                                </td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-success dropdown-toggle btn-sm"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" x-placement="bottom-start"
                                            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                                            <a class="dropdown-item"
                                                href="{{ route('input_data.edit', $input_data->id) }}"> Edit </a>
                                            <form action="{{ route('input_data.destroy', $input_data->id) }}"
                                                class="pull-left" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button class="dropdown-item"
                                                    onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{--  {!! $input_datas->links() !!} --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
    $('#table').DataTable({
        "iDisplayLength": 50
    });

});
</script>
@stop