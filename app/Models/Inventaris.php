<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';
    protected $fillable = ['kategori_barang_id', 'kode', 'nama', 'jumlah'];

    public function kategori_barang(){
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    public function penambahans(): HasMany {
        return $this->hasMany(Penambahan::class);
    }

    public function permintaans(): HasMany{
        return $this->hasMany(Permintaan::class);
    }

    public function historis(): HasMany{
        return $this->hasMany(Histori::class);
    }
}
