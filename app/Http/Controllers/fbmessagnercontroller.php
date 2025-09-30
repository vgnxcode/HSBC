<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class fbmessagnercontroller extends Controller
{
    public function verify_token()
    {
        $access_token = "EAAHgoEjQmLMBOwJdXPUUH5ki3aeq0FKqZCQWjWrZCLM8gbuk7ZAbvEuVxBZCwvm80ZAKYZAwUTi6UFFZCbYrXeaTR78FRafqwKugTZCzlFZCq0cmNohkVHuJAAwGCXo2Wi0sZCbkNkxMScMpfEpN6Id1DgSmDac55k5DGruyfNHcb0OQUAQ6ZCAwtOb903nJEz14THRHBguC0LZB4ZCAYp9G1O2b4wRn1ZAW0ZD";
        $verify_token = "fb_vgn_bot";
        $hub_verify_token = null;

        if(isset($_REQUEST['hub_challenge'])) {
            $challenge = $_REQUEST['hub_challenge'];
            $hub_verify_token = $_REQUEST['hub_verify_token'];
        }


        if ($hub_verify_token === $verify_token) {
            echo $challenge;
        }


    }


    public function postedfromfb()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $sender = $input['entry'][0]['messaging'][0]['sender']['id'];
        $message = $input['entry'][0]['messaging'][0]['message']['text'];
        Log::info('Facebook posted sender:'.$sender);
        Log::info('Facebook posted message:'.$message);
        Log::info('Facebook posted dumo:'.json_encode($input));
    }
}
