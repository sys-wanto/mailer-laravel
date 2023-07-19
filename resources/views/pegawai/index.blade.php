@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        $('#table').DataTable({
            "iDisplayLength": 50
        });

    });

</script>
@stop
@extends('layouts.app')

@section('content')
<div class="row">

    <div class="col-lg-2">
        <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-rounded btn-fw"><i class="fa fa-plus"></i>
            Add Pegawai</a>
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
                <h4 class="card-title">Data Pegawai</h4>

                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                            <tr>
                                <th>
                                    Nama
                                </th>
                                <th>
                                    NIP
                                </th>
                                <th>
                                    Seksi
                                </th>
                                <th>
                                    Jabatan
                                </th>
                                <th>
                                    Status Pegawai
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pegawai as $pegawais)
                            <tr>
                                <td class="py-1">
                                    @if($pegawais->users->gambar)
                                    <img src="{{url('images/user', $pegawais->users->gambar)}}" alt="image"
                                        style="margin-right: 10px;" />
                                    @else
                                    <img src="{{url('images/user/default.png')}}" alt="image"
                                        style="margin-right: 10px;" />
                                    @endif

                                    {{$pegawais->nama}}
                                </td>
                                <td>
                                    <a href="{{route('pegawai.show', $pegawais->id)}}">
                                        {{$pegawais->nip}}
                                    </a>
                                </td>
                                <td>
                                    {{$pegawais->seksi->nama_seksi}}
                                </td>
                                <td>
                                    {{$pegawais->jabatan->nama_jabatan}}
                                </td>
                                <td>
                                    {{$pegawais->status_pegawai}}
                                </td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-success dropdown-toggle btn-sm"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" x-placement="bottom-start"
                                            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                                            <a class="dropdown-item" href="{{route('pegawai.edit', $pegawais->id)}}"> Edit
                                            </a>
                                            <form action="{{ route('pegawai.destroy', $pegawais->id) }}" class="pull-left"
                                                method="post">
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
                {{--  {!! $pegawais->links() !!} --}}
            </div>
        </div>
    </div>
</div>
@endsection