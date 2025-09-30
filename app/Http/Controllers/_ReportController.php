<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use vgn\lead_data;
class ReportController extends Controller
{
    public function show() {

        //$newdate = $date;
        
        $data = array();
        $check = 0;
        return view('report.index')->with(['data'=>$data, 'check'=>$check]);
    }

    public function postlead(Request $request) {
        $leaddate = $request->leaddate;
        $today = date('Y-m-d');
        $validate = $this->validate($request, [
            'leaddate' => 'required|date|date_format:Y-m-d|before_or_equal:'.$today
			]);

            $data = lead_data::where('lead_datetime','LIKE','%'.$leaddate.'%')->get();
            $check = 1;
            
        return view('report.index')->with(['data'=>$data, 'check'=>$check, 'leaddate' => $leaddate]);
    }
}
