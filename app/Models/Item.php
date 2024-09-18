<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'is_done', 'checklist_id'];

    public function checklist(){return $this->belongsTo(Checklist::class);}
}