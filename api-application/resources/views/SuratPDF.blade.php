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
            font-size: 0.95rem;
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
                <h2 style="font-weight: light">PEMERINTAH KOTA TANGERANG</h2>
                <h2 style="font-weight: light">DINAS KESEHATAN</h2>
                <h2>UPT PUSKESMAS PERIUK JAYA</h2>
                <p>Jl. Periuk Jaya Permai 1 Kel. Periuk Jaya Kec. Periuk Kota Tangerang</p>
                <p>Tlp.(021) 59586750 Email : puskesmasperiukjaya@gmail.com</p>
            </td>
            <td class="right-image">
                <img src="./images/puskesmas.png" alt="Logo puskesmas">
            </td>
        </tr>
    </table>
    <hr>
    <br>
    <p style="line-height: 50%">
        Hal : <span style="float: right;">Surat Penugasan Kader Gendong Posyandu</span>
    </p>
    <p style="line-height: 50%">
        Nomor : <span style="float: right;">{{ $nomor }}</span>
    </p>
    <br><br><br>

    <p>{!! $kalimat_pembuka !!}</p>

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

    <p>{!! $isi_surat !!}</p>
    <p>{!! $kalimat_penutup !!}</p>
    <br><br><br><br>

    <p class="right-align">{{ $penanda_tangan }}</p>
    <br><br>
    <p class="right-align" style="line-height: 50%;">__________</p>
    <p class="right-align">{{ $tanggal_surat }}</p>
</body>

</html>
