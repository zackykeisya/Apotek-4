<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        #back-wrap {
            margin: 20px auto;
            width: 500px;
            display: flex;
            justify-content: flex-end;
        }

        .btn-back {
            padding: 10px 20px;
            color: #fff;
            background: #666;
            border-radius: 5px;
            text-decoration: none;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            transition: background 0.3s ease;
        }

        .btn-back:hover {
            background: #333;
        }

        #receipt {
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            width: 90%;
            max-width: 600px;
            background: #FFF;
            border-radius: 8px;
        }

        h2 {
            font-size: 1.5rem;
            color: #333;
            margin: 0;
        }

        p {
            font-size: 0.9rem;
            color: #555;
            line-height: 1.5;
            margin: 0;
        }

        #top {
            margin-top: 20px;
            text-align: center;
        }

        #top .info {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td, th {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .tabletitle {
            background: #f2f2f2;
            font-size: 1rem;
            font-weight: bold;
            color: #333;
        }

        .itemtext {
            font-size: 0.9rem;
            color: #555;
        }

        .btn-print {
            float: right;
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
            background: #eee;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .btn-print:hover {
            background: #ccc;
        }

        #legalcopy {
            margin-top: 20px;
            font-size: 0.8rem;
            color: #888;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="back-wrap">
        <a href="{{ route('kasir.order') }}" class="btn-back">Kembali</a>
    </div>
    <div id="receipt">
        <a href="{{ route('kasir.download', $order['id'] )}}" class="btn-print">Cetak (.pdf)</a>
        <center id="top">
            <div class="info">
                <h2>Apotek Jaya Abadi</h2>
            </div>
        </center>
        <div id="mid">
            <div class="info">
                <p>
                    Alamat: sepanjang jalan kenangan<br>
                    Email: apotekjayaabadi@gmail.com<br>
                    Phone: 000-111-2222<br>
                </p>
            </div>
        </div>
        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td>Obat</td>
                        <td>Total</td>
                        <td>Harga</td>
                    </tr>
                    @foreach ($order['medicines'] as $medicine)
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">{{ $medicine['name'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ $medicine['quantity'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">Rp. {{ number_format($medicine['price'], 0, ',', '.') }}</p>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="tabletitle">
                        <td></td>
                        <td>PPN (10%)</td>
                        @php
                            $ppn = $order['total_price'] * 0.1;
                        @endphp
                        <td>Rp. {{ number_format($ppn, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td>Total Harga</td>
                        <td>Rp. {{ number_format($order['total_price'], 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            <div id="legalcopy">
                <p class="legal"><strong>Terima kasih atas pembelian Anda!</strong> Kami menghargai kepercayaan Anda kepada kami.</p>
            </div>
        </div>
    </div>
</body>

</html>