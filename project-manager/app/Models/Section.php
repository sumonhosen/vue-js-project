<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    public function DevASectionItems(){
        return $this->hasMany(SectionItem::class)->where('parent_id', null)->where('dev_2', 0);
    }

    public function SectionItems(){
        return $this->hasMany(SectionItem::class)->where('parent_id', null);
    }

    public function DevItems(){
        return $this->hasMany(DevItem::class);
    }

    public function Project(){
        return $this->belongsTo(Project::class);
    }
}
