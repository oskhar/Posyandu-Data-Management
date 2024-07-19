<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Surat Penugasan</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        p {
            margin: 0 0 10px 0;
        }

        hr {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .right-align {
            text-align: right;
        }

        .center-align {
            text-align: center;
        }

        .kop-surat {
            width: 104%;
            left: -10px;
            border: none;
            padding-bottom: 10px;
            margin-bottom: 10px;
            position: relative;
        }

        .kop-surat img {
            width: 100px;
            height: auto;
        }

        .kop-surat td {
            text-align: center;
            vertical-align: middle;
            border: none
        }

        .kop-surat td h2 {
            line-height: 0;
        }

        .kop-surat td p {
            font-size: 0.85rem;
            line-height: 0.2rem;
        }

        .kop-surat .left-image {
            text-align: left;
        }

        .kop-surat .right-image {
            text-align: right;
        }
    </style>
</head>

<body>
    <table class="kop-surat">
        <tr>
            <td class="left-image">
                <img src="./images/tangerang.png" alt="Logo kota tangerang">
            </td>
            <td>
                <h2 style="font-weight: light">POSYANDU MELATI IX</h2>
                <p>Jl. Vila mutiara pluit RT 02 RW 09 Kel. Periuk Jaya Kec. Periuk Kota Tangerang</p>
                <p>Tlp.(081) 29084810</p>
            </td>
            <td class="right-image">
                <img src="./images/posyandu.png" alt="Logo puskesmas">
            </td>
        </tr>
    </table>
    <hr>
    <br>
    <center>
        <p style="line-height: 50%;text-decoration:underline">Surat Penugasan Kader Gendong Posyandu</p>
        <p style="line-height: 50%">{{ $nomor }}</p>
    </center>
    <br><br>

    <div>{!! $kalimat_pembuka !!}</div>

    <br>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ditugaskan as $petugas)
                <tr>
                    <td>{{ $petugas['nama'] }}</td>
                    <td>{{ $petugas['jabatan'] }}</td>
                    <td>{{ $petugas['alamat'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>{!! $isi_surat !!}</div>

    <br>

    <div>{!! $kalimat_penutup !!}</div>
    <br><br><br><br>

    <p style="line-height:50%;text-align: right">Dibuat di : Tangerang</p>
    @php
        $bulan_labels = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
        $tanggal_surat = explode('-', $tanggal_surat);
        $tanggal_surat =
            $tanggal_surat[2] . ' ' . $bulan_labels[((int) $tanggal_surat[1]) - 1] . ' ' . $tanggal_surat[0];

    @endphp
    <p style="line-height:50%;text-align: right">Pada tanggal : {{ $tanggal_surat }}</p>
    <div style="float: right">
        <center>
            <p>{{ $jabatan_penanda_tangan }}</p>
            <br><br>
            <p style="text-decoration: overline">{{ $penanda_tangan }}</p>
        </center>
    </div>
</body>

</html>
