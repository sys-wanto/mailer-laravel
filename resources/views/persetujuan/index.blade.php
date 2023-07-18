@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable({
                "iDisplayLength": 50
            });


        });

        function generate() {
            var id = $('input[name=id_surat]').val();
            var persetujuan_ke = $('[name=persetujuan_ke]').val();
            var catatan = $('#catatan').val();
            $.ajax({
                url: "{{ route('persetujuan.setujui') }}",
                type: 'post',
                data: {
                    nomor: id,
                    catatan: catatan,
                    persetujuan_ke: persetujuan_ke,
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' //for object property name, use quoted notation shown in second
                },
                success: function(data) {
                    if (!data['is_error']) {
                        Swal.fire({
                            title: 'Berhasil di Setujui.',
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

        function tampilkanModal(id) {
            var disposisiModal = new bootstrap.Modal(document.getElementById('modal-persetujuan'), {
                backdrop: 'static',
                keyboard: false
            })
            var url = '{{ route('persetujuan.kepala') }}';

            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('input[name=id_surat]').val(id);
                    console.log(data);
                    if (!data['is_error']) {
                        $.each(data['data'], function(key, value) {
                            $('#persetujuan_ke')
                                .append($("<option></option>")
                                    .attr("value", value['id'])
                                    .text(value['name']));
                        })
                    } else {
                        $('#persetujuan_ke')
                            .append($("<option></option>")
                                .attr("value", '')
                                .text('Tidak ada'));
                    }
                    return data;
                },
                error: function(data) {
                    $('#persetujuan_ke')
                        .append($("<option></option>")
                            .attr("value", '')
                            .text('Tidak ada'));
                },

            }).done(function(data) {
                disposisiModal.show();
            })
        }

        function tampilkanModalSetujui(id) {
            var disposisiModal = new bootstrap.Modal(document.getElementById('modal-setujui'), {
                backdrop: 'static',
                keyboard: false
            })
            $('input[name=id_surat]').val(id);
            disposisiModal.show();
        }
    </script>
@stop
@extends('layouts.app')

@section('content')
    @if ($user->level != 'kepala_kantor')
        <div class="modal fade" id="modal-persetujuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="persetujuan" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="persetujuan">Persetujuan</h5>
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
                            <label for="persetujuan_ke" class="col-md-4 col-form-label">Persetujuan ke</label>
                            <div class="col-md-8">
                                <select class="form-control" id="persetujuan_ke" name="persetujuan_ke" required="">
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
                        <button type="button" class="btn btn-primary" onclick="generate()">Persetujuan</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="modal fade" id="modal-setujui" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="setujui" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="setujui">Setujui</h5>
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
                        <div class="form-group row d-none" style="margin-bottom: 20px;">
                            <label for="persetujuan_ke" class="col-md-4 col-form-label">Disposisi ke</label>
                            <div class="col-md-8">
                                <input type="text" id="persetujuan_ke" name="persetujuan_ke"
                                    value="{{ $user->id }}" />
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
                        <button type="button" class="btn btn-primary" onclick="generate()">Setujui</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                    <h4 class="card-title">Data Surat Belum Persetujuan</h4>

                    <div class="table-responsive">
                        <table class="table table-striped" id="table">
                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Type Surat | Nomor Surat
                                    </th>
                                    <th>
                                        Sifat Surat | Tanggal Surat
                                    </th>
                                    <th>
                                        Pengirim | Catatan
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
                                            {{ $collection['jenis_surat'] }} | {{ $collection['nomor_surat'] }}
                                        </td>
                                        <td>
                                            {{ $collection['sifat_surat'] }} |
                                            {{ $collection['tgl_terima'] }}
                                        </td>
                                        <td>
                                            {{ $collection['pengirim'] }} |
                                            {{ $collection['catatan'] }}
                                        </td>
                                        <td>
                                            <a href="{{ $collection['file'] }}">Cek Surat</a>
                                        </td>
                                        <td>
                                            @if ($user->level != 'kepala_kantor')
                                                <button type="button"
                                                    {{ $collection['tgl_kirim'] == '0000-00-00' ? '' : 'disabled' }}
                                                    class="btn btn-success btn-sm"
                                                    onclick="tampilkanModal('{{ $collection['type_surat_n_id'] }}')">
                                                    Persetujuan
                                                </button>
                                            @else
                                                <button type="button"
                                                    {{ $collection['tgl_kirim'] == '0000-00-00' ? '' : 'disabled' }}
                                                    class="btn btn-success btn-sm"
                                                    onclick="tampilkanModalSetujui('{{ $collection['type_surat_n_id'] }}')">
                                                    Setujui
                                                </button>
                                            @endif
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
