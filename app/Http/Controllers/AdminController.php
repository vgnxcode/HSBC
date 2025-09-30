<?php

namespace vgn\Http\Controllers;

use App\Models\User;
use App\Models\UserThrottle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use vgn\AdminCrm;
use Illuminate\Support\Facades\Hash;
use vgn\Http\Traits\ameyotrait;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    use ameyotrait;   

//login from core php (calling 945)
public function login_from_calling945(Request $request)
    {
        $user_id = $request->input('user_id');
        $user_password = $request->input('user_password');

        $adminCrm = AdminCrm::where('email', $user_id)->first();

        if (!$adminCrm) {
            return response()->json(['status' => false, 'message' => 'User not found'], 404);
        }

        if (!Hash::check($user_password, $adminCrm->password)) {
            return response()->json(['status' => false, 'message' => 'Incorrect password'], 401);
        }   
        

        return response()->json([
            [
                "transfer" => [
                    "type" => "employee_details",
                    "data" => collect($adminCrm->toArray())->except(['password'])
                ]
            ]
        ]);
    }

    //add api dailplan config into db

    public function apidailplanconfigintodb(Request $request)
    {
        $json = $request->getContent(); 
        $data = json_decode($json, true); 


        Log::info("apidailplanconfigintodb", ['result' => $data]);

        if (!$data['user_name'] || empty($data['user_name']) || $data['caller_id'] === '') {
            return response()->json([
                'status' => 'error',
                'message' => 'Please Check the Input Details',
                'data' => null
            ], 404);
        }
        

        $adminCrm = new AdminCrm();
        $adminCrm->username = $data['user_name']; 
        $adminCrm->password = Hash::make($data['password']); 
        $adminCrm->agent_number = $data['agent_number'];
        $adminCrm->caller_id = $data['caller_id'];
        $adminCrm->tata_username = $data['tata_username'] ?? null; 
        $adminCrm->tata_password = $data['tata_password'] ?? null;
        $adminCrm->name = $data['name'];
        $adminCrm->position = $data['position'];
        $adminCrm->department = $data['department'];
        $adminCrm->email = $data['email'];
        $adminCrm->remember_token = ''; // 
        $adminCrm->created_at = now();
        $adminCrm->updated_at = now();
        $adminCrm->save();
        Log::info("apidailplanconfigintodb_adminCrm", ['result' => $adminCrm]);
    
        return response()->json([
            'status' => 'success',
            'message' => ' data Stored successfully',
            'data' => $adminCrm
        ], 200);

       
        
    }

    //list dail plna config
    public function listdailplanconfig(Request $request)
{
    $adminCrm = AdminCrm::all(); // Fetch all records

    // Check if the collection is empty
    if ($adminCrm->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Data not found in the database',
            'data' => null
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Data retrieved successfully',
        'data' => $adminCrm
    ], 200);
}


//update the config datas
public function apidailplanupdateconfigintodb(Request $request)
{
    $json = $request->getContent(); 
        $data = json_decode($json, true); 


        Log::info("apidailplanupdateconfigintodb", ['result' => $data]);

        if (!$data['user_name'] || empty($data['user_name']) || $data['caller_id'] === '') {
            return response()->json([
                'status' => 'error',
                'message' => 'Please Check the Input Details',
                'data' => null
            ], 404);
        }


        $adminCrm = AdminCrm::where('id', $data['pid'])->first(); // Find the record

        if ($adminCrm)
        { 
            $adminCrm->username = $data['user_name'];   
            $adminCrm->password = Hash::make($data['password']);           
            $adminCrm->agent_number = $data['agent_number'];
            $adminCrm->caller_id = $data['caller_id'];
            $adminCrm->tata_username = $data['tata_username'] ?? null;
            $adminCrm->tata_password = $data['tata_password'] ?? null;
            $adminCrm->name = $data['name'];
            $adminCrm->position = $data['position'];
            $adminCrm->department = $data['department'];
            $adminCrm->email = $data['email'];
            $adminCrm->remember_token = ''; 
            $adminCrm->updated_at = now();
            $adminCrm->save(); 

            return response()->json([
                'status' => 'success',
                'message' => ' data Updated successfully',
                'data' => $adminCrm
            ], 200);
    
        } 
        else 
        {
            return response()->json([
                'status' => 'error',
                'message' => ' data not found',
                'data' => $adminCrm
            ], 400);
        }


}



}