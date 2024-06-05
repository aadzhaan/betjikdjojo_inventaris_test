<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;
    
    protected $table = 'status';
    protected $fillable = ['nama'];

    public function penambahans(): HasMany {
        return $this->hasMany(Penambahan::class);
    }

    public function permintaans(): HasMany{
        return $this->hasMany(Permintaan::class);
    }
}
