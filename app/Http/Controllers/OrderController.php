<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as FacadePDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')
        ->when(request('date'), function ($query) {
            $query->whereDate('created_at', request('date'));
        })
        ->simplePaginate(10);
    return view('order.kasir.kasir', compact('orders'));
    }

    public function indexAdmin()
    {
        $orders = Order::with('user')
        ->when(request('date'), function ($query) {
            $query->whereDate('created_at', request('date'));
        })
        ->simplePaginate(10);
    return view('order.admin.data', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view('order.kasir.create', compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data request
        $request->validate([
            "name_customer" => "required",
            "medicines" => "required"
        ]);

        // mencari values array yang datanya sama
        $arrayValues = array_count_values($request->medicines);
        // membuat array kosong untuk menampung nilai format array yang baru
        $arrayNewMedicines = [];
        // looping array data duplikat
        foreach ($arrayValues as $key => $value) {
            // Mencari data obat berdasarkan id yang dipilih
            $medicine = Medicine::where('id', $key)->first();
            // untuk menotalkan harga medicine
            $totalPrice = $medicine['price'] * $value;

            // pengecekan ketersediaan stok
            if($medicine['stock'] < $value) {
                $valueFormBefore = [
                    'name_customer' => $request->name_customer,
                    'medicines' => $request->medicines,
                ];
                $msg = 'Stok Obat '. $medicine['name'] . ' Tidak Cukup. Tersisa '.$medicine['stock'];
                return redirect()->back()->with([
                    'failed' => $msg,
                    'valueFormBefore' => $valueFormBefore
                ]);
            }

            // format array baru ('Struktur nya')
            $arrayItem = [
                'id' => $key,
                'name' => $medicine['name'],
                'quantity' => $value,
                'price' => $medicine['price'],
                'total_price' => $totalPrice,
            ];

            array_push($arrayNewMedicines, $arrayItem);
        }

        // hitung total dengan total ppn nya huga
        $total = 0;
        // looping data array  dari array format baru
        foreach ($arrayNewMedicines as $item) {
            // Mentotalkan total price sebelum ppn kedalam variabel total
            $total += $item['total_price'];
        }

        // merubah total dikali dengan ppn sebesar 10%
        $ppn = $total + ($total * 0.1);

        // tambahkan result kedalam databse order
        $newOrder = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arrayNewMedicines,
            'name_customer' => $request->name_customer,
            'price' => $total,
            'total_price' => $ppn
        ]);

        foreach ($arrayNewMedicines as $key => $value) {
            $stockBefore = Medicine::where('id', $value['id'])->value('stock');

            Medicine::where('id', $value['id'])->update([
                'stock' => $stockBefore - $value['quantity']
            ]);
        }

        if ($newOrder) {
            // jika tambah newOrder berhasil, ambil data order berdasarkan kasir yang sedang login (where), dengan tanggal paling baru (orderBy), ambil hanya 1 data (first)
            // $result = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
            return redirect()->route('kasir.print', $newOrder['id'])->with('success', 'Berhasil Order');
        } else {
            return redirect()->back()->with('failed', 'Gagal Order');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('order.kasir.print', compact('order'));
    }

    public function downloadPDF($id)
    {
        // ambil data yg akan ditampilkan pada pdf, bisa juga dengan where atau eloquent lainnya dan jangan gunakan pagination
        $order = Order::find($id)->toArray(); 
        // kirim data yg diambil kepada view yg akan ditampilkan, kirim dengan inisial 
        view()->share('order', $order);
        // panggil view blade yg akan dicetak pdf serta data yg akan digunakan
        $pdf = FacadePDF::loadView('order.kasir.download', ['order' => $order]);
        // download PDF file dengan nama tertentu
        return $pdf->download('receipt.pdf');
    }


    public function exportExcel() {
        return Excel::download(new OrderExport, 'rekap-pembelian.xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}