<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatorPlatform extends Model
{
    use HasFactory;

    protected $table = 'creator_platforms';

    protected $fillable = [
        'creator_id',
        'platforms_ids',
    ];
    
}

