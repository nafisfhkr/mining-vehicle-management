<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
   
    protected $guarded = []; 

    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function driver() { return $this->belongsTo(Driver::class); }
    public function creator() { return $this->belongsTo(User::class, 'user_id'); }
    public function approver1() { return $this->belongsTo(User::class, 'approver_1_id'); }
    public function approver2() { return $this->belongsTo(User::class, 'approver_2_id'); }
}