@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-3">
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
            @php
                $valueFormBefore = Session::get('valueFormBefore');
            @endphp
        @endif
        <form action="{{ route('kasir.create.proses') }}" class="card m-auto p-5" method="POST">
            @csrf

            {{-- Validasi error message --}}
            @if ($errors->any())
                <ul class="alert alert-danger p-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <p>Penanggung Jawab: <b>{{ Auth::user()->name }}</b></p>

            <div class="mb-3 row">
                <label for="name_customer" class="col-sm-2 col-form-label">Nama Pembeli</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name_customer" name="name_customer"
                        value="{{ isset($valueFormBefore['name_customer']) ? $valueFormBefore['name_customer'] : '' }}">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="medicines" class="col-sm-2 col-form-label">Obat</label>
                <div class="col-sm-10">
                    @if (isset($valueFormBefore))
                        @foreach ($valueFormBefore['medicines'] as $key => $medicine)
                            <div class="d-flex">
                            <select name="medicines[]" id="medicines-{{ $key }}" class="form-select mt-2">
                                <option selected hidden disabled>Pesanan 1</option>
                                @foreach ($medicines as $item)
                                    <option class="my-2" value="{{ $item['id'] }}"
                                        {{ $medicine == $item['id'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                            @if ($key > 0)
                            <div>
                            <span style="cursor: pointer; color: #0d6efd; font-weight: bold" id="delete-${no}" class="mt-2 mx-2 cursor-pointer" onclick="deleteSelect('medicines-{{$key}}')">X</span>
                            </div>
                            @endif
                            </div>
                        @endforeach
                    @else
                        <!-- Medicines as array -->
                        <div class="d-flex" id="medicines-1">
                            <select name="medicines[]" id="medicines-1" class="form-select">
                                <option selected hidden disabled>Pesanan 1</option>
                                @foreach ($medicines as $item)
                                    <option class="my-2" value="{{ $item['id'] }}">{{ $item['name'] }}  ({{ $item['stock'] }})</option>

                                @endforeach
                            </select>
                        <div>
                        </div>
                        </div>
                    @endif

                    <!-- Wrapper for additional select options -->
                    <div id="wrap-medicines"></div>
                    <br>
                    <p style="cursor: pointer; color: #0d6efd; font-weight: bold" id="add-select">+ Tambah Obat</p>
                </div>
            </div>

            <button type="submit" class="btn btn-block btn-lg btn-primary">Konfirmasi Pembelian</button>
        </form>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            let no =
            {{ isset($valueFormBefore) ? count($valueFormBefore['medicines']) + 1 : 2 }}; // Inisialisasi nomor pesanan untuk opsi tambahan

            // Ketika tombol tambah obat diklik
            $("#add-select").on("click", function() {
                // HTML elemen select tambahan
                let el = `<div id="medicines-${no}" class="d-flex mb-2">
                    <select name="medicines[]" class="form-select mt-2">
                      <option selected hidden disabled>Pesanan ${no}</option>
                      @foreach ($medicines as $item)
                          <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                      @endforeach
                  </select>
                  <span style="cursor: pointer; color: #0d6efd; font-weight: bold" id="delete-${no}" class="mt-2 mx-2 cursor-pointer" onclick="deleteSelect('medicines-${no}')">X</span>
                    </div>`;

                // Tambahkan elemen baru ke dalam wrap-medicines
                $("#wrap-medicines").append(el);

                // Tambah nilai nomor pesanan
                no++;
            });

            function deleteSelect(elementId) {
                $(`#${elementId}`).remove();
                no--;
            }
        </script>
    @endpush

@endsection