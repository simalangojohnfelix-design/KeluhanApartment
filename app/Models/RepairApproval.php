<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairApproval extends Model
{
    protected $fillable = ['work_order_id', 'owner_id', 'status', 'comment'];

    public function workOrder() {
        return $this->belongsTo(WorkOrder::class);
    }
    
    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
