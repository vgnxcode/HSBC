<?php

namespace vgn;

use Illuminate\Database\Eloquent\Model;

class KaleyraSmsLogs extends Model
{
      protected $table = 'kaleyra_sms_logs';
	protected $guarded = ['id'];
      public $timestamps = true; 
}