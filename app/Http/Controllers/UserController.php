<?php

namespace App\Http\Controllers;

use App\Models\DetailSales;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function loginpage()
    {
        return view('welcome');
    }

        public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'silahkan isi email',
            'password.required' => 'silahkan isi password',
        ]);

        $cekLogin = [
            'email' => $request->email,
            'password'=>$request->password,
        ];

        if(Auth::attempt($cekLogin)){
            $role = Auth::user();
            if ($role->role == 'admin') {
                return redirect()->route('dashboard');
            }
            if ($role->role == 'employee') {
                return redirect()->route('dashboard');
            }
        }else {
            return redirect()->back()->withErrors(['login_failed' => 'Proses login gagal, silakan coba lagi dengan data yang benar!'])->withInput();
        };
    }

    public function index()
    {
        $users = User::all();
        return view('users', compact('users'));
    }

    public function create()
    {
        return view('add-employee');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required'
        ]);

        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->withErrors(['email' => 'Email sudah digunakan.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);
    
        return redirect()->route('users')->with('success', 'Berhasil Menambah User');
    }
    
    public function edit($id)
    {
            $user = User::findOrFail($id);
            return view('edit-employee', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);
    
        $user = User::findOrFail($id);
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];
    
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
    
        $user->update($data);

        // dd($user);
        return redirect()->route('users')->with('success', 'User berhasil diperbarui!');
    }


    public function destroy(User $User, $id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('users')->with('success', 'Berhasil Hapus User');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda telah berhasil logout!');
    }
}

