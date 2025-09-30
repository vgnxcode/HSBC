<?php

namespace vgn;

use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    protected $table = 'newsroom';
    protected $guarded = ['id'];
}
