<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Receipt {{ $payment->receipt_no }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .receipt-info {
            width: 100%;
            margin-bottom: 20px;
        }

        .receipt-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-info td {
            padding: 5px 0;
            vertical-align: top;
        }

        .receipt-info .label {
            width: 30%;
            font-weight: bold;
        }

        .amount-section {
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            margin: 20px 0;
            text-align: center;
        }

        .amount-section .amount {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }

        .footer {
            margin-top: 30px;
            border-top: 1px solid #ccc;
            padding-top: 15px;
        }

        .signature {
            float: right;
            text-align: center;
            width: 200px;
        }

        .qr-placeholder {
            width: 80px;
            height: 80px;
            border: 1px dashed #ccc;
            display: inline-block;
            text-align: center;
            line-height: 80px;
            font-size: 10px;
            color: #999;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 48px;
            color: rgba(0, 0, 0, 0.05);
            z-index: -1;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="watermark">SIKOPI PASAR</div>

    <div class="header">
        <h1>TANDA BUKTI PEMBAYARAN RETRIBUSI</h1>
        <h2>SISTEM INFORMASI KOPERASI PASAR</h2>
        <p>Jl. Merdeka No. 123, Kota Bandung | Telp: (022) 1234-5678</p>
    </div>

    <div class="receipt-info">
        <table>
            <tr>
                <td class="label">No. Resi:</td>
                <td><strong>{{ $payment->receipt_no }}</strong></td>
                <td class="label">Tanggal Cetak:</td>
                <td>{{ now()->format('d/m/Y H:i:s') }}</td>
            </tr>
            <tr>
                <td class="label">Nama Pedagang:</td>
                <td><strong>{{ $payment->levy->traderKiosk->trader->name }}</strong></td>
                <td class="label">NIK:</td>
                <td>{{ $payment->levy->traderKiosk->trader->nik_masked }}</td>
            </tr>
            <tr>
                <td class="label">Kios:</td>
                <td>{{ $payment->levy->traderKiosk->kiosk->kiosk_no }}</td>
                <td class="label">Kategori:</td>
                <td>{{ $payment->levy->traderKiosk->kiosk->category }}</td>
            </tr>
            <tr>
                <td class="label">Pasar:</td>
                <td>{{ $payment->levy->traderKiosk->kiosk->market->name }}</td>
                <td class="label">Luas Kios:</td>
                <td>{{ $payment->levy->traderKiosk->kiosk->area_m2 }} m²</td>
            </tr>
            <tr>
                <td class="label">Periode:</td>
                <td>
                    @php
                    $year = substr($payment->levy->period_month, 0, 4);
                    $month = substr($payment->levy->period_month, 4, 2);
                    $monthName = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][intval($month)];
                    @endphp
                    {{ $monthName }} {{ $year }}
                </td>
                <td class="label">Jatuh Tempo:</td>
                <td>{{ $payment->levy->due_date->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Bayar:</td>
                <td>{{ $payment->paid_at->format('d/m/Y') }}</td>
                <td class="label">Metode Bayar:</td>
                <td>
                    @switch($payment->method)
                    @case('cash') Tunai @break
                    @case('transfer') Transfer Bank @break
                    @case('qris') QRIS @break
                    @default {{ $payment->method }}
                    @endswitch
                </td>
            </tr>
        </table>
    </div>

    <div class="amount-section">
        <p style="margin: 0; font-size: 14px;">JUMLAH YANG DIBAYAR</p>
        <div class="amount">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
        @if($payment->amount < $payment->levy->amount)
            <p style="margin: 5px 0 0 0; color: #ffc107; font-weight: bold;">
                PEMBAYARAN SEBAGIAN<br>
                <small>Sisa: Rp {{ number_format($payment->levy->amount - $payment->amount, 0, ',', '.') }}</small>
            </p>
            @else
            <p style="margin: 5px 0 0 0; color: #28a745; font-weight: bold;">LUNAS</p>
            @endif
    </div>

    <div style="margin: 20px 0;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <strong>Rincian Perhitungan:</strong><br>
                    <small>
                        Retribusi Dasar: Rp {{ number_format($payment->levy->amount, 0, ',', '.') }}<br>
                        Formula Version: {{ $payment->levy->formula_version }}<br>
                        Status: {{ ucfirst($payment->levy->status) }}
                    </small>
                </td>
                <td style="text-align: center;">
                    <div class="qr-placeholder">
                        QR Code<br>
                        Verification
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div style="float: left; width: 50%;">
            <p><strong>Catatan:</strong></p>
            <ul style="font-size: 10px; margin: 0; padding-left: 15px;">
                <li>Simpan bukti pembayaran ini sebagai arsip</li>
                <li>Tunjukkan saat ada pemeriksaan petugas</li>
                <li>Hubungi (022) 1234-5678 untuk informasi lebih lanjut</li>
            </ul>
        </div>

        <div class="signature">
            <p>Petugas Penerima</p>
            <br><br>
            <p style="border-top: 1px solid #000; margin: 0; padding-top: 5px;">
                <strong>{{ $payment->collector_name }}</strong>
            </p>
        </div>

        <div style="clear: both;"></div>

        <div style="text-align: center; margin-top: 20px; font-size: 10px; color: #666;">
            <p>Dokumen ini digenerate secara otomatis oleh Sistem SIKOPI PASAR</p>
            <p>{{ config('app.url') }} | Email: info@sikopi.go.id</p>
        </div>
    </div>
</body>

</html>