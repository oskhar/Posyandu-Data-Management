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
    </style>
</head>

<body>
    <h1>KOP Posyandu</h1>
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
