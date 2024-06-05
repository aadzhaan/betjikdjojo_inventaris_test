<?php

namespace App\Http\Controllers;

use App\Models\Penambahan;
use App\Models\Permintaan;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request){
        try {
            $request->validate([
                'email' => ['required'],
                'password' => ['required']
            ]);

            $credentials = request(['email', 'password']);

            // if(!Auth::attempt($credentials)){
            //     return response()->json(['status' => 'error', 'message' => 'Unauthorized', 'data' => $request]);
            // }
            
            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password)){
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json(['status' => 'success',
                'access_token' => $tokenResult, 
                'token_type' => 'Bearer', 
                'user' => $user],
                'Authenticated');
        } catch (Exception $error) {
            return response()->json(['status' => 'error',
                    'message' => 'Something went wrong',
                    'error' => $error
            ]);
        }
    }

    public function data(){

        $data = User::all();

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data User', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil data User', 'data' => NULL]);
        }
    }

    public function detail($id){

        $data = User::find($id);

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil detail User', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil detail User', 'data' => NULL]);
        }
    }

    public function store(Request $request){
        $request->validate([
            'divisi_id' => ['required'],
            'email' => ['required', 'string', 'unique:user,email'],
            'nama' => ['required', 'string'],
            'konfirmasi_password' => ['required', 'min:8'],
            'password' => ['required', 'min:8'],
        ]);

        if($request->password === $request->konfirmasi_password){
            $create = User::create([
                'divisi_id' => $request->divisi_id,
                'email' => $request->email,
                'nama' => $request->nama,
                'password' => Hash::make($request->jumlah),
            ]);

            if($create){
                return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan User']);
            }
            else{
                return response()->json(['status' => 'error', 'message' => 'Gagal menambahkan User']);
            }
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Password']);
        }
    }

    public function update(Request $request){
        $request->validate([
            'divisi_id' => ['required'],
            'email' => ['required', 'unique:user,email,'.$request->id],
            'nama' => ['required']
        ]);

        $update = User::find($request->id);
        $update->divisi_id = $request->divisi_id;
        $update->email = $request->email;
        $update->nama = $request->nama;
        $result = $update->save();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah User']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengubah User']);
        }
    }

    public function delete($id){

        $usedUserinPenambahan = Penambahan::where('user_id', $id)->get();
        $usedUserinPermintaan = Permintaan::where('user_id', $id)->get();

        if(count($usedUserinPenambahan) > 0 || count($usedUserinPermintaan) > 0){
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus User, Data telah digunakan']);
        }
        
        $delete = User::find($id);
        $result = $delete->delete();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus User']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus User']);
        }
    }
}
