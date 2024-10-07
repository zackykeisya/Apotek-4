@extends('templates.app')
{{-- extends : mengimport/memanggil file view (biasanya untuk template nya, isi dr template merupakan content tetap/content yg selalu ada di setiap halaman) --}}

{{-- section : mengisi element html ke yield dengan nama yg sama ke file templatenya --}}
@section('content')
    <h1 class="mt-5">INI HALAMAN LANDING PAGE.</h1>
@endsection