<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Penambahan;
use App\Models\Permintaan;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function data(){

        $data = Inventaris::all();

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data Inventaris', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil data Inventaris', 'data' => NULL]);
        }
    }

    public function detail($id){

        $data = Inventaris::find($id);

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil detail Inventaris', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil detail Inventaris', 'data' => NULL]);
        }
    }

    public function store(Request $request){
        $request->validate([
            'kategori_barang_id' => ['required'],
            'kode' => ['required', 'unique:inventaris,kode'],
            'nama' => ['required'],
            'jumlah' => ['required'],
        ]);

        $create = Inventaris::create([
            'kategori_barang_id' => $request->kategori_barang_id,
            'kode' => $request->kode,
            'nama' => $request->nama,
            'jumlah' => $request->jumlah,
        ]);

        if($create){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Inventaris']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menambahkan Inventaris']);
        }
    }

    public function update(Request $request){
        $request->validate([
            'kategori_barang_id' => ['required'],
            'kode' => ['required', 'unique:inventaris,kode,'.$request->id],
            'nama' => ['required'],
            'jumlah' => ['required'],
        ]);

        $create = Inventaris::create([
            'kategori_barang_id' => $request->kategori_barang_id,
            'kode' => $request->kode,
            'nama' => $request->nama,
            'jumlah' => $request->jumlah,
        ]);

        $update = Inventaris::find($request->id);
        $update->kategori_barang_id = $request->kategori_barang_id;
        $update->kode = $request->kode;
        $update->nama = $request->nama;
        $update->jumlah = $request->jumlah;
        $result = $update->save();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah Inventaris']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengubah Inventaris']);
        }
    }

    public function delete($id){

        $usedInventarisinPenambahan = Penambahan::where('status_id', $id)->get();
        $usedInventarisinPermintaan = Permintaan::where('status_id', $id)->get();

        if(count($usedInventarisinPenambahan) > 0 || count($usedInventarisinPermintaan) > 0){
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Inventaris, Data telah digunakan']);
        }
        
        $delete = Inventaris::find($id);
        $result = $delete->delete();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus Inventaris']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Inventaris']);
        }
    }
}
