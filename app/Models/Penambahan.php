<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penambahan extends Model
{
    use HasFactory;
    protected $table = 'penambahan';
    protected $fillable = ['inventaris_id', 'user_id', 'status_id', 'tanggal', 'kode', 'jumlah'];

    public function inventaris(){
        return $this->belongsTo(Inventaris::class, 'inventaris_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
