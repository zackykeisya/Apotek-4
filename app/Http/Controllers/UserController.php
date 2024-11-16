<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function loginProses(Request $request) {
    //     $request->validate([
    //         'email' =>'required|email:dns',
    //         'password' =>'required',
    //     ]);

    //      //ambil data dari input satukan dalam array
    //      $user = $request->only(['email', 'password']);
    //      //cek kecocokan email password lalu simpan pada clas auth
    //      if (Auth::attempt($user)) {
    //         return redirect()->route('landing_page');
    //      } else {
    //         return redirect()->back()->with('failed', 'gagal login silahkan coba lagi');
    //      }
    // }


    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
