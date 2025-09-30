<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;


class IVRSController extends Controller
{
     public function postfeedback(Request $request)
    {
        /* $validate = $this->validate($request, [
            'leaddate1' => 'required|date|date_format:Y-m-d|after:2017-09-30',
            'leaddate2' => 'required|date|date_format:Y-m-d',
        ]);*/
         $leaddate1 = $_POST['leaddate1'];
         $leaddate2 = $_POST['leaddate2'];
         $key = $_POST['key'];
         
         
         
        
        
         if ($leaddate1 == $leaddate2) {
        $getivrsfeedback = DB::connection('mysql3')->table('feedbacktoivrs')->where('created_datetime','LIKE','%'.$leaddate1.'%')->get();        
         }
         else{
        $getivrsfeedback = DB::connection('mysql3')->table('feedbacktoivrs')->where('created_datetime','>=',$leaddate1)->Where('created_datetime','<=',$leaddate2)->orderBy('created_datetime','desc')->get();
    }
    
         
        if (count($getivrsfeedback) > 0) {
            
            $res = ['ivrsfeedback'=> $getivrsfeedback, 'date1' => $leaddate1,'date2' => $leaddate2 ];
            return json_encode($res);
        }
        else{
            
            return json_encode([]);
        }

    }

}
