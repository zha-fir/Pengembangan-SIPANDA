<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penduduk</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>PEMERINTAH DESA PANGGULO</h2>
        <h3>{{ $judul }}</h3>
        <p>Tanggal Cetak: {{ $tanggal }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>JK</th>
                <th>Alamat / Dusun</th>
                <th>Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $warga)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $warga->nik }}</td>
                    <td>{{ $warga->nama_lengkap }}</td>
                    <td>{{ $warga->jenis_kelamin }}</td>
                    <td>{{ $warga->kk->alamat_kk ?? '-' }} ({{ $warga->kk->dusun->nama_dusun ?? '-' }})</td>
                    <td>{{ $warga->pekerjaan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total Data: {{ count($data) }} Jiwa</p>
</body>

</html>