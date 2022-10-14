<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded =['id'];
    protected $with = ['creator'];

    public function creator()
    {
        return $this->belongsTo(Creator::class, 'creator_id');
    }
}
