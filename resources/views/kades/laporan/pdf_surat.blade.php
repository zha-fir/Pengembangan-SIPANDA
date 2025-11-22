<!DOCTYPE html>
<html>

<head>
    <title>Laporan Arsip Surat</title>
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
            background-color: #e0e0e0;
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
        <h3>Laporan Rekapitulasi Surat Keluar</h3>
        <p>{{ $periode }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Nomor Surat</th>
                <th>Jenis Surat</th>
                <th>Pemohon</th>
                <th>Penandatangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $surat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->isoFormat('D MMM Y') }}</td>
                    <td>{{ $surat->nomor_surat }}</td>
                    <td>{{ $surat->jenisSurat->nama_surat ?? '-' }}</td>
                    <td>{{ $surat->warga->nama_lengkap }}</td>
                    <td>{{ $surat->pejabatDesa->nama_pejabat ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total Surat Diterbitkan: {{ count($data) }}</p>
</body>

</html>