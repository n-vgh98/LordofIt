<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // polymorphic relation to image table
    public function image()
    {
        return $this->morphOne("App\Models\Image", "imageable");
    }

    // polymorphic relation to lang table
    public function language()
    {
        return $this->morphOne("App\Models\Lang", "langable");
    }

    public function comments()
    {
        return $this->morphMany("App\Models\Comment", "commentable");
    }
}
