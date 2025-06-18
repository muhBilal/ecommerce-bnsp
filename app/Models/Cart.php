<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
      protected $fillable = ['user_id', 'device_id', 'quantity'];

    // public function device()
    // {
    //     return $this->belongsTo(MedicalDevice::class, 'device_id');
    // }
}
