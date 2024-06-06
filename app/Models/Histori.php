<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Histori extends Model
{
    use HasFactory;
    protected $table = 'histori';
    protected $fillable = ['inventaris_id', 'tanggal', 'kode_ref', 'jumlah', 'jenis'];

    public function inventaris(){
        return $this->belongsTo(Inventaris::class, 'inventaris_id');
    }
}
