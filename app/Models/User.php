<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'phone'];
    protected $hidden = ['password', 'remember_token'];

    public function propertyUnit() {
        return $this->hasOne(PropertyUnit::class, 'user_id');
    }
    
    public function complaints() {
        return $this->hasMany(Complaint::class, 'tenant_id');
    }
    
    public function workOrders() {
        return $this->hasMany(WorkOrder::class, 'technician_id');
    }
    
    public function approvals() {
        return $this->hasMany(RepairApproval::class, 'owner_id');
    }
}
