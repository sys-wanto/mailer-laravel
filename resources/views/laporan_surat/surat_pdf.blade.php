<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
    table {
        border-spacing: 0;
        width: 100%;
    }

    th {
        background: #404853;
        background: linear-gradient(#687587, #404853);
        border-left: 1px solid rgba(0, 0, 0, 0.2);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        padding: 8px;
        text-align: left;
        text-transform: uppercase;
    }

    th:first-child {
        border-top-left-radius: 4px;
        border-left: 0;
    }

    th:last-child {
        border-top-right-radius: 4px;
        border-right: 0;
    }

    td {
        border-right: 1px solid #c6c9cc;
        border-bottom: 1px solid #c6c9cc;
        padding: 8px;
    }

    td:first-child {
        border-left: 1px solid #c6c9cc;
    }

    tr:first-child td {
        border-top: 0;
    }

    tr:nth-child(even) td {
        background: #e8eae9;
    }

    tr:last-child td:first-child {
        border-bottom-left-radius: 4px;
    }

    tr:last-child td:last-child {
        border-bottom-right-radius: 4px;
    }

    img {
        width: 40px;
        height: 40px;
        border-radius: 100%;
    }

    .center {
        text-align: center;
    }
    </style>
    <link rel="stylesheet" href="">
    <title>Laporan Surat</title>
</head>

<body>
    <h1 class="center">LAPORAN SURAT MASUK</h1>
    <table id="pseudo-demo">
        <thead>
            <tr>
                <th>
                    No
                </th>
                <th>
                    Asal Surat Masuk / Perihal
                </th>
                <th>
                    Nomor Surat Masuk / Tanggal
                </th>
                <th>
                    Sifat Surat Masuk / Keamanan
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surat_masuk as $surat_masuks)
            <tr>
                <td>
                    {{$surat_masuks->id}}
                </td>
                <td>
                    {{$surat_masuks->asal_surat_masuk}}</a>
                    / {{$surat_masuks->perihal_surat_masuk}}
                </td>
                <td>
                    {{$surat_masuks->nomor_surat_masuk}} /
                    {{$surat_masuks->tanggal_surat_masuk}}
                </td>
                <td>
                    {{$surat_masuks->sifat_surat_masuk}} /
                    {{$surat_masuks->keamanan_surat_masuk}}
                </td>
                @endforeach
        </tbody>
    </table>
</body>

<body>
    <h1 class="center">LAPORAN SURAT KELUAR</h1>
    <table id="pseudo-demo">
        <thead>
            <tr>
                <th>
                    No
                </th>
                <th>
                    Perihal Surat Keluar
                </th>
                <th>
                    Nomor Surat Keluar / Tanggal
                </th>
                <th>
                    Sifat Surat Masuk / Keamanan
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($surat_keluar as $surat_keluars)
            <tr>
                <td>
                    {{$surat_keluars->id}}
                </td>
                <td>
                    {{$surat_keluars->perihal_surat_keluar}}</a>
                </td>
                <td>
                    - /
                    {{$surat_keluars->tanggal_surat_keluar}}
                </td>
                <td>
                    {{$surat_keluars->sifat_surat_keluar}} /
                    {{$surat_keluars->keamanan_surat_keluar}}
                </td>
                @endforeach
        </tbody>
    </table>
</body>

<body>
    <h1 class="center">LAPORAN NOTA DINAS</h1>
    <table id="pseudo-demo">
        <thead>
            <tr>
                <th>
                    No
                </th>
                <th>
                    Perihal Nota Dinas
                </th>
                <th>
                    Nomor Nota Dinas / Tanggal
                </th>
                <th>
                    Sifat Nota Dinas / Keamanan
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($nota_dinas as $nota_dinass)
            <tr>
                <td>
                    {{$nota_dinass->id}}
                </td>
                <td>
                    {{$nota_dinass->perihal_nota_dinas}}</a>
                </td>
                <td>
                    - /
                    {{$nota_dinass->tanggal_nota_dinas}}
                </td>
                <td>
                    {{$nota_dinass->sifat_nota_dinas}} /
                    {{$nota_dinass->keamanan_nota_dinas}}
                </td>
                @endforeach
        </tbody>
    </table>
</body>

<body>
    <h1 class="center">LAPORAN SURAT TUGAS</h1>
    <table id="pseudo-demo">
        <thead>
            <tr>
                <th>
                    No
                </th>
                <th>
                    Tempat Tugas / Perihal
                </th>
                <th>
                    Nomor Surat Tugas / Tanggal
                </th>
                <th>
                    Pegawai
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($surat_tugas as $surat_tugass)
            <tr>
                <td>
                    {{$surat_tugass->id}}
                </td>
                <td>
                    {{$surat_tugass->perihal_surat_tugas}}</a> / {{$surat_tugass->tempat_tugas}}
                </td>
                <td>
                    - /
                    {{$surat_tugass->tanggal_surat_tugas}}
                </td>
                <td>
                    {{$surat_tugass->pegawai->nama}}
                </td>
                @endforeach
        </tbody>
    </table>
</body>

</html>