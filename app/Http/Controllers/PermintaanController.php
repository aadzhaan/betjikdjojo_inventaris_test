<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Permintaan;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    public function data(){

        $data = Permintaan::all();

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data Permintaan', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil data Permintaan', 'data' => NULL]);
        }
    }

    public function detail($id){

        $data = Permintaan::find($id);

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil detail Permintaan', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil detail Permintaan', 'data' => NULL]);
        }
    }

    public function store(Request $request){
        $request->validate([
            'user_id' => ['required'],
            'inventaris_id' => ['required'],
            'tanggal' => ['required'],
            'kode' => ['required', 'unique:Permintaan,kode'],
            'jumlah' => ['required'],
        ]);

        $create = Permintaan::create([
            'user_id' => $request->user_id,
            'inventaris_id' => $request->inventaris_id,
            'status_id' => 1,
            'tanggal' => $request->tanggal,
            'kode' => $request->kode,
            'jumlah' => $request->jumlah,
        ]);

        if($create){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Permintaan']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menambahkan Permintaan']);
        }
    }

    public function update(Request $request){
        $request->validate([
            'user_id' => ['required'],
            'inventaris_id' => ['required'],
            'tanggal' => ['required'],
            'kode' => ['required', 'unique:Permintaan,kode,'.$request->id],
            'jumlah' => ['required'],
        ]);
        $update = Permintaan::find($request->id);
        $update->user_id = $request->user_id;
        $update->inventaris_id = $request->inventaris_id;
        $update->kode = $request->kode;
        $update->tanggal = $request->tanggal;
        $update->jumlah = $request->jumlah;
        $result = $update->save();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah Permintaan']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengubah Permintaan']);
        }
    }

    public function delete($id){

        $usedPermintaan = Permintaan::whereIn('status_id', [2,3])->get();

        if(count($usedPermintaan) > 0){
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Permintaan, Data telah digunakan']);
        }
        
        $delete = Permintaan::find($id);
        $result = $delete->delete();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus Permintaan']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Permintaan']);
        }
    }

    public function change_status(Request $request){
        $update = Permintaan::find($request->id);
        $update->status_id = $request->status_id;
        $result = $update->save();
        if($result){
            if($request->status_id == "2"){
                app()->call('App\Http\Controllers\HistoriController@store',[
                    'jumlah' => $update->jumlah,
                    'inventaris_id' => $update->inventaris_id,
                    'kode' => $update->kode,
                    'tanggal' => $update->tanggal,
                    'status' => "out"
                ]);
            }
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah Status Permintaan']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengubah Status Permintaan']);
        }
    }

}
