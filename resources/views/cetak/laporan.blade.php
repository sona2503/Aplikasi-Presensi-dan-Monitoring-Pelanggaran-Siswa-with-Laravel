<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggaran {{ $nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .letterhead {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
        }
        .letterhead img {
            width: 80px;
            margin-bottom: 10px;
        }
        .letterhead h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .letterhead p {
            margin: 2px 0;
            font-size: 12px;
        }
        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }
        .student-info {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .student-info div {
            flex: 1 1 45%;
            font-weight: bold;
        }
        .student-info div span {
            font-weight: normal;
        }
        h2 {
            text-align: center;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .total-point-card {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .card {
            width: 150px;
            padding: 10px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 1.2rem;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .card-title {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .total-point-value {
            font-size: 1.4rem;
            font-weight: bold;
            color: #333;
        }
        /* Tanda tangan */
        .signature {
            position: absolute;
            bottom: 20px; /* Jarak dari bawah halaman */
            right: 20px; /* Jarak dari kanan halaman */
            text-align: center;
        }
        .signature img {
            width: 100px; /* Ukuran tanda tangan */
            margin-top: 5px; /* Jarak antara tanggal dan tanda tangan */
        }
        .signature p {
            margin: 0;
            font-weight: bold;
        }
        .signature .date {
            margin-bottom: 20px; /* Jarak tambahan antara tanggal dan tanda tangan */
        }
        .signature .name {
            margin-top: 20px; /* Jarak antara tanda tangan dan nama */
        }
    </style>
</head>
<body>
    <div class="letterhead">
        <img src="{{ public_path('images/logo.png') }}" alt="School Logo">
        <h1>SEKOLAH DASAR ISLAM TERPADU<br>SD IT JABAL NUR</h1>
        <p>YAYASAN WALI MURID NURUL ITTIHAD</p>
        <p>Gamping Lor, Ambarketawang, Gamping, Sleman, Yogyakarta. Telp. 0274-2852139</p>
        <p>Email: sditjabalnur@gmail.com | Website: sditjabalnur.sch.id</p>
    </div>

    <div class="container">
        <div class="student-info">
            @foreach($siswa as $d)
                <div>Wali Kelas: <span>{{ $d->nama_guru }}</span></div>
                <div>Kelas: <span>{{ $d->kelas }}</span></div>
                <div>Nama Siswa: <span>{{ $d->nama }}</span></div>
                <div>NISN: <span>{{ $d->nisn }}</span></div>
            @endforeach    
        </div>

        <h2>Data Pelanggaran {{ $nama }}</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Pelanggaran</th>
                    <th>Catatan</th>
                    <th>Point</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $d)
                    <tr>
                        <td>{{ $d->waktu }}</td>
                        <td>{{ $d->pelanggaran }}</td>
                        <td>{{ $d->catatan }}</td>
                        <td>{{ $d->point }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data pelanggaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="total-point-card">
            <div class="card">
                <div class="card-title">Total Poin</div>
                <div class="total-point-value">{{ $totalPoint }}</div>
            </div>
        </div>

        <!-- Kolom tanda tangan -->
        <div class="signature">
            <p class="date">Tanggal: {{ date('d-m-Y') }}</p> <!-- Menambahkan tanggal di atas tanda tangan -->
            <img src="{{ public_path('images/signature.png') }}" alt="Tanda Tangan">
            <p class="name">(_____________)</p> <!-- Nama di bawah tanda tangan dengan jarak tambahan -->
        </div>
    </div>
</body>
</html>
