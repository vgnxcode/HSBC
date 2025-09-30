<?php

namespace vgn;

use Illuminate\Database\Eloquent\Model;

class whatsapp_scheduler extends Model
{
        protected $table = 'whatsapp_scheduler';
    protected $guarded = ['id'];
    public $timestamps = false; 
}
