<?php

namespace App\Http\Controllers;

use App\Models\Penambahan;
use App\Models\Permintaan;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function data(){

        $data = Status::all();

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data Status', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil data Status', 'data' => NULL]);
        }
    }

    public function store(Request $request){
        $request->validate([
            'nama' => ['required']
        ]);

        $create = Status::create([
            'nama' => $request->nama
        ]);

        if($create){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Status']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menambahkan Status']);
        }
    }

    public function update(Request $request){
        $request->validate([
            'nama' => ['required']
        ]);

        $update = Status::find($request->id);
        $update->nama = $request->nama;
        $result = $update->save();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah Status']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengubah Status']);
        }
    }

    public function delete($id){

        $usedStatusinPenambahan = Penambahan::where('status_id', $id)->get();
        $usedStatusinPermintaan = Permintaan::where('status_id', $id)->get();

        if(count($usedStatusinPenambahan) > 0 || count($usedStatusinPermintaan) > 0){
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Status, Data telah digunakan']);
        }
        
        $delete = Status::find($id);
        $result = $delete->delete();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus Status']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Status']);
        }
    }
}
