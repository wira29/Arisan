<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 60%;
            margin: auto;
            text-align: center;
        }

        .header-table {
            width: 100%;
            border: 2px solid black;
            border-collapse: collapse;
        }

        .header-table td {
            padding: 5px;
            border: 1px solid black;
            text-align: left;
        }

        /* Buat tabel ketentuan agar ukurannya seragam */
        .terms-table {
           width: 100%;
            border: 2px solid black;
            border-collapse: collapse;
        }

        .terms-table td {
            padding: 5px;
            border: 1px solid black;
            text-align: left;
            font-size: 11px;
        }

        .no-print {
            margin-top: 10px;
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
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td colspan="3" style="text-align: center;">
                    <h3>Arisan Sembako</h3>
                    <h1>"Meubel Aji"</h1>
                    <h3>JL. RAYA ABD SALEH RT 03/ RW 06</h3>
                    <h3>BORO BAMBAN - ASRIKATON</h3>
                    <h4>Telp/WA: 089621940222 / 082332591161</h4>
                </td>
            </tr>
        </table>

        <!-- Informasi Pribadi -->
        <table class="header-table">
            <tr>
                <td><strong>NAMA:</strong></td>
                <td colspan="2">{{ $peserta->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>ALAMAT:</strong></td>
                <td colspan="2">{{ $peserta->user->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>ARISAN:</strong></td>
                <td colspan="2">Rp {{ number_format($peserta->arisanUserProduks->sum('total_price'), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>TABUNGAN:</strong></td>
                <td colspan="2">Rp {{ number_format($peserta->user->tabungan ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>TOTAL:</strong></td>
                <td colspan="2">
                    Rp {{ number_format($peserta->arisanUserProduks->sum('total_price') + ($peserta->user->tabungan ?? 0), 0, ',',
                    '.') }}
                </td>
            </tr>
        </table>

        <!-- Ketentuan dalam bentuk tabel agar ukurannya sama -->
        <table class="terms-table">
            <tr>
                <td>
                    <strong>Ketentuan:</strong><br>
                    A. PEMBAYARAN HARUS RUTIN.<br>
                    B. BERHENTI DI PEMBAYARAN 1-3 DIANGGAP HANGUS.<br>
                    C. PEMBAYARAN DIMULAI TANGGAL.<br>
                    D. BARANG YANG SUDAH DIPILIH TIDAK BOLEH DITUKAR.<br>
                    E. SEMBAKO DIBAGI 2 MINGGU SEBELUM PUASA S/D MALAM 21.<br>
                    F. DAGING SAPI DIBAGIKAN MULAI MALAM KE 15-23 PUASA.<br>
                    G. BARANG YANG DIKIRIM(+ONGKOS KIRIM).
                </td>
            </tr>
        </table>

       <table class="header-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peserta->arisanUserProduks as $produk)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $produk->produk->nama }}</td>
                <td>{{ $produk->qty }}</td>
                <td>Rp {{ number_format($produk->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($produk->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

        <!-- Tombol Cetak -->
        <button class="no-print" onclick="window.print()">Cetak</button>
    </div>

</body>

</html>