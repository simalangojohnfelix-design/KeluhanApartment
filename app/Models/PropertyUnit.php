<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyUnit extends Model
{
    use HasFactory;

    protected $guarded = []; // atau $fillable yang sudah Anda atur sebelumnya

    // Tambahkan relasi ini
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Biarkan relasi lain yang sudah ada (misalnya: complaints atau assets)
}