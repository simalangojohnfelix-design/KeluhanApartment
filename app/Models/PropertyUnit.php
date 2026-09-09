<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyUnit extends Model
{
    protected $fillable = ['unit_number', 'type', 'floor', 'status', 'user_id', 'lease_start', 'lease_end'];

    public function tenant() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function assets() {
        return $this->hasMany(Asset::class);
    }
    
    public function complaints() {
        return $this->hasMany(Complaint::class);
    }
}
