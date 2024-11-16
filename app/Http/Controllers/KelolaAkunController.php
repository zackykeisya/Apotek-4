<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


use Illuminate\Http\Request;

class KelolaAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginProses(Request $request) {
        $request->validate([
            'email' =>'required|email:dns',
            'password' =>'required',
        ]);

         //ambil data dari input satukan dalam array
         $user = $request->only(['email', 'password']);
         //cek kecocokan email password lalu simpan pada clas auth
         if (Auth::attempt($user)) {
            return redirect()->route('landing_page');
         } else {
            return redirect()->back()->with('failed', 'gagal login silahkan coba lagi');
         }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda telah logout');
    }

    public function index(Request $request)
    {
        //
        $user = User::where('name', 'LIKE', '%'.$request->cari.'%')->simplePaginate(5)->appends($request->all());
        return view('pages.data_akun', compact('user')); 
        //Mengembalikan view pages.data_akun dengan data user yang ditemukan dan dipaginate.
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('kelola.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'password' => 'required'
        ], [
            'name.required' => 'Nama harus di isi!',
            'name.max' => 'Nama obat maksimal 100 karakter',
            'email.required' => 'email akun harus di isi',
            'role.required' => 'Bagian harus di isi',
            'password' => bcrypt($request->password),
        ]);

        User::create($request->all());


        return redirect()->route('kelola_akun.akun')->with('success', 'Berhasil Menambah Data Obat!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
            $user = User::find($id);
            return view('kelola.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required',
            'role' => 'required',
            'password' => 'nullable',
        ]);

        $user= User::find($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ?? $user->password
        ]);

        return redirect()->route('kelola_akun.akun')->with('success', 'Berhasil Menambah Data Obat!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        User::where('id',$id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
