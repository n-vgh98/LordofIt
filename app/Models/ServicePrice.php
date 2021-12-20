<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    use HasFactory;

    public function subcategory()
    {
        return $this->belongsTo("App\Models\ServicePriceCategory", "category_id");
    }
}
