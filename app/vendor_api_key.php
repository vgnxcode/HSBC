<?php

namespace vgn;

use Illuminate\Database\Eloquent\Model;

class vendor_api_key extends Model
{
       protected $table = 'vendor_api_keys'; 

    protected $guarded = ['id'];
}
