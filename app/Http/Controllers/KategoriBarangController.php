<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    public function data(){

        $data = KategoriBarang::all();

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data Kategori', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil data Kategori', 'data' => NULL]);
        }
    }

    public function store(Request $request){
        $request->validate([
            'nama' => ['required'],
            'kode' => ['required', 'unique:kategori_barang,kode']
        ]);

        $create = KategoriBarang::create([
            'nama' => $request->nama,
            'kode' => $request->kode
        ]);

        if($create){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menambahkan Kategori']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menambahkan Kategori']);
        }
    }

    public function update(Request $request){
        $request->validate([
            'nama' => ['required'],
            'kode' => ['required', 'unique:kategori_barang,kode,'.$request->id]
        ]);

        $update = KategoriBarang::find($request->id);
        $update->nama = $request->nama;
        $update->kode = $request->kode;
        $result = $update->save();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengubah Kategori']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengubah Kategori']);
        }
    }

    public function delete($id){

        $usedKategori = Inventaris::where('kategori_barang_id', $id)->get();

        if(count($usedKategori) > 0){
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Kategori, Data telah digunakan', 'data' => $usedKategori]);
        }
        
        $delete = KategoriBarang::find($id);
        $result = $delete->delete();

        if($result){
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus Kategori']);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus Kategori']);
        }
    }
}
