@extends('templates.app')

@section('content-dinamis')

<div class="container mt-4">
    @if(Auth::user()->role == 'kasir')
    <div class="d-flex justify-content-end">
        <a href="{{ route('kasir.create') }}" class="btn btn-primary">+ Tambah Order</a>
    </div>
    @endif
    <div class="my-5 d-flex ">
        <a href="{{route('export.excel')}}" class="btn btn-primary">Export Data (excel)</a>
    </div>
    <h1>DATA PEMBELIAN: {{ Auth::user()->name }}</h1>
    <div class="mt-4">
            <form action="{{ route('kasir.order') }}" method="GET" class="d-flex justify-content-end align-items-center gap-2 mb-3 search-form">
                <input type="date" name="date" class="form-control date-input" placeholder="Cari berdasarkan tanggal">
                <button type="submit" class="w-25 btn btn-primary">Cari Data Obat</button>
                <a href="?" class="btn btn-secondary">Clear</a>
            </form>
    </div>
    <table class="table table-striped table-bordered mt-3 text-center table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Obat</th>
                <th scope="col">Pembeli</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Nama Kasir</th>
                <th scope="col">Tanggal</th>
                @if(Auth::user()->role == 'kasir')
                <th scope="col">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $index => $order)
            <tr>
                <td>{{ ($orders->currentPage() - 1) * $orders->perpage() + ($index + 1) }}</td>
                <td>
                    <ol>
                        @foreach ($order->medicines as $medicine)
                        <li>{{ $medicine['name'] }} ({{ $medicine['qty'] ?? 0 }}) : Rp. {{ number_format($medicine['total_price'] ?? 0, 0, ',', '.') }}</li>
                        @endforeach
                    </ol>
                </td>
                <td>{{ $order->name_customer }}</td>
                <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td>{{ $order['user']['name'] }}</td>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->locale('id')->translatedFormat('l, d F Y H:i:s') }}</td>
                @if(Auth::user()->role == 'kasir')
                <td>
                    <a href="{{ route('kasir.print', $order->id) }}" class="btn btn-secondary">Cetak Struk</a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end">{{ $orders->links() }}</div>
</div>

@endsection

