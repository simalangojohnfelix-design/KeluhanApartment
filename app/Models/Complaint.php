<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['tenant_id', 'property_unit_id', 'asset_id', 'title', 'description', 'photo', 'status', 'category', 'urgency', 'rating', 'review', 'is_confirmed'];

    public function tenant() {
        return $this->belongsTo(User::class, 'tenant_id');
    }
    
    public function propertyUnit() {
        return $this->belongsTo(PropertyUnit::class);
    }
    
    public function asset() {
        return $this->belongsTo(Asset::class);
    }
    
    public function workOrder() {
        return $this->hasOne(WorkOrder::class);
    }
}
