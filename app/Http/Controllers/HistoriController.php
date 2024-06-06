<?php

namespace App\Http\Controllers;

use App\Models\Histori;
use App\Models\User;
use Illuminate\Http\Request;

class HistoriController extends Controller
{
    public function data(){
        $data = Histori::all();

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data Histori', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil data Histori', 'data' => NULL]);
        }
    }

    public function detail($id){
        $data = Histori::find($id);

        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil detail Histori', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil detail Histori', 'data' => NULL]);
        }
    }

    public function inventaris($inventaris_id){
        $data = array();
        $result = Histori::where("inventaris_id", $inventaris_id)->get();
        foreach($result as $res){
            if($res->status == "in"){
                $findUser = User::whereHas('penambahans', function($q, $res){
                    $q->where('kode', '=', $res->kode);
                })->first();
            }
            else{
                $findUser = User::whereHas('permintaans', function($q, $res){
                    $q->where('kode', '=', $res->kode);
                })->first();
            }
            
            $temp_array = array(
                'id' => $res->id,
                'tanggal' => $res->tanggal,
                'kode' => $res->kode,
                'status' => $res->status == "in" ? "Masuk" : "Keluar",
                'user' => $findUser->nama,
                'jumlah ' => $res->jumlah
            );
            array_push($data, $temp_array);          
        }
        if($data){
            return response()->json(['status' => 'success', 'message' => 'Berhasil mengambil data Histori Inventaris', 'data' => $data]);
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal mengambil data Histori Inventaris', 'data' => NULL]);
        }
    }

    public function store($inventaris_id, $kode, $tanggal, $jumlah, $status){
        $create = Histori::create([
            'inventaris_id' => $inventaris_id,
            'tanggal' => $tanggal,
            'jumlah' => $jumlah,
            'kode_ref' => $kode,
            'jenis' => $status,
        ]);

        if($create){
            app()->call('App\Http\Controllers\InventarisController@update_quantity',[
                'jumlah'=> $jumlah,
                'inventaris_id'=> $inventaris_id,
                'status' => $status
            ]);
            // if($update_inventaris){
            //     return response()->json(['status' => 'success', 'message' => 'Berhasil menambah data Histori']);
            // }
            // else{
            //     return response()->json(['status' => 'error', 'message' => 'Gagal menambah data Histori']);
            // }
        }
        else{
            return response()->json(['status' => 'error', 'message' => 'Gagal menambah data Histori']);
        }
    }
}
