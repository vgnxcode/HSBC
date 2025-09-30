<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use DB;
use vgn\Http\Traits\customertrait;

class BulksmsemailController extends Controller
{
    use customertrait;

    public function loadbulksmstosend()
    {
        //newarray
        
         $smsdirectory = public_path()."/bulksmsupload";
                $sms_dir_exist = is_dir($smsdirectory);
                $smsfiles = array();
                if($sms_dir_exist === true) {
                
                
               $smsfiles = collect(File::allFiles($smsdirectory))
        ->sortBy(function ($file) {
            return $file->getRelativePathname();
        });
        //dd($smsfiles);

        if (!empty($smsfiles)) {
            
            foreach ($smsfiles as $key => $value) {
                
                if (!empty($value->getRelativePathname())) {
                    $filetoprocess = $smsdirectory.'/'.$value->getRelativePathname();
                    $data = File::get($filetoprocess);
                    dd($data);
                        
                }

            }
        }

        dd('ok');
    }

        $check = DB::connection('mysql3')->table('bulk_sms_email')->count();
        
        if ($check == 0) {
            $getbulksms_from_sap = $this->getbulksmstosend_sap();
        
        if ($getbulksms_from_sap != '') {
            $data = [];
            if (array_key_exists('0',$getbulksms_from_sap['Message_Details']) === false) {
                $data[0] = $getbulksms_from_sap['Message_Details'];
            }
            else{
                $data = $getbulksms_from_sap['Message_Details'];
            }

             foreach ($data as $key => $value) {
                
                if ($value['Init_Ind'] == 'X' ) { $value['Init_Ind'] = 1; }else{ $value['Init_Ind'] = 0; }
                if ($value['SMS_Ind'] == 'X' ) { $value['SMS_Ind'] = 0; }else{ $value['SMS_Ind'] = 1; }
                if ($value['Mail_Ind'] == 'X' ) { $value['Mail_Ind'] = 0; }else{ $value['Mail_Ind'] = 1; }
                if ($value['Scheduled_Time'] == '') { $value['Scheduled_Time'] = null; }
                 
                $insert = DB::connection('mysql3')->table('bulk_sms_email')
                ->insert([
                    'content_uniq_id' => $value['Content_Unique_ID'],
                    'mob_no' => $value['Mobile_Number'],
                    'msg_content' => $value['Message_Content'],
                    'init_indicator' => $value['Init_Ind'],
                    'frequency' => $value['Frequency'],
                    'sms_ind' => $value['SMS_Ind'],
                    'mail_ind' => $value['Mail_Ind'],
                    'sch_date' => $value['Scheduled_Date'],
                    'sch_time' => $value['Scheduled_Time'],
                    'sent_sms' => 0,
                    'sent_mail' => 0,
                    'processed' => 'N',
                    'processed_time' => Carbon::now()->toDateTimeString()

                ]);

             }

            dd('Processed');    
        }
        else{
            dd('No data to Process');    
        }
        }
        else{
            dd('Process running...');    
        }
        
        
    }
    public function process_sms()
    {
        $ids = DB::connection('mysql3')->table('bulk_sms_email')
        ->select("id")
        ->where(['init_indicator' => 1, 'processed' => 'N', 'sms_ind' => 0, 'sent_sms' => 0])->take(5000)->get();
        $mainid = [];
        if (count($ids) > 0) {
            foreach ($ids as $key => $value) {
                array_push($mainid, $value->id);
            }
        }
        
        //dd($mainid);
        if (!empty($mainid)) {

            $processsms = DB::connection('mysql3')->table('bulk_sms_email')
            ->select("bulk_sms_email.content_uniq_id",DB::raw("(GROUP_CONCAT(bulk_sms_email.mob_no SEPARATOR ',')) as `Mobileno`"))
            ->where(['init_indicator' => 1, 'processed' => 'N', 'sms_ind' => 0, 'sent_sms' => 0])->whereIn('id',$mainid)
            ->groupBy(['bulk_sms_email.content_uniq_id'])
            ->get();

           $test = DB::connection('mysql3')->table('bulk_sms_email')
            ->whereIn('id',$mainid)
            ->get();

            $list = [];
            $desc = [];
            foreach ($test as $key22 => $value22) {
                $list["$value22->content_uniq_id"][] = $value22->mob_no;
                $desc["$value22->content_uniq_id"][] = $value22->msg_content;
            }
            $final = [];
            $k = 0;
            foreach ($list as $key33 => $value33) {
                $mob = '';
                $final[$k]['uniqid'] = $key33;
                foreach ($value33 as $key44 => $value44) {
                    $mob .= $value44.',';
                }
                $final[$k]['mobilenos'] = substr($mob,0,-1);
                $final[$k]['content'] = $desc[$key33][0];
                $k += 1;
            }

            

            foreach ($final as $key55 => $value55) {
                $Mobileno = $value55['mobilenos'];
                Log::info('SMS going to trigger.. '.$value55['content'].',  '.$value55['mobilenos']);
                //$sendbulksms = $this->smscurl($value55['content'], $Mobileno);
                //Log::info($sendbulksms);
                $deleterow = DB::connection('mysql3')->table('bulk_sms_email')->where(['content_uniq_id' => $value55['uniqid']])->whereIn('id',$mainid)->delete();
                $senddeleteind_tosap = $this->getbulksmsstatus_out($value55['uniqid']);
            }

            dd('Processed...');

            /*
             foreach ($processsms as $key1 => $value1) {
                 $Mobileno = $value1->Mobileno;
                 $getcontents = DB::connection('mysql3')->table('bulk_sms_email')->where('content_uniq_id','=',$value1->content_uniq_id)->get();
                 $content =  $getcontents[0]->msg_content;
                 Log::info('SMS going to trigger.. '.$content.',  '.$Mobileno);
                 //$sendbulksms = $this->smscurl($content, $Mobileno);
                 //echo 'SMS Send and deleted Contentuniqueid '.$value1->content_uniq_id.'<br>';
                 //$deleterow = DB::connection('mysql3')->table('bulk_sms_email')->where(['content_uniq_id' => $value1->content_uniq_id])->whereIn('id',$mainid)->delete();
                 //$senddeleteind_tosap = $this->getbulksmsstatus_out($value1->content_uniq_id);                
                 
             }
             */

            //dd($processsms);
        }
        else{
            return 'No Data to Process';
        }
       
        dd('processed...');

    }

