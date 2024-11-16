<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::orderBy('name_customer', 'ASC')->get();
    }

    public function headings(): array
    {
        return [
            "ID Pembelian",
            "Nama Pembeli",
            "Daftar Obat",
            "Total Harga",
            "Nama Kasir",
            "Tanggal Pembelian",
        ];
    }

    public function map($order): array
    {
        $daftarObat = '';
        // 1. Antangin (2pcs) - Rp. 2.000, 2. Bodrex (1pcs) - Rp. 2.000, 3. Paracetamol (1pcs) - Rp. 2.000
        foreach ($order->medicines as $key => $value) {
            $format = $key + 1 . '. ' . $value['name'] . ' (' . ($value['quantity'] ?? 0) . ') - Rp. ' . number_format($value['total_price'] ?? 0, 0, ',', '.');
            $daftarObat.= $format;
    }
    return[
        $order->id,
        $order->name_customer,
        $daftarObat,
        "Rp. " . number_format($order->total_price, 0, ',', '.'),
        $order->user->name,
        $order->created_at->locale('id')->translatedFormat('l, j F Y H:i:s'),
    ];
    }

}
