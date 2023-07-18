@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable({
                "iDisplayLength": 50
            });
        });

        function tampilTrack(clickedElement) {
            var dataid = $(clickedElement).parent().attr("data-id");
            console.log(dataid);
            tampilModal(dataid);
        }

        function tampilModal(id) {
            var trackModal = new bootstrap.Modal(document.getElementById('modal-track'), {
                backdrop: 'static',
                keyboard: false
            })
            var url = '{{ route('disposisi.track', ':id') }}';
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    if (!data['is_error']) {
                        data['data'].forEach(element => {
                            if (element['STATUS_SURAT']) {
                                $(`#steptrack${element['URUTAN']}`).addClass('active');
                            } else {
                                $(`#steptrack${element['URUTAN']}`).removeClass('active');
                            }
                        });
                        $('#table-track').DataTable({
                            "autoWidth": false,
                            "data": data['data'],
                            "iDisplayLength": 10,
                            "paging": false,
                            "searching": false,
                            "ordering": false,
                            "columns": [{
                                    "data": "TITLE",
                                    "render": function(value, type, row, meta) {
                                        // if(meta.row==0){
                                        //     return `${row['PENGIRIM']=='-'?'Surat Masuk':row['PENGIRIM']} | ${row['TGL_KIRIM']}`;
                                        // }else{
                                        return `${row['PENGIRIM']} | ${row['TGL_KIRIM']}`;
                                        // }
                                        // return `${meta.row>=1?data['data'][meta.row-1]['PENGIRIM']:'Surat Masuk'} | ${row['TGL_KIRIM']=='0000-00-00'?'-':row['TGL_KIRIM']}`;
                                    }
                                },
                                {
                                    "data": "PENERIMA"
                                },
                                {
                                    "data": "CATATAN",
                                    "render": function(value, type, row, meta) {
                                        return `${row['CATATAN'].length<='0'?'-':row['CATATAN']}`;
                                        // return `${meta.row>=1?data['data'][meta.row-1]['PENGIRIM']:'Surat Masuk'} | ${row['TGL_KIRIM']=='0000-00-00'?'-':row['TGL_KIRIM']}`;
                                    }
                                },
                            ]
                        });
                    }
                    return data;
                },
                error: function(data) {
                    console.log('error')
                },

            }).done(function(data) {
                trackModal.show();
            })
        }

        $('#modal-track').on('hidden.bs.modal', function(e) {
            $('#table-track').DataTable().clear().destroy();
        })
    </script>
@stop
@extends('layouts.app')

@section('content')

    <div class="modal fade" id="modal-track" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="track" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="track">Track Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="bs-stepper">
                                <div class="bs-stepper-header" role="tablist">
                                    <!-- your steps here -->
                                    <div id="steptrack0" class="step" data-target="#surat-masuk">
                                        <button type="button" class="step-trigger" role="tab"
                                            aria-controls="surat-masuk" id="logins-part-trigger" disabled="disabled">
                                            <span class="bs-stepper-circle">1</span>
                                            <span class="bs-stepper-label">Surat Masuk</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div id="steptrack1" class="step" data-target="#kassubag-tu">
                                        <button type="button" class="step-trigger" role="tab"
                                            aria-controls="kassubag-tu" id="kassubag-tu" disabled="disabled">
                                            <span class="bs-stepper-circle">2</span>
                                            <span class="bs-stepper-label">Diterima oleh Kasubag TU</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div id="steptrack2" class="step" data-target="#kepala-kantor">
                                        <button type="button" class="step-trigger" role="tab"
                                            aria-controls="kassubag-tu" id="kepala-kantor" disabled="disabled">
                                            <span class="bs-stepper-circle">3</span>
                                            <span class="bs-stepper-label">Diterima oleh Kepala kantor</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div id="steptrack3" class="step" data-target="#kepala-seksi">
                                        <button type="button" class="step-trigger" role="tab"
                                            aria-controls="kassubag-tu" id="kepala-seksi" disabled="disabled">
                                            <span class="bs-stepper-circle">4</span>
                                            <span class="bs-stepper-label">Diterima oleh Kepala Seksi</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div id="steptrack4" class="step" data-target="#tindak-lanjut">
                                        <button type="button" class="step-trigger" role="tab"
                                            aria-controls="kassubag-tu" id="tindak-lanjut" disabled="disabled">
                                            <span class="bs-stepper-circle">5</span>
                                            <span class="bs-stepper-label">Diterima oleh Staff Seksi & akan di tindak
                                                lanjut</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-track">
                                    <thead>
                                        <tr>
                                            <th>
                                                Pengirim | Tanggal
                                            </th>
                                            <th>
                                                Penerima
                                            </th>
                                            <th>
                                                Catatan Pengirim
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
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
                    <h4 class="card-title">Data Surat Sudah Disposisi</h4>

                    <div class="table-responsive">
                        <table class="table table-striped" id="table">
                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Pengirim | Perihal
                                    </th>
                                    <th>
                                        Nomor | Tanggal Surat
                                    </th>
                                    <th>
                                        Disposisi Ke | Catatan
                                    </th>
                                    <th>
                                        File Surat
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($collections as $collection)
                                    <tr>
                                        <td>
                                            {{ $no++ }}
                                        </td>
                                        <td>
                                            {{ $collection['asal_surat_masuk'] }} |
                                            {{ $collection['perihal_surat_masuk'] }}
                                        </td>
                                        <td>
                                            {{ $collection['nomor_surat_masuk'] }} |
                                            {{ $collection['tanggal_surat_masuk'] }}
                                        </td>
                                        <td>
                                            {{ $collection['tujuan'] }} |
                                            {{ $collection['catatan'] }}
                                        </td>
                                        <td>
                                            <a href="{{ $collection['file'] }}">Cek Surat</a>
                                        </td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <button type="button" class="btn btn-success dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start"
                                                    data-id="{{ 'SuratMasuk-'.$collection['id'] }}"
                                                    style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                                                    <a class="dropdown-item" href="#" onclick="tampilTrack(this);">
                                                        Track
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    {{--  {!! $collection->links() !!} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
