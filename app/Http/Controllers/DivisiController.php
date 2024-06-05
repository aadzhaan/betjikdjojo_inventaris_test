<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function data(){

        $data = Divisi::all();

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data Divisi', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil data Divisi', 'data' => NULL]);
        }
    }

    public function store(Request $request){
        $request->validate([
            'nama' => ['required']
        ]);

        $create = Divisi::create([
            'nama' => $request->nama
        ]);

        if($create){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Divisi']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menambahkan Divisi']);
        }
    }

    public function update(Request $request){
        $request->validate([
            'nama' => ['required']
        ]);

        $update = Divisi::find($request->id);
        $update->nama = $request->nama;
        $result = $update->save();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah Divisi']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengubah Divisi']);
        }
    }

    public function delete($id){

        $usedDivisi = User::where('divisi_id', $id)->get();

        if(count($usedDivisi) > 0){
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Divisi, Data telah digunakan', 'data' => $usedDivisi]);
        }
        
        $delete = Divisi::find($id);
        $result = $delete->delete();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus Divisi']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Divisi']);
        }
    }


}
