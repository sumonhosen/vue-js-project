<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class SectionItem extends Model
{
    use HasFactory;

    public function SectionItems(){
        return $this->hasMany(SectionItem::class, 'parent_id');
    }

    public function SectionItem(){
        return $this->belongsTo(SectionItem::class, 'parent_id');
    }

    public function Section(){
        return $this->belongsTo(Section::class);
    }

    public function getDevBRowClassAttribute(){
        if($this->deleted_at){
            return 'table-danger';
        }elseif($this->developer_2_status){
            return 'table-success';
        }elseif($this->dev_2){
            return 'table-warning';
        }
        return '';
    }

    public function getQCRowClassAttribute(){
        if($this->deleted_at){
            return 'table-danger';
        }elseif($this->qc_status){
            return 'table-success';
        }
        return 'table-warning';
    }

    public function getQARowClassAttribute(){
        if($this->qa_status){
            return 'table-success';
        }
        return 'table-warning';
    }

    public function getDevBStatusStringAttribute(){
        if($this->deleted_at){
            return '(Deleted)';
        }elseif($this->dev_2){
            return '(New)';
        }
        return '';
    }
}
