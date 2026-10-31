<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Banjir</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Memposisikan konten tepat di tengah layar */
        body {
            background-color: #eef6fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Kartu pembungkus laporan */
        .card {
            background-color: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 32px 28px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(25, 118, 210, 0.12);
            border: 2px solid #bbdefb;
        }

        /* Judul */
        h2 {
            color: #1565c0;
            text-align: center;
            margin-bottom: 24px;
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Kotak informasi data */
        p {
            background-color: #f7faff;
            border: 1.5px solid #90caf9;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #333333;
            font-size: 0.95rem;
        }

        p strong {
            color: #0d47a1;
            font-size: 0.9rem;
        }

        /* Tombol Kembali ke Form */
        .btn-back {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #1976d2;
            color: #ffffff;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 20px;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        .btn-back:hover {
            background-color: #1565c0;
        }

        .btn-back:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Laporan Banjir</h2>
        <p><strong>Nama Pelapor:</strong> {{ $nama }}</p>
        <p><strong>Lokasi:</strong> {{ $lokasi }}</p>
        <p><strong>Tinggi Genangan air:</strong> {{ $tinggi }}</p>

        <!-- Tombol Kembali ke Form -->
        <a href="/form" class="btn-back">Kembali ke Form</a>
    </div>

</body>
</html>