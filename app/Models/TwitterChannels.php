<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwitterChannels extends Model
{
    protected $table = 'twitter_channels';
    protected $fillable = ['creator_id','profile_url', 'followers'];
}
