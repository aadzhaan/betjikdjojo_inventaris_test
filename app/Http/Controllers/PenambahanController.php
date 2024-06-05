<?php

namespace App\Http\Controllers;

use App\Models\Penambahan;
use Illuminate\Http\Request;

class PenambahanController extends Controller
{
    public function data(){

        $data = Penambahan::all();

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data Penambahan', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil data Penambahan', 'data' => NULL]);
        }
    }

    public function detail($id){

        $data = Penambahan::find($id);

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil detail Penambahan', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil detail Penambahan', 'data' => NULL]);
        }
    }

    public function store(Request $request){
        $request->validate([
            'user_id' => ['required'],
            'inventaris_id' => ['required'],
            'tanggal' => ['required'],
            'kode' => ['required', 'unique:penambahan,kode'],
            'jumlah' => ['required'],
        ]);

        $create = Penambahan::create([
            'user_id' => $request->user_id,
            'inventaris_id' => $request->inventaris_id,
            'status_id' => 1,
            'tanggal' => $request->tanggal,
            'kode' => $request->kode,
            'jumlah' => $request->jumlah,
        ]);

        if($create){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Penambahan']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menambahkan Penambahan']);
        }
    }

    public function update(Request $request){
        $request->validate([
            'user_id' => ['required'],
            'inventaris_id' => ['required'],
            'tanggal' => ['required'],
            'kode' => ['required', 'unique:penambahan,kode,'.$request->id],
            'jumlah' => ['required'],
        ]);
        $update = Penambahan::find($request->id);
        $update->user_id = $request->user_id;
        $update->inventaris_id = $request->inventaris_id;
        $update->kode = $request->kode;
        $update->tanggal = $request->tanggal;
        $update->jumlah = $request->jumlah;
        $result = $update->save();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah Penambahan']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengubah Penambahan']);
        }
    }

    public function delete($id){

        $usedPenambahan = Penambahan::whereIn('status_id', [2,3])->get();

        if(count($usedPenambahan) > 0){
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Penambahan, Data telah digunakan']);
        }
        
        $delete = Penambahan::find($id);
        $result = $delete->delete();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus Penambahan']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Penambahan']);
        }
    }

    public function change_status(Request $request){
        $update = Penambahan::find($request->id);
        $update->status_id = $request->status_id;
        $result = $update->save();
        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah Status Penambahan']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengubah Status Penambahan']);
        }
    }
}