    public function smscurl($message, $mobilenos)
    {

        /*$fullurl = "http://sms6.routesms.com:8080/bulksms/bulksms";
        $fields = array(
            'username'      => 'vgntran',
            'password'      => 'Vgn@!($@',
            'type'    => 0,
            'dlr'      => 1,
            'destination'      => $mobilenos,
            'source'      => 'VGNALT',
            'message'      => $message
        );*/

	/*$fullurl = "https://api-alerts.kaleyra.com/v4/";
$fields = array(
    'api_key'      => 'A8ef4022b54eff4bb372e8b140507f763',
    'method'      => 'sms',
    'message'      => $message,
    'to'      => $mobileno,
    'sender' => 'VGNOTP'
);*/

/*$fullurl = "https://api-alerts.kaleyra.com/v4/";
$fields = array(
    'api_key'      => 'A8ef4022b54eff4bb372e8b140507f763',
    'method'      => 'sms',
    'message'      => $message.' - VGN Projects Estates.',
    'to'      => $mobileno,
    'sender' => 'VGNOTP'
);*/

$fullurl = "https://api-alerts.kaleyra.com/v4/";
$fields = array(
    'api_key'      => 'A8ef4022b54eff4bb372e8b140507f763',
    'method'      => 'sms',
    'message'      => $message,
    'to'      => $mobileno,
    'sender' => 'VGNOTP'
);
        
        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $fullurl);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);
        Log::info('SMS Triggerred to... '.$message.$mobilenos);
        //return $result;
        Log::info($result);
        
        //Log::info('SMS Triggerred to... '.$message.$mobilenos);
        return 'ok';
    }


    public function sendmail($contents)
    {
        require_once('phpmailer/PHPMailerAutoload.php');

        $mail = new \PHPMailer();
        $return=array();
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        $mail->SMTPDebug = 0;


        $mail->Debugoutput = 'html';


        $mail->Host = 'mail.vgn.in';

        $mail->Port = 587;

        $mail->SMTPAuth = true;
        $mail->Username = "customerzone3";
        $mail->Password = "Vgn@321";
        $mail->setFrom('customerzone3@vgn.in', 'VGN Customer Zone');
        $mail->addReplyTo('no-reply@vgn.in', 'VGN Customer Zone');
        $mail->addAddress($contents['toemail'], $contents['toname']);
        $mail->Subject = $contents['subject'];
        $mail->Body=$contents['content'];
        $mail->AltBody = $contents['content'];

        if(!empty($contents['att_url']))
        $mail->addAttachment($contents['att_url']);
            if (!$mail->send()) {

                $return['code']= 500;
                $return['msg']= "Mailer Error: " . $mail->ErrorInfo."";
            } else {
                $return['code']= 200;
                $return['msg']= "Mail Sent to your Registered EMail!";
            }
                return $return;
    }


}
