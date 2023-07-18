@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable({
                "iDisplayLength": 50
            });

        });

        function tampilkanModal(id) {
            var disposisiModal = new bootstrap.Modal(document.getElementById('modal-disposisi'), {
                backdrop: 'static',
                keyboard: false
            })
            var url = '{{ route('user.get', 'true') }}';

            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('input[name=id_surat]').val(id);
                    console.log(data);
                    if (!data['is_error']) {
                        $.each(data['data'], function(key, value) {
                            $('#disposisi_ke')
                                .append($("<option></option>")
                                    .attr("value", value['id'])
                                    .text(value['name']));
                        })
                    } else {
                        $('#disposisi_ke')
                            .append($("<option></option>")
                                .attr("value", '')
                                .text('Tidak ada'));
                    }
                    return data;
                },
                error: function(data) {
                    $('#disposisi_ke')
                        .append($("<option></option>")
                            .attr("value", '')
                            .text('Tidak ada'));
                },

            }).done(function(data) {
                disposisiModal.show();
            })
        }

        function generate() {
            var id = $('input[name=id_surat]').val();
            var disposisi_ke = $('#disposisi_ke').val();
            var catatan = $('#catatan').val();
            console.log(disposisi_ke);
            console.log(catatan);
            $.ajax({
                url: "{{ route('disposisi.dispose') }}",
                type: 'post',
                data: {
                    nomor: id,
                    catatan: catatan,
                    disposisi_ke: disposisi_ke,
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' //for object property name, use quoted notation shown in second
                },
                success: function(data) {
                    if (!data['is_error']) {
                        Swal.fire({
                            title: 'Berhasil di Disposisikan.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then((value) => {
                            location.reload()
                        })
                    }
                },
                error: function(data) {
                    console.log('error')
                },
            })
        }

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

    <div class="modal fade" id="modal-disposisi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="disposisi" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="disposisi">Disposisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row d-none" style="margin-bottom: 20px;">
                        <label for="id_surat" class="col-md-4 col-form-label">Surat id</label>
                        <div class="col-md-8">
                            <input type="text" id="id_surat" name="id_surat" />
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 20px;">
                        <label for="disposisi_ke" class="col-md-4 col-form-label">Disposisi ke</label>
                        <div class="col-md-8">
                            <select class="form-control" id="disposisi_ke" name="disposisi_ke" required="">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" style="margin-bottom: 20px;">
                        <label for="catatan" class="col-md-4 col-form-label">Catatan</label>
                        <div class="col-md-8">
                            <textarea name="catatan" id="catatan"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="generate()">Disposisi</button>
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
                    <h4 class="card-title">Data Surat Masuk</h4>

                    <div class="table-responsive">
                        <table class="table table-striped" id="table">
                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Asal Surat Masuk | Perihal
                                    </th>
                                    <th>
                                        Nomor Surat Masuk | Tanggal
                                    </th>
                                    <th>
                                        Sifat Surat Masuk | Keamanan
                                    </th>
                                    <th>
                                        File Surat Masuk
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collections as $surat_masuks)
                                    <tr>
                                        <td>
                                            {{ $surat_masuks['id'] }}
                                        </td>
                                        <td>
                                            <a href="{{ route('surat_masuk_kepala_tu.show', $surat_masuks['id']) }}">
                                                {{ $surat_masuks['asal_surat_masuk'] }}</a>
                                            | {{ $surat_masuks['perihal_surat_masuk'] }}
                                        </td>
                                        <td>
                                            {{ $surat_masuks['nomor_surat_masuk'] }} |
                                            {{ $surat_masuks['tanggal_surat_masuk'] }}
                                        </td>
                                        <td>
                                            {{ $surat_masuks['sifat_surat_masuk'] }} |
                                            {{ $surat_masuks['keamanan_surat_masuk'] }}
                                        </td>
                                        <td>
                                            <a
                                                href="{{ asset('files/surat_masuk/' . $surat_masuks['file_surat_masuk']) }}">Download</a>
                                        </td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <button type="button" class="btn btn-success dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start"
                                                    data-id="{{ 'SuratMasuk-'.$surat_masuks['id'] }}"
                                                    style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">

                                                    @if (!$surat_masuks['disposed'])
                                                        <a href="#" class="dropdown-item"
                                                            onclick="tampilkanModal('{{ $surat_masuks['id'] }}')">
                                                            Disposisi
                                                        </a>
                                                    @endif
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
                    {{--  {!! $surat_masuks->links() !!} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
