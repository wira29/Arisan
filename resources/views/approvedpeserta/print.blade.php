<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: auto;
            text-align: center;
        }

        .header-table {
            width: 50%;
            border: 2px solid black;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .header-table td {
            padding: 10px;
            border: none;
        }
        .content-table {
        width: 50%;
        border: 2px solid black;
        margin-bottom: 20px;
        border-collapse: collapse;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .total {
            font-weight: bold;
            background: #f2f2f2;
        }

        .no-print {
            margin-top: 20px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Header dengan Bingkai -->
        <table class="header-table">
            <tr>
                <td style="text-align: center;">
                    <h2>Arisan Sembako</h2>
                    <h3>"Meubel Aji"</h3>
                    <h3>JL. RAYA ABD SALEH RT 03/ RW 06</h3>
                    <h3>BORO BAMBAN - ASRIKATON</h3>
                    <h4>Telp/WA: 089621940222 / 082332591161</h4>
                </td>
            </tr>
        </table>

        <!-- Informasi Pribadi -->
        <table class="header-table">
            <tr>
                <td style="text-align: center;">
                    <td><strong>Nama:</strong></td>
                        <td>{{ $peserta->user->name ?? '-' }}</td>
                        
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                <td><strong>Alamat:</strong></td>
                <td>{{ $peserta->user->alamat ?? '-' }}</td>
            
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                <td><strong>Arisan:</strong></td>
                <td>{{ $peserta->user->alamat ?? '-' }}</td>
            
                </td>
            </tr>
        </table>


        <!-- Detail Produk -->
        <h3>Detail Produk</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peserta->arisanUserProduks as $item)
                <tr>
                    <td>{{ $item->produk->nama }}</td>
                    <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tombol Cetak -->
        <button class="no-print" onclick="window.print()">Cetak</button>
    </div>

</body>

</html>