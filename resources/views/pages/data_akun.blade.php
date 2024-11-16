@extends('templates.app')

@section('content-dinamis')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <form class="d-flex me-3 mb-0" action="{{ route('kelola_akun.akun') }}" method="GET">
                <input type="text" name="cari" placeholder="Cari Nama akun ..." class="form-control me-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form> 
        <a href="{{ route('kelola_akun.tambah')}}" class="btn btn-success" >+ Tambah pengguna</a>
    </div>
    
    @if(Session::get('success'))
    <div class="alert alert-success">
        {{ Session::get('success')}}
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <table class="table table-stripped table-bordered mt-3 text-center">
            <thead>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </thead>
            <tbody>

            <tr>

            @foreach ($user as $index => $bagian)
            {{-- "Nomor urut = (Nomor halaman saat ini - 1) x Jumlah data per halaman + (Indeks data + 1)" --}}
            {{-- Nomor urut = (2 - 1) x 10 + (5 + 1) = 1 x 10 + 6 = 16 --}}
                <td>{{ ($user->currentPage()-1) * ($user->perpage()) + ($index+1) }}</td>
                <td>{{$bagian['name']}}</td>
                <td>{{$bagian['email']}}</td>
                <td>{{$bagian['role']}}</td>
                <td class="d-flex justify-content-center">
                    <a href="{{ route('kelola_akun.ubah',$bagian['id'])}}" class="btn btn-primary me-2">Edit</a>
                    <button  onclick="showModalDelete('{{ $bagian->id}}','{{$bagian->name}}')" class="btn btn-danger">Hapus</button>
                </td>
            </tr>

            @endforeach
            </tbody>
        </table>

            <div class="d-flex justify-content-end my-3">
                {{ $user->links() }}
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <form action="" class="modal-content" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">HAPUS DATA</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      apakah anda yakin menghapus data?? <b id="nama"></b>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                  </form>
                </div>
              </div>
            
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>

<script>
    function showModalDelete(id, name) {
        // masukan test dari parameter ke html bagian id="nama_obat"
        $("#nama").text(name);
        let url = "{{ route('kelola_akun.hapus', ':id')}}";
        url = url.replace(':id', id);
        $('form').attr('action', url);  
        $("#exampleModal").modal('show');
    }
    </script>

@endpush