<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $fillable = ['complaint_id', 'technician_id', 'description', 'status', 'cost_estimate', 'start_date', 'end_date', 'action_details', 'spare_parts', 'photo_before', 'photo_after'];

    public function complaint() {
        return $this->belongsTo(Complaint::class);
    }
    
    public function technician() {
        return $this->belongsTo(User::class, 'technician_id');
    }
    
    public function approval() {
        return $this->hasOne(RepairApproval::class);
    }
}
