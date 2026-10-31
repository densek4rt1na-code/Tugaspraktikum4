<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Banjir</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #eef6fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .form-card {
            background-color: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 32px 28px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(25, 118, 210, 0.12);
            border: 2px solid #bbdefb;
        }

        h2 {
            color: #1565c0;
            text-align: center;
            margin-bottom: 24px;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #0d47a1;
            font-weight: 600;
            font-size: 0.9rem;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #90caf9;
            border-radius: 10px;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s ease;
            background-color: #f7faff;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #1e88e5;
            box-shadow: 0 0 0 3.5px rgba(30, 136, 229, 0.2);
            background-color: #ffffff;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #1976d2;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #1565c0;
        }

        button:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>

    <div class="form-card">
        <h2>Pelaporan Banjir</h2>
        
        <form action="/proses" method="post">
            @csrf

            <div class="form-group">
                <label for="nama">Nama Pelapor:</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama...">
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi Kejadian:</label>
                <input type="text" id="lokasi" name="lokasi" placeholder="Masukkan lokasi...">
            </div>

            <div class="form-group">
                <label for="tinggi_genangan">Tinggi Genangan Air (m):</label>
                <input type="number" id="tinggi_genangan" name="tinggi_genangan" step="0.01" placeholder="Contoh: 0.5">
            </div>

            <button type="submit">Kirim Laporan</button>
        </form>
    </div>

</body>
</html>