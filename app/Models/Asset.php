<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ['property_unit_id', 'name', 'description', 'purchase_date', 'status', 'condition', 'category', 'maintenance_date'];

    public function propertyUnit() {
        return $this->belongsTo(PropertyUnit::class);
    }
    
    public function complaints() {
        return $this->hasMany(Complaint::class);
    }
}
