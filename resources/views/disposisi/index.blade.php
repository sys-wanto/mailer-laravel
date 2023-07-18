@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable({
                "iDisplayLength": 50
            });


        });

        function generate() {
            var id = $('input[name=id_surat]').val();
            var disposisi_ke = $('[name=disposisi_ke]').val();
            var catatan = $('#catatan').val();
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

        function tampilkanModal(id) {
            var disposisiModal = new bootstrap.Modal(document.getElementById('modal-disposisi'), {
                backdrop: 'static',
                keyboard: false
            })
            var url = '{{ route('user.get') }}';

            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('input[name=id_surat]').val(id);
                    console.log(data);
                    if (!data['is_error']) {
                        $.each(data['data'], function(key, value) {
                            $('#disposisi_ke_tindak_lanjut')
                                .append($("<option></option>")
                                    .attr("value", value['id'])
                                    .text(value['name']));
                        })
                    } else {
                        $('#disposisi_ke_tindak_lanjut')
                            .append($("<option></option>")
                                .attr("value", '')
                                .text('Tidak ada'));
                    }
                    return data;
                },
                error: function(data) {
                    $('#disposisi_ke_tindak_lanjut')
                        .append($("<option></option>")
                            .attr("value", '')
                            .text('Tidak ada'));
                },

            }).done(function(data) {
                disposisiModal.show();
            })
        }

        function tampilkanModalTindakLanjut(id) {
            var disposisiModal = new bootstrap.Modal(document.getElementById('modal-tindak-lanjut'), {
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
    @if ($user->level == 'staff_seksi' || $user->level == 'staff_tu')
        <div class="modal fade" id="modal-tindak-lanjut" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="tindak-lanjut" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tindak-lanjut">Tindak Lanjut</h5>
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
                            <label for="disposisi_ke" class="col-md-4 col-form-label">Disposisi ke</label>
                            <div class="col-md-8">
                                <input type="text" id="disposisi_ke" name="disposisi_ke" value="{{ $user->id }}" />
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
                        <button type="button" class="btn btn-primary" onclick="generate()">Tindak Lanjut</button>
                    </div>
                </div>
            </div>
        </div>
    @else
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
                                <select class="form-control" id="disposisi_ke_tindak_lanjut" name="disposisi_ke"
                                    required="">
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
                    <h4 class="card-title">Data Surat Belum Disposisi</h4>

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
                                        Disposisi Dari | Catatan
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
                                            {{ $collection['asal_surat_masuk'] }} | {{ $collection['perihal_surat_masuk'] }}
                                        </td>
                                        <td>
                                            {{ $collection['nomor_surat_masuk'] }} |
                                            {{ $collection['tanggal_surat_masuk'] }}
                                        </td>
                                        <td>
                                            {{ $collection['asal'] }} |
                                            {{ $collection['catatan'] }}
                                        </td>
                                        <td>
                                            <a href="{{ $collection['file'] }}">Cek Surat</a>
                                        </td>
                                        <td>
                                            @if ($user->level == 'staff_seksi' || $user->level == 'staff_tu')
                                                <button type="button"
                                                    {{ $collection['tgl_kirim'] == '0000-00-00' ? '' : 'disabled' }}
                                                    class="btn btn-success btn-sm"
                                                    onclick="tampilkanModalTindakLanjut('{{ $collection['id'] }}')">
                                                    Tindak Lanjut
                                                </button>
                                            @else
                                                <button type="button"
                                                    {{ $collection['tgl_kirim'] == '0000-00-00' ? '' : 'disabled' }}
                                                    class="btn btn-success btn-sm"
                                                    onclick="tampilkanModal('{{ $collection['id'] }}')">
                                                    Disposisi
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
