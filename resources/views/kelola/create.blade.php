@extends('templates.app')


@section('content-dinamis')
{{-- <div class="container">
    <h1>Create</h1>
</div> --}}

    <form action="{{ route('kelola_akun.tambah.proses')}}" class="card p-5" method="POST">
        @csrf
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama : </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Role :   </label>
            <div class="col-sm-10">
                <select class="form-select" name="role" id="role">
                    <option selected disabled hidden>Pilih</option>
                    <option value="admin" {{old('role')== "admin" ? 'selected' : '' }}>Atmin</option>
                    <option value="kasir" {{old('role')== "kasir" ? 'selected' : '' }}>Kacir</option>
                </select>
            </div>
        </div> 
        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Email : </label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email')}}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Password :</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Kirim</button>
    </form>
@endsection
