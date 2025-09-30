<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use vgn\projectlist;
use vgn\lead_data;
use Response;
use Carbon\Carbon;
use vgn\sqft_range;
use DB;
use vgn\Http\Traits\customertrait;
use Crypt;
use File;

class MobileappController extends Controller
{
    use customertrait;
    public function ongoing() {
       try{
             $response = [
                'projects' => []
            ];
           
            $statusCode = 200;
            $projects = DB::table('projectlist')->where('Status','=','Ongoing')->get();

             $featuredprojectbanner = public_path()."/images/featuredprojectbanner";
                 
                if (is_dir($featuredprojectbanner) === true)
                {
                    $files = File::allFiles($featuredprojectbanner);
                    
                    
                    foreach ($files as $file)
                    {
                        $response['featuredprojectbanner'][] = [
                            'link' => "https://vgn.in/images/featuredprojectbanner/".$file->getRelativePathName()
                        ];
                        
                    }
                    
                        
                }

                $sortarr = ['a'=>'1','b'=>'2','c'=>'5','d'=>'13','e'=>'14','g'=>'109','h'=>'123'];
                $parray1 = [];
                $parray2 = [];
                $i = 0;
                foreach($projects as $project1){
                    $c = 0;
                    foreach ($sortarr as $k=>$id1) {
                        if ($project1->id == $id1) {
                            $parray1[$i] = $project1;
                            $c = 1;
                            $i += 1;
                        }
                    }

                    if ($c == 0) {
                        $parray2[$i] = $project1;
                        $i += 1;
                    }
                }

                $newar = [];
                $newar = array_merge($parray1, $parray2);

    $key = 0;
            foreach($newar as $project){
                
        $sqftrange = DB::table('sqft_range')->where('P_id','=',$project->id)->get();
           
                    $response['projects'][] = [
                    'id' => $project->id,
                    'name' => 'VGN '.$project->Project_name,
                    'type' => $project->Type,
                    'location' => $project->Location,
                    'startingrange' => $project->Startingrange,
                    'status' => $project->projectstatus
                ];


               

                 $bannerdirectory = public_path()."/images/indiv_mobbanner/".$project->id.'.jpg';
                if (File::exists($bannerdirectory))
                {
                        $response['projects'][$key]['imagelink'] = "https://vgn.in/images/indiv_mobbanner/".$project->id.'.jpg';
                                                    
                }
                else{
                    if ($project->Type == 'Apartments') {
                        
                        $response['projects'][$key]['imagelink'] = "https://vgn.in/images/indiv_mobbanner/default_flats.jpg";
                    }
                    elseif($project->Type == 'Plots'){
                       
                        $response['projects'][$key]['imagelink'] = "https://vgn.in/images/indiv_mobbanner/default_plots.jpg";
                    }else{
                        $response['projects'][$key]['imagelink'] = null;
                    }
                    
                     
                }

                if (count($sqftrange) != 0) {
                    foreach ($sqftrange as $newkey => $newvalue) {

                    $response['projects'][$key]['plot'] = $newvalue->Plot;
                    $response['projects'][$key]['bhk'] = $newvalue->BHK;
                    $response['projects'][$key]['sqftstartrange'] = $newvalue->Start;
                    $response['projects'][$key]['sqftendrange'] = $newvalue->End;

                    }
                }
                else
                {
                       $response['projects'][$key]['plot'] = null;
                    $response['projects'][$key]['bhk'] = null;
                    $response['projects'][$key]['sqftstartrange'] = null;
                    $response['projects'][$key]['sqftendrange'] = null;
                }
        
$key++;
    
            }

            return Response::json($response, $statusCode);

        }catch (Exception $e){
            $statusCode = 501;
            $response = array();
            return Response::json($response, $statusCode);
        }
    }
    
    public function locationlist(){
        
        $location = DB::table('projectlist')->distinct()->select('Location')->where('Location','!=','')->orderBy('Location', 'asc')->get();
        return Response::json($location);
    }

     public function completed() {
       try{
             $response = [
                'projects' => []
            ];
           
            $statusCode = 200;
            $projects = DB::table('projectlist')->where('Status','=','Completed')->get();

             $featuredprojectbanner = public_path()."/images/featuredprojectbanner";
                 
                if (is_dir($featuredprojectbanner) === true)
                {
                    $files = File::allFiles($featuredprojectbanner);
                    
                    
                    foreach ($files as $file)
                    {
                        $response['featuredprojectbanner'][] = [
                            'link' => "https://vgn.in/images/featuredprojectbanner/".$file->getRelativePathName()
                        ];
                        
                    }
                    
                        
                }
$key = 0;
            foreach($projects as $project){
                
        $sqftrange = DB::table('sqft_range')->where('P_id','=',$project->id)->get();
           
                    $response['projects'][] = [
                    'id' => $project->id,
                    'name' => 'VGN '.$project->Project_name,
                    'type' => $project->Type,
                    'location' => $project->Location,
                    'startingrange' => $project->Startingrange,
                    'status' => $project->projectstatus
                ];

               
                         $response['projects'][$key]['plot'] = null;
                    $response['projects'][$key]['bhk'] = null;
                    $response['projects'][$key]['sqftstartrange'] = null;
                    $response['projects'][$key]['sqftendrange'] = null;
                


                 $bannerdirectory = public_path()."/images/indiv_mobbanner/".$project->id.'.jpg';
                if (File::exists($bannerdirectory))
                {
                 $response['projects'][$key]['imagelink'] = "https://vgn.in/images/indiv_mobbanner/".$project->id.'.jpg';
                }
                else{
                    if ($project->Type == 'Apartments') {
                        $response['projects'][$key]['imagelink'] = "https://vgn.in/images/indiv_mobbanner/default_flats.jpg";
                    }
                    elseif($project->Type == 'Plots'){
                        $response['projects'][$key]['imagelink'] = "https://vgn.in/images/indiv_mobbanner/default_plots.jpg";
                    }else{
                        $response['projects'][$key]['imagelink'] = null;
                    }
                    
                     
                }

$key++;
            }

            return Response::json($response, $statusCode);

        }catch (Exception $e){
            $statusCode = 501;
            $response = array();
            return Response::json($response, $statusCode);
        }
    }

    public function smscurl($message, $mobileno)
{
/*$fullurl = "http://www.adithya.me/adithya/Api/";
$fields = array(
    'username'      => 'vgn',
    'password'      => 'vgn@123',
    'senderid'    => 'VGNALT',
    'message'      => $message,
    'msgtype'      => 'normal',
    'mobileno'      => $mobileno
);*/

/*$fullurl = "http://sms6.rmlconnect.net:8080/bulksms/bulksms";
$fields = array(
    'username'      => 'vgnotp',
    'password'      => 'Vgn@!($@',
    'type'    => 0,
    'dlr'      => 1,
    'destination'      => $mobileno,
    'source'      => 'VGNOTP',
    'message'      => $message
);*/

$fullurl = "https://api-alerts.kaleyra.com/v4/";
$fields = array(
    'api_key'      => 'A8ef4022b54eff4bb372e8b140507f763',
    'method'      => 'sms',
    'message'      => $message.' - VGN Projects Estates.',
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

return $result;
}

   

    /*public function postmobile() {

      
      if (isset($_POST['loginmobileno'])) {
          
          $loginmobno = $_POST['loginmobileno'];

          if (ctype_digit($loginmobno)) {
           
           if (strlen($loginmobno) == 10) {
               $now = Carbon::now();

            $check = DB::connection('mysql4')->table('loginphoneno')->where(['contactno' => $loginmobno])->get();

                if (count($check) == 0) {
                    //generate otp
                    $random_otp = mt_rand(1090,9997);
                    $session = 0;

                    $smscontent = $random_otp .' is your One Time Password for VGN Property Developers Mobile App';
                
                    $sms_status = $this->smscurl($smscontent, $loginmobno); 
                    
                    //insert otp ans update session as 0 in db
                    $insertmobileno = DB::connection('mysql4')->table('loginphoneno')->insert(['contactno' => $loginmobno,'OTP' => $random_otp,'attempt' =>'0','session'=>$session, 'created_date' => $now]);
                    //send sms
            
                    //return success msg
                     $response = [
                'success' => 'OTP Sent to your Mobile Number!',
                'status_code' => 200
            ];
                
                return $response;

                }
                else
                {
                    foreach ($check as $cvalue) {
                        $sessionget = $cvalue->session;
                        $attempt = $cvalue->attempt;
                    }

                    $newattempt = $attempt + 1;

                    if ($sessionget == 0) {
                        $random_otp = mt_rand(1090,9997);
                        $smscontent = $random_otp .' is your One Time Password for VGN Property Developers Mobile App';
                
                    $sms_status = $this->smscurl($smscontent, $loginmobno); 
                    
                    //insert otp ans update session as 0 in db
                    $update = DB::connection('mysql4')->table('loginphoneno')->where('contactno','=',$loginmobno)->update(['OTP' => $random_otp,'session'=>'0','attempt' =>$newattempt, 'created_date' => $now]);

                     $response = [
                'success' => 'OTP Sent to your Mobile Number!',
                'status_code' => 200
            ];
                
                return $response;

                    }
                    else{
                           $response = [
                'success' => 'Login Success',
                'status_code' => 200
            ];
                
                return $response;
                    }
                }
            
           }
           else {
                 $response = [
                'error' => 'Invalid Mobile Number!',
                'status_code' => 204
            ];
                
                return $response;             
           }

          }
          else {
                $response = [
                'error' => 'Invalid Mobile Number!',
                'status_code' => 204
            ];
                
                return $response;     
          }
      }
      else
      {
          $response = [
                'error' => 'Invalid Mobile Number!',
                'status_code' => 204
            ];
                
                return $response;     
      }

    }*/


     public function postmobile() {

      
      if (isset($_POST['loginmobileno'])) {
          
          $loginmobno = $_POST['loginmobileno'];

          if (ctype_digit($loginmobno)) {
           
           if (strlen($loginmobno) == 10) {
               $now = Carbon::now();

            $check = DB::connection('mysql4')->table('loginphoneno')->where(['contactno' => $loginmobno])->count();
            if ($check > 0) {
            	DB::connection('mysql4')->table('loginphoneno')->where(['contactno' => $loginmobno])->delete();
            }
                
                    //generate otp
                    $random_otp = mt_rand(1090,9997);
                    $session = 0;

                    $smscontent = $random_otp .' is your One Time Password for VGN Property Developers Mobile App';
                
                    $sms_status = $this->smscurl($smscontent, $loginmobno); 
                    
                    //insert otp ans update session as 0 in db
                    $insertmobileno = DB::connection('mysql4')->table('loginphoneno')->insert(['contactno' => $loginmobno,'OTP' => $random_otp, 'created_date' => $now]);
                    //send sms
            
                    //return success msg
                     $response = [
                'success' => 'OTP Sent to your Mobile Number!',
                'status_code' => 200
            ];
                
                return $response;

                
                
            
           }
           else {
                 $response = [
                'error' => 'Invalid Mobile Number!',
                'status_code' => 204
            ];
                
                return $response;             
           }

          }
          else {
                $response = [
                'error' => 'Invalid Mobile Number!',
                'status_code' => 204
            ];
                
                return $response;     
          }
      }
      else
      {
          $response = [
                'error' => 'Invalid Mobile Number!',
                'status_code' => 204
            ];
                
                return $response;     
      }

    }

    public function otpverify()
    {
        
        if (isset($_POST['loginmobileno'])&&isset($_POST['otptoverify'])) {
          
          $loginmobno = $_POST['loginmobileno'];
          $otptoverify = $_POST['otptoverify'];
            $now = Carbon::now();
          $getotp = DB::connection('mysql4')->table('loginphoneno')->where('contactno','=',$loginmobno)->get();

          if (count($getotp) > 0 ) {
              foreach ($getotp as $key => $value) {
                  $dbotp = $value->OTP;
                }

              if ($otptoverify == $dbotp) {
                   $response = [
                'success' => 'Login Success',
                'status_code' => 200
            ];

            
            $update = DB::connection('mysql4')->table('loginphoneno')->where('contactno','=',$loginmobno)->update(['created_date' => $now]);
                
                return $response; 
              }
              else{
                     $response = [
                'error' => 'Invalid Valid OTP',
                'status_code' => 204
            ];
                
                return $response; 
              }
          }
          else{
               $response = [
                'error' => 'Invalid Valid OTP',
                'status_code' => 204
            ];
                
                return $response;
          }
        }
        else{
             $response = [
                'error' => 'Invalid Valid OTP',
                'status_code' => 204
            ];
                
                return $response; 
        }
    }

    public function forgetotplogin()
    {
         if (isset($_POST['loginmobileno'])) {
          
          $loginmobno = $_POST['loginmobileno'];
          
$getotp = DB::connection('mysql4')->table('loginphoneno')->where('contactno','=',$loginmobno)->get();

if (count($getotp) > 0 ) {
    $update = DB::connection('mysql4')->table('loginphoneno')->where('contactno','=',$loginmobno)->delete();
     $response = [
                'success' => 'Logout Success',
                'status_code' => 200
            ];
                
                return $response; 
}
else{
   $response = [
                'error' => 'Not Valid',
                'status_code' => 204
            ];
                
                return $response; 
}
          
         }
         else{
              $response = [
                'error' => 'Not Valid',
                'status_code' => 204
            ];
                
                return $response; 
         }
    }

     public function newul_to_array($ul) {
      
       // Create a DOM object
        $newul = explode("<ul>",$ul);
       // dd($newul);
       $newarray = array();
       $headarray = array();
        foreach($newul as $k=>$v){
            if(!empty($v)){
                $v = preg_replace( "/\r|\n/", "", $v );
                     preg_match( '#<h3[^>]*>(.*?)</h3>#i', $v, $match ); 
                
                $content = preg_replace('/<h3[^>]*>([\s\S]*?)<\/h3[^>]*>/', '', $v);
                
                $content = str_replace('</ul>','',$content);
                $newcontent = explode("<li>",$content);
                
                foreach($newcontent as $newk => $newv)
                if(!empty($newv)){
                	$newv = trim($newv);
                    if(!empty($match[1])){
                        $newv = str_replace('</li>','',$newv);
                        if (!empty($newv)) {
                        	 $newarray[$k][$newk] = $newv ;
                        	$headarray[$k+1] = $match[1];
                        }
                        
                    }
                    else
                    {
                        $newv = str_replace('</li>','',$newv);
                        if (!empty($newv)) {
                        $newarray[$k][$newk] = $newv ;
                    }
                    }
                    
                }
                //dd($this->ul_to_array($content));
               
            }
            
            //dd($v);
        }
        //dd($headarray);
        $newarr = [];

        if(!empty($headarray)){
            foreach($newarray as $jk=>$jkarray){

                if(array_key_exists($jk,$headarray)){
                    $keyval = $headarray[$jk];
                    $finalarray[$keyval] = $jkarray;
                }
                else
                {
                    $finalarray[] = $jkarray;
                }
            }
            //dd($finalarray);
            if (!empty($finalarray)) {
            foreach ($finalarray as $newkey => $newvalue) {
           $newarr[$newkey] = array_values($newvalue);   
            }
          }
        }
        else{
          //dd($newarray);
          
          if (!empty($newarray)) {
            foreach ($newarray as $newkey => $newvalue) {

           $newarr[$newkey] = array_values($newvalue);   
            }
          }
           
        }
        return $newarr;
        
    }

     public function ongoingviewdetails($projid) {
         if ($projid == null) {
             return 204;
         }
       try{
             $response = [
                'projects' => []
            ];
           
            $statusCode = 200;
            $projects = DB::table('projectlist')->where(['Status' => 'Ongoing','id' => $projid ])->get();
$key = 0;
            foreach($projects as $project){
                
        $sqftrange = DB::table('sqft_range')->where('P_id','=',$project->id)->get();
           
                    $response['projects'][] = [
                    'id' => $project->id,
                    'name' => $project->Project_name,
                    'type' => $project->Type,
                    'location' => $project->Location,
                    'startingrange' => $project->Startingrange,
                    'single_quote' => $project->single_quote,
                    'youtubelink' => $project->youtube_link,
                    'locationsection' => $project->location_section,
                    'locationadvantage' => $project->location_adv_section,
                ];

              if(view()->exists('amenities.'.$project->id)){  
    $contents = view('amenities.'.$project->id)->render();
    $response['projects'][$key]['amenities'] = $contents;
              }
              else{
                  $response['projects'][$key]['amenities'] = null;
              }


              $getgooglelocation = DB::table('googlemaplocation')->where('projectid','=',$project->id)->get();

              if (count($getgooglelocation) > 0) {
              		foreach ($getgooglelocation as $googlevalue) {
              			$response['projects'][$key]['latitude'] = $googlevalue->latitude;
              			$response['projects'][$key]['longitude'] = $googlevalue->longitude;
              		}
              }
              else
              {
              			$response['projects'][$key]['latitude'] = null;
              			$response['projects'][$key]['longitude'] = null;
              }

                $bannerdirectory = public_path()."/images/mobbanner/".$project->id.'.jpg';
                if (File::exists($bannerdirectory))
                {
                        $response['projects'][$key]['link'] = "https://vgn.in/images/mobbanner/".$project->id.'.jpg';
                }
                else{
                      $response['projects'][$key]['link'] = null;
                }

                 $constructiondirectory = public_path()."/images/construction/".$project->id;
                 
                if (is_dir($constructiondirectory) === true)
                {
                    //$files = File::allFiles($constructiondirectory);
                    $files = collect(File::allFiles($constructiondirectory))
        ->sortBy(function ($file) {
            return $file->getRelativePathname();
        });
                    
                    $inc = 0;
                    foreach ($files as $file)
                    {
                        $response['projects'][$key]['constructionpics'][] = [
                            $inc => "https://vgn.in/images/construction/".$project->id.'/'.$file->getRelativePathName()
                        ];
                    }
                    
                        
                }
                else{
                      $response['projects'][$key]['constructionpics'][] = [];
                }
               

                if (count($sqftrange) != 0) {
                    foreach ($sqftrange as $newkey => $newvalue) {
                         
                    $response['projects'][$key]['plot'] = $newvalue->Plot;
                    $response['projects'][$key]['bhk'] = $newvalue->BHK;
                    $response['projects'][$key]['sqftstartrange'] = $newvalue->Start;
                    $response['projects'][$key]['sqftendrange'] = $newvalue->End;
                
                    }
                }
                else
                {
                       $response['projects'][$key]['plot'] = null;
                    $response['projects'][$key]['bhk'] = null;
                    $response['projects'][$key]['sqftstartrange'] = null;
                    $response['projects'][$key]['sqftendrange'] = null;
                }
        
$key++;

            }

            return Response::json($response, $statusCode);

        }catch (Exception $e){
            $statusCode = 501;
            $response = array();
            return Response::json($response, $statusCode);
        }
    }
    
    public function ul_to_array ($ul) {
        
  if (is_string($ul)) {
      
    // encode ampersand appropiately to avoid parsing warnings
    $ul=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $ul);
      //dd($ul);
    if (!$ul = simplexml_load_string($ul)) {
      //trigger_error("Syntax error in UL/LI structure");
      return false;
    }
      
    return $this->ul_to_array($ul);
  } else if (is_object($ul)) {
      
    $output = array();
    foreach ($ul->li as $li) {
      $output[] = (isset($li->ul)) ? $this->ul_to_array($li->ul) : (string) $li;
    }
    return $output;
  } else return false;
}
    
    public function div_to_array($ul) {
      
       // Create a DOM object
        $div = explode("<div class=\"col-md-4 single-post-page\">",$ul);
        //dd($div);
       $newarray = array();

        foreach($div as $k=>$v){
            if(!empty($v)){
                $v = preg_replace( "/\r|\n/", "", $v );
                     preg_match( '#<h3[^>]*>(.*?)</h3>#i', $v, $match ); 
                
                $content = preg_replace('/<h3[^>]*>([\s\S]*?)<\/h3[^>]*>/', '', $v);
                $content = str_replace('</div>','',$content);
                $content = trim($content);
                
                //dd($this->ul_to_array($content));
                $newarray[$match[1]] = $this->ul_to_array($content) ;
            }
            //dd($v);
        }

        return $newarray;
        
    }
    
   
    public function newongoingviewdetails($projid) {
         if ($projid == null) {
             return 204;
         }
       try{
             $response = [
                'projects' => []
            ];
           
            $statusCode = 200;
            $projects = DB::table('projectlist')->where(['Status' => 'Ongoing','id' => $projid ])->get();
$key = 0;
            foreach($projects as $project){
                
        $sqftrange = DB::table('sqft_range')->where('P_id','=',$project->id)->get();
           
                    $response['projects'][] = [
                    'id' => $project->id,
                    'name' => $project->Project_name,
                    'type' => $project->Type,
                    'location' => $project->Location,
                    'startingrange' => $project->Startingrange,
                    'single_quote' => $project->single_quote,
                    'youtubelink' => $project->youtube_link,
                    'locationsection' => $project->location_section,
                    'locationadvantage' => $project->location_adv_section,
                ];
                
               
                
                if(!empty($project->location_adv_section) || $project->location_adv_section != null){
                    //dd($project->location_adv_section);
                    $listcheck = $this->newul_to_array($project->location_adv_section);
                    //dd($listcheck);
                    if(!empty($listcheck) || $listcheck != null){
                    $response['projects'][$key]['locationadvantagenew'] = $listcheck;
                    }
                    else
                    {
                        $response['projects'][$key]['locationadvantagenew'] = [];
                    }
                }
                else
                {
                    $response['projects'][$key]['locationadvantagenew'] = $project->location_adv_section;
                }

              if(view()->exists('amenities.'.$project->id)){  
    $contents = view('amenities.'.$project->id)->render();
                  if(!empty($contents)){
                      
                  $newcheck = $this->div_to_array($contents);

                      $response['projects'][$key]['amenitiesnew'] = $newcheck;
                  }
    $response['projects'][$key]['amenities'] = $contents;
              }
              else{
                  $response['projects'][$key]['amenities'] = null;
                  $response['projects'][$key]['amenitiesnew'] = null;
              }


              $getgooglelocation = DB::table('googlemaplocation')->where('projectid','=',$project->id)->get();

              if (count($getgooglelocation) > 0) {
              		foreach ($getgooglelocation as $googlevalue) {
              			$response['projects'][$key]['latitude'] = $googlevalue->latitude;
              			$response['projects'][$key]['longitude'] = $googlevalue->longitude;
              		}
              }
              else
              {
              			$response['projects'][$key]['latitude'] = null;
              			$response['projects'][$key]['longitude'] = null;
              }

                $bannerdirectory = public_path()."/images/mobbanner/".$project->id.'.jpg';
                if (File::exists($bannerdirectory))
                {
                        $response['projects'][$key]['link'] = "https://vgn.in/images/mobbanner/".$project->id.'.jpg';
                }
                else{
                      $response['projects'][$key]['link'] = null;
                }

                 $constructiondirectory = public_path()."/images/construction/".$project->id;
                 
                if (is_dir($constructiondirectory) === true)
                {
                    //$files = File::allFiles($constructiondirectory);
                    $files = collect(File::allFiles($constructiondirectory))
        ->sortBy(function ($file) {
            return $file->getRelativePathname();
        });
                    
                    $inc = 0;
                    foreach ($files as $file)
                    {
                        $response['projects'][$key]['constructionpics'][] = [
                            $inc => "https://vgn.in/images/construction/".$project->id.'/'.$file->getRelativePathName()
                        ];
                    }
                    
                        
                }
                else{
                      $response['projects'][$key]['constructionpics'][] = [];
                }
               

                if (count($sqftrange) != 0) {
                    $jj=0;
                    foreach ($sqftrange as $newkey => $newvalue) {
                        
                        $response['projects'][$key]['plot'] = $newvalue->Plot;
                    $response['projects'][$key]['bhk'] = $newvalue->BHK;
                    $response['projects'][$key]['sqftstartrange'] = $newvalue->Start;
                    $response['projects'][$key]['sqftendrange'] = $newvalue->End;
                        
                         
                    $response['projects'][$key]['sqftdetailsnew'][$jj]['plot'] = $newvalue->Plot;
                    $response['projects'][$key]['sqftdetailsnew'][$jj]['bhk'] = $newvalue->BHK;
                    $response['projects'][$key]['sqftdetailsnew'][$jj]['sqftstartrange'] = $newvalue->Start;
                    $response['projects'][$key]['sqftdetailsnew'][$jj]['sqftendrange'] = $newvalue->End;
                $jj++;
                    }
                }
                else
                {
                     $response['projects'][$key]['plot'] = null;
                    $response['projects'][$key]['bhk'] = null;
                    $response['projects'][$key]['sqftstartrange'] = null;
                    $response['projects'][$key]['sqftendrange'] = null;
                    
                       $response['projects'][$key]['sqftdetailsnew'] = [];
                    
                }
        
$key++;

            }



            return Response::json($response, $statusCode);

        }catch (Exception $e){
            $statusCode = 501;
            $response = array();
            return Response::json($response, $statusCode);
        }
    }

     public function completedviewdetails($projid) {
         if ($projid == null) {
             return 204;
         }
       try{
             $response = [
                'projects' => []
            ];
           
            $statusCode = 200;
            $projects = DB::table('projectlist')->where(['Status' => 'Completed','id' => $projid ])->get();
$key = 0;
            foreach($projects as $project){
                
        $sqftrange = DB::table('sqft_range')->where('P_id','=',$project->id)->get();
           
                    $response['projects'][] = [
                    'id' => $project->id,
                    'name' => $project->Project_name,
                    'type' => $project->Type,
                    'location' => $project->Location,
                    'startingrange' => $project->Startingrange,
                    'single_quote' => $project->single_quote,
                    'youtubelink' => $project->youtube_link,
                    'locationsection' => $project->location_section,
                    'locationadvantage' => $project->location_adv_section,
                ];


                $bannerdirectory = public_path()."/images/mobbanner/".$project->id.'.jpg';
                if (File::exists($bannerdirectory))
                {
                        $response['projects'][$key]['link'] = "https://vgn.in/images/mobbanner/".$project->id.'.jpg';
                }
                else{
                            $response['projects'][$key]['link'] = null;
                }


                 $getgooglelocation = DB::table('googlemaplocation')->where('projectid','=',$project->id)->get();

              if (count($getgooglelocation) > 0) {
              		foreach ($getgooglelocation as $googlevalue) {
              			$response['projects'][$key]['latitude'] = $googlevalue->latitude;
              			$response['projects'][$key]['longitude'] = $googlevalue->longitude;
              		}
              }
              else
              {
              			$response['projects'][$key]['latitude'] = null;
              			$response['projects'][$key]['longitude'] = null;
              }

                 $constructiondirectory = public_path()."/images/construction/".$project->id;
                 
                if (is_dir($constructiondirectory) === true)
                {
                    //$files = File::allFiles($constructiondirectory);
                    $files = collect(File::allFiles($constructiondirectory))
        ->sortBy(function ($file) {
            return $file->getRelativePathname();
        });
                    
                    $inc = 0;
                    foreach ($files as $file)
                    {
                        $response['projects'][$key]['constructionpics'][] = [
                            $inc => "https://vgn.in/images/construction/".$project->id.'/'.$file->getRelativePathName()
                        ];
                    }
                    
                        
                }
                else{
                      $response['projects'][$key]['constructionpics'][] = [];
                }
               

                if (count($sqftrange) != 0) {
                    foreach ($sqftrange as $newkey => $newvalue) {
                         $response['projects'][$key]['plot'] = $newvalue->Plot;
                    $response['projects'][$key]['bhk'] = $newvalue->BHK;
                    $response['projects'][$key]['sqftstartrange'] = $newvalue->Start;
                    $response['projects'][$key]['sqftendrange'] = $newvalue->End;
                    }
                }
                else
                {
                       $response['projects'][$key]['plot'] = null;
                    $response['projects'][$key]['bhk'] = null;
                    $response['projects'][$key]['sqftstartrange'] = null;
                    $response['projects'][$key]['sqftendrange'] = null;
                }
        


            }

            return Response::json($response, $statusCode);

        }catch (Exception $e){
            $statusCode = 501;
            $response = array();
            return Response::json($response, $statusCode);
        }
    }
    
    public function newcompletedviewdetails($projid) {
         if ($projid == null) {
             return 204;
         }
       try{
             $response = [
                'projects' => []
            ];
           
            $statusCode = 200;
            $projects = DB::table('projectlist')->where(['Status' => 'Completed','id' => $projid ])->get();
$key = 0;
            foreach($projects as $project){
                
        $sqftrange = DB::table('sqft_range')->where('P_id','=',$project->id)->get();
           
                    $response['projects'][] = [
                    'id' => $project->id,
                    'name' => $project->Project_name,
                    'type' => $project->Type,
                    'location' => $project->Location,
                    'startingrange' => $project->Startingrange,
                    'single_quote' => $project->single_quote,
                    'youtubelink' => $project->youtube_link,
                    'locationsection' => $project->location_section,
                    'locationadvantage' => $project->location_adv_section,
                ];
                
                 if(!empty($project->location_adv_section) || $project->location_adv_section != null){
                    //dd($project->location_adv_section);
                    $listcheck = $this->newul_to_array($project->location_adv_section);
                    //dd($listcheck);
                    if(!empty($listcheck) || $listcheck != null){
                    $response['projects'][$key]['locationadvantagenew'] = $listcheck;
                    }
                    else
                    {
                        $response['projects'][$key]['locationadvantagenew'] = [];
                    }
                }
                else
                {
                    $response['projects'][$key]['locationadvantagenew'] = $project->location_adv_section;
                }
                
                
                  if(view()->exists('amenities.'.$project->id)){  
    $contents = view('amenities.'.$project->id)->render();
                  if(!empty($contents)){
                      //dd($contents);
                  $newcheck = $this->div_to_array($contents);
                      $response['projects'][$key]['amenitiesnew'] = $newcheck;
                  }
    $response['projects'][$key]['amenities'] = $contents;
              }
              else{
                  $response['projects'][$key]['amenities'] = null;
                  $response['projects'][$key]['amenitiesnew'] = null;
              }


                $bannerdirectory = public_path()."/images/mobbanner/".$project->id.'.jpg';
                if (File::exists($bannerdirectory))
                {
                        $response['projects'][$key]['link'] = "https://vgn.in/images/mobbanner/".$project->id.'.jpg';
                }
                else{
                            $response['projects'][$key]['link'] = null;
                }


                 $getgooglelocation = DB::table('googlemaplocation')->where('projectid','=',$project->id)->get();

              if (count($getgooglelocation) > 0) {
              		foreach ($getgooglelocation as $googlevalue) {
              			$response['projects'][$key]['latitude'] = $googlevalue->latitude;
              			$response['projects'][$key]['longitude'] = $googlevalue->longitude;
              		}
              }
              else
              {
              			$response['projects'][$key]['latitude'] = null;
              			$response['projects'][$key]['longitude'] = null;
              }

                 $constructiondirectory = public_path()."/images/construction/".$project->id;
                 
                if (is_dir($constructiondirectory) === true)
                {
                    //$files = File::allFiles($constructiondirectory);
                    $files = collect(File::allFiles($constructiondirectory))
        ->sortBy(function ($file) {
            return $file->getRelativePathname();
        });
                    
                    $inc = 0;
                    foreach ($files as $file)
                    {
                        $response['projects'][$key]['constructionpics'][] = [
                            $inc => "https://vgn.in/images/construction/".$project->id.'/'.$file->getRelativePathName()
                        ];
                    }
                    
                        
                }
                else{
                      $response['projects'][$key]['constructionpics'][] = [];
                }
               

                if (count($sqftrange) != 0) {
                    $jj=0;
                    foreach ($sqftrange as $newkey => $newvalue) {
                        
                        $response['projects'][$key]['plot'] = $newvalue->Plot;
                    $response['projects'][$key]['bhk'] = $newvalue->BHK;
                    $response['projects'][$key]['sqftstartrange'] = $newvalue->Start;
                    $response['projects'][$key]['sqftendrange'] = $newvalue->End;
                        
                         
                    $response['projects'][$key]['sqftdetailsnew'][$jj]['plot'] = $newvalue->Plot;
                    $response['projects'][$key]['sqftdetailsnew'][$jj]['bhk'] = $newvalue->BHK;
                    $response['projects'][$key]['sqftdetailsnew'][$jj]['sqftstartrange'] = $newvalue->Start;
                    $response['projects'][$key]['sqftdetailsnew'][$jj]['sqftendrange'] = $newvalue->End;
                $jj++;
                    }
                }
                else
                {
                     $response['projects'][$key]['plot'] = null;
                    $response['projects'][$key]['bhk'] = null;
                    $response['projects'][$key]['sqftstartrange'] = null;
                    $response['projects'][$key]['sqftendrange'] = null;
                    
                       $response['projects'][$key]['sqftdetailsnew'] = [];
                    
                }
        
$key++;

            }

            return Response::json($response, $statusCode);

        }catch (Exception $e){
            $statusCode = 501;
            $response = array();
            return Response::json($response, $statusCode);
        }
    }

     public function aboutus() {
       try{
             $response = [
                'about' => []
            ];
           
           
                $statusCode = 200;
                $response['about'][] = [
                    'data' => '<p>Established in the year 1942, VGN has successfully carved a niche for itself in the ever-dynamic real estate industry over the last 76 years. An ISO 9001:2008 certified company, VGN is known as much for its beautiful, world-class homes as it is for following best practices in the industry, being an IMS certified company.</p>
                    <p>With over 20 million sq. ft. of residential projects under development, VGN is one of the most respected and reputed builders in Chennai. Starting with affordable housing and spreading our wings to ultra-luxury segment, we have catered to all sections of the society. Synonymous with quality, timely delivery, expertise and trust, VGN is a name that is here to stay.</p>
                    <p>While we may have numerous achievements under our belt, we take pride in the fact that we have been helping thousands of families realize their dreams, providing exponential returns on their investments. And it is this satisfaction that we derive from what we do that makes us venture into newer and more challenging areas in property development.</p>'
                    
                ];            

            return Response::json($response, $statusCode);

        }catch (Exception $e){
            $statusCode = 501;
            $response = array();
            return Response::json($response, $statusCode);
        }
    }

    public function contactus() {
       try{
             $response = [
                'contact' => []
            ];
           
           
                $statusCode = 200;
                $response['contact'][] = [
                    'phone' => '044 43439999',
                    'email' => 'sales@vgn.in',
                    'Address' => 'No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.',
                    'customersupport' => '044 43439977',
                    'googlemapembedlink' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3886.6022545844353!2d80.24633671437631!3d13.060970690797275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a526669868471cf%3A0x6c9abb4bc5649a04!2sVGN+Property+Developers+Private+Limited!5e0!3m2!1sen!2sin!4v1505814586770',
                    'latitude' => '13.061232',
                    'longitude' => '80.248558'
                    
                ];            

            return Response::json($response, $statusCode);

        }catch (Exception $e){
            $statusCode = 501;
            $response = array();
            return Response::json($response, $statusCode);
        }
    }


    public function postlogin(Request $request) {
      
      if (isset($_POST['username'])&&isset($_POST['password'])) {
          $username = $_POST['username'];
          $password = $_POST['password'];

        
        if (strpos($username, '@') !== false) {
            $loginmode = 'loginmode_emailid';
        }
        elseif (ctype_digit($username)) {

            if (strlen($username) == 10) {
                $loginmode = 'loginmode_mobileno';
            }
            elseif((strlen($username) >= 3)&&(strlen($username) < 10)){
                $loginmode = 'loginmode_customerid';
            }
            else{
                $response = [
                'error' => 'Sorry! Enter a valid CustomerId or Mobile Number',
                'status_code' => 204
            ];
                
                return $response;
            }
                
        }
        else{
            
            $response = [
                'error' => 'Sorry! Enter a valid Username',
                'status_code' => 204
            ];
                
                return $response;
        }

        
        if ($loginmode == 'loginmode_customerid') {
            if (!ctype_digit($username)) {
                 $response = [
                'error' => 'Sorry! Enter a valid Customer Id',
                'status_code' => 204
            ];
                
                return $response;
            }
            $check = DB::connection('mysql3')->table('customer')->where(['id' => $username , 'password' => $password])->get();
        }

        elseif ($loginmode == 'loginmode_emailid') {

            if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                 $response = [
                'error' => 'Sorry! Enter a valid Email Id',
                'status_code' => 204
            ];
                return $response;
                

                }
            $check = DB::connection('mysql3')->table('customer')->where(['email' => $username , 'password' => $password])->get();
            
        }
        
        elseif ($loginmode == 'loginmode_mobileno') {

            if (!preg_match('/^[0-9]{10}+$/', $username)) {
                
                  $response = [
                'error' => 'Sorry! Enter a valid Mobile Number',
                'status_code' => 204
            ];
                return $response;

                }
            $check = DB::connection('mysql3')->table('customer')->where(['mobile' => $username , 'password' => $password])->get();
        }
        else{                
                 $response = [
                'error' => 'Sorry! Enter a valid Username and Password!',
                'status_code' => 204
            ];
                return $response;
        }
         



      }
      else
      {
            $response = [
                'error' => 'Please fill all the fields!',
                'status_code' => 204
            ];
                return $response;
      }

     
           if (count($check) == 1) {
                    
             
             foreach ($check as $value) {
            
            
                 $toencrypt = $value->id.'-#Vgn@M@ain`encRyption89';
                 $encrypt = substr(Crypt::encrypt($toencrypt),0,16);
                 $now = Carbon::now();
                 $selectcustomer = DB::connection('mysql4')->table('customersession')->where(['customerid' => $value->id])->count();
                 if ($selectcustomer == 1) {
            DB::connection('mysql4')->table('customersession')->where('customerid','=',$value->id)->update(['sessionkey' => $encrypt, 'created_date' => $now]);                     
              $response = [
                'success' => 'Login Success',
                'apikey' => $encrypt,
                'status_code' => 200
            ];
                return $response;
                 }
                 else{
            DB::connection('mysql4')->table('customersession')->insert(['customerid' => $value->id , 'sessionkey' => $encrypt, 'created_date' => $now]);
                  $response = [
                'success' => 'Login Success',
                'apikey' => $encrypt,
                'status_code' => 200
            ];
                return $response;
                 }
                
             }

             }
             else{
                 $request->session()->flash("error_msg", "");
                 
                   $response = [
                'error' => 'Sorry! Username and Password Does not Match!',
                'status_code' => 204
            ];
                return $response;
                
             }

    }


    

     public function postlogout() {
      
      if (isset($_POST['key'])) {
          //$customerid = $_POST['customerid'];
          $customerkey = $_POST['key'];
        
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                              
              DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->delete();       
             
             $response = [
                'success' => 'Logout Success',
                'status_code' => 200
            ];
                return $response;
                 }
                 else{
                  $response = [
                'error' => 'No Customer Id',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No Customer Id',
                'status_code' => 204
            ];
                return $response;
             }

    }

    public function mydetails() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
             
             foreach ($getcustomerdata as $value) {
                 $response = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager,
                'street1' => $value->street1,
                'street2' => $value->street2,
                'street3' => $value->street3,
                'houseno' => $value->houseno,
                'city' => $value->city,
                'pin' => $value->pin,
                'region' => $value->region,
                'country' => $value->country,
                'tel' => $value->tel,
                'mobile' => $value->mobile,
                'fax' => $value->fax,
                'email' => $value->email
               
            ];
             }
             
                return $response;
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }


     public function dashboard() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {

            $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }

              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
             
             foreach ($getcustomerdata as $value) {
                 $response = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager,
                'lastchangeddetails' => $value->updated,
                'totalcomplaintraised' => $value->comp_raised,
                'totalcomplaintclosed' => $value->comp_closed,
                'totalcomplaintpending' => $value->comp_pending,
                'passwordchangedcount' => $value->pwd_count,
                'lastpasswordchangeddate' => $value->pwd_updated,
                'paymentoutstanding' => $value->net_amt,
                'noofprojectbooked' => $value->nou,
            ];
             }
             
                return $response;
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }

    public function postchangemydetails()
    {
       
         if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                         
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
             
            

        $errors = array();
          $address1 = isset($_POST['addr1'])? $_POST['addr1']: '';
          $address2 = isset($_POST['addr2'])? $_POST['addr2']: '';
          $address3 = isset($_POST['addr3'])? $_POST['addr3']: '';
          $houseno = isset($_POST['houseno'])? $_POST['houseno']: '';
          $city = isset($_POST['city'])? $_POST['city']: '';
          $country = isset($_POST['country'])? $_POST['country']: '';
          $pincode = isset($_POST['pincode'])? $_POST['pincode']: '';
          $region = isset($_POST['region'])? $_POST['region']: '';
          $telephone = isset($_POST['telephone'])? $_POST['telephone']: '';
          $mobile = isset($_POST['mobile'])? $_POST['mobile']: '';
          $fax = isset($_POST['fax'])? $_POST['fax']: '';
     

     if (empty($address1)) {  $errors['msg']['addr1'][] = "Address 1 field is required.";   }
     if (strlen($address1) > 40) {  $errors['msg']['addr1'][] = "Address 1 field characters should not exceed 40.";   }
     if (empty($address2)) {  $errors['msg']['addr2'][] = "Address 2 field is required.";   }
     if (strlen($address2) > 40) {  $errors['msg']['addr2'][] = "Address 2 field characters should not exceed 40.";   }
     if (empty($city)) {  $errors['msg']['city'][] = "City field is required.";   }
     if (empty($country)) {  $errors['msg']['country'][] = "Country field is required.";   }
     if (empty($pincode)) {  $errors['msg']['pincode'][] = "Pincode field is required.";   }
     if (empty($region)) {  $errors['msg']['region'][] = "Region field is required.";   }
     if (empty($telephone)) {  $errors['msg']['telephone'][] = "Telephone field is required.";   }
     if (ctype_digit($telephone) === false) {  $errors['msg']['telephone'][] = "Telephone field should be numeric.";   }
     if (ctype_digit($telephone)) {  if(strlen($telephone) > 16)$errors['msg']['telephone'][] = "Telephone field should not exceed 16 digits.";   }
     if (empty($mobile)) {  $errors['msg']['mobile'][] = "Mobile field is required.";   }
     if (ctype_digit($mobile) === false) {  $errors['msg']['mobile'][] = "Mobile field should be numeric.";   }
     if (ctype_digit($mobile)) {  if(strlen($mobile) != 10)$errors['msg']['mobile'][] = "Mobile field should be 10 digits.";   }
     
     
        if (!empty($errors)) {
        return Response::json($errors);     
        }
        else{
        

           $now = Carbon::now();
            foreach ($getcustomerdata as $value) {
                $pwdcount = $value->pwd_count;
                $email = $value->email;
            }
        
            $newpwdcount = $pwdcount + 1;
            $updateinsap = $this->saveUserDetails($customerid, $address1, $address2, $address3, $houseno,$city,$pincode,$country,$region,$telephone,$mobile,$fax,$email);
            

            DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->update(['street1' => $address1,
            'street2' => $address2,
            'street3' => $address3,
            'houseno' => $houseno,
            'city' => $city,
            'country' => $country,
            'pin' => $pincode,
            'region' => $region,
            'tel' => $telephone,
            'mobile' => $mobile,
            'fax' => $fax,
             'updated' => $now ]);


         $response = [
                'success' => 'Successfully Profile has been updated!',
                'status_code' => 200
            ];
                return $response;
        }           
                
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }
        
    }


    public function postchangepassword()
    {
       
         if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];        

        
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
             
            

        $errors = array();
          $oldpasword = isset($_POST['oldpasword'])? $_POST['oldpasword']: '';
          $newpassword = isset($_POST['newpassword'])? $_POST['newpassword']: '';
          $retypepass = isset($_POST['retypepass'])? $_POST['retypepass']: '';
              

     if (empty($oldpasword)) {  $errors['msg']['oldpasword'][] = "Old Password is required.";   }
     if (empty($newpassword)) {  $errors['msg']['newpassword'][] = "New Password is required.";   }
     if ((strlen($newpassword) < 6) || (strlen($newpassword) > 12)) {  $errors['msg']['newpassword'][] = "New Password Minimum characters 6 and Maximum characters 12.";   }
    
     if (empty($retypepass)) {  $errors['msg']['retypepass'][] = "Retype Password is required.";   }
     if ($newpassword != $retypepass) {  $errors['msg']['retypepass'][] = "Retype Password not matched with New Password.";   }

     
        if (!empty($errors)) {
        return Response::json($errors);     
        }
        else{
        

        $checkpassword = DB::connection('mysql3')->table('customer')->where('password', '=', $oldpasword)->count();

        if ($checkpassword == 0) {
             $errors['msg']['error_msg'][] = "Sorry! Entered Old Password is incorrect!"; 
             
                return Response::json($errors);     
        
        }
        else
        {
            
            $now = Carbon::now();
            foreach ($getcustomerdata as $value) {
                $pwdcount = $value->pwd_count;
            }

            $newpwdcount = $pwdcount + 1;
            
            DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->update(['password' => $newpassword, 'pwd_updated' => $now, 'pwd_count' => $newpwdcount ]);
                        
             $response = [
                'success' => 'successfully New Password has been updated!',
                'status_code' => 200
            ];
                return $response;

        }


        }           
                
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }
        
    }


    public function countryandstatenames()
    {
        $decoded_states = array(["c_id"=>"IN","s_id"=>"1","s_nm"=>"Andra Pradesh"],["c_id"=>"IN","s_id"=>"2","s_nm"=>"Arunachal Pradesh"],["c_id"=>"IN","s_id"=>"3","s_nm"=>"Assam"],["c_id"=>"IN","s_id"=>"4","s_nm"=>"Bihar"],["c_id"=>"IN","s_id"=>"5","s_nm"=>"Goa"],["c_id"=>"IN","s_id"=>"6","s_nm"=>"Gujarat"],["c_id"=>"IN","s_id"=>"7","s_nm"=>"Haryana"],["c_id"=>"IN","s_id"=>"8","s_nm"=>"Himachal Pradesh"],["c_id"=>"IN","s_id"=>"9","s_nm"=>"Jammu und Kashmir"],["c_id"=>"IN","s_id"=>"10","s_nm"=>"Karnataka"],["c_id"=>"IN","s_id"=>"11","s_nm"=>"Kerala"],["c_id"=>"IN","s_id"=>"12","s_nm"=>"Madhya Pradesh"],["c_id"=>"IN","s_id"=>"13","s_nm"=>"Maharashtra"],["c_id"=>"IN","s_id"=>"14","s_nm"=>"Manipur"],["c_id"=>"IN","s_id"=>"15","s_nm"=>"Megalaya"],["c_id"=>"IN","s_id"=>"16","s_nm"=>"Mizoram"],["c_id"=>"IN","s_id"=>"17","s_nm"=>"Nagaland"],["c_id"=>"IN","s_id"=>"18","s_nm"=>"Orissa"],["c_id"=>"IN","s_id"=>"19","s_nm"=>"Punjab"],["c_id"=>"IN","s_id"=>"20","s_nm"=>"Rajasthan"],["c_id"=>"IN","s_id"=>"21","s_nm"=>"Sikkim"],["c_id"=>"IN","s_id"=>"22","s_nm"=>"Tamil Nadu"],["c_id"=>"IN","s_id"=>"23","s_nm"=>"Tripura"],["c_id"=>"IN","s_id"=>"24","s_nm"=>"Uttar Pradesh"],["c_id"=>"IN","s_id"=>"25","s_nm"=>"West Bengal"],["c_id"=>"IN","s_id"=>"26","s_nm"=>"Andaman und Nico.In."],["c_id"=>"IN","s_id"=>"27","s_nm"=>"Chandigarh"],["c_id"=>"IN","s_id"=>"28","s_nm"=>"Dadra und Nagar Hav."],["c_id"=>"IN","s_id"=>"29","s_nm"=>"Daman und Diu"],["c_id"=>"IN","s_id"=>"30","s_nm"=>"Delhi"],["c_id"=>"IN","s_id"=>"31","s_nm"=>"Lakshadweep"],["c_id"=>"IN","s_id"=>"32","s_nm"=>"Pondicherry"],["c_id"=>"IN","s_id"=>"33","s_nm"=>"Chhaattisgarh"],["c_id"=>"IN","s_id"=>"34","s_nm"=>"Jharkhand"],["c_id"=>"IN","s_id"=>"35","s_nm"=>"Uttaranchal"],["c_id"=>"IN","s_id"=>"AN","s_nm"=>"Andaman und Nico.In."],["c_id"=>"IN","s_id"=>"AP","s_nm"=>"Andra Pradesh"],["c_id"=>"IN","s_id"=>"AR","s_nm"=>"Arunachal Pradesh"],["c_id"=>"IN","s_id"=>"AS","s_nm"=>"Assam"],["c_id"=>"IN","s_id"=>"BR","s_nm"=>"Bihar"],["c_id"=>"IN","s_id"=>"CH","s_nm"=>"Chandigarh"],["c_id"=>"IN","s_id"=>"CT","s_nm"=>"Chhaattisgarh"],["c_id"=>"IN","s_id"=>"DD","s_nm"=>"Daman und Diu"],["c_id"=>"IN","s_id"=>"DL","s_nm"=>"Delhi"],["c_id"=>"IN","s_id"=>"DN","s_nm"=>"Dadra und Nagar Hav."],["c_id"=>"IN","s_id"=>"FF","s_nm"=>"Chennai"],["c_id"=>"IN","s_id"=>"GA","s_nm"=>"Goa"],["c_id"=>"IN","s_id"=>"GJ","s_nm"=>"Gujarat"],["c_id"=>"IN","s_id"=>"HP","s_nm"=>"Himachal Pradesh"],["c_id"=>"IN","s_id"=>"HR","s_nm"=>"Haryana"],["c_id"=>"IN","s_id"=>"JH","s_nm"=>"Jharkhand"],["c_id"=>"IN","s_id"=>"JK","s_nm"=>"Jammu und Kashmir"],["c_id"=>"IN","s_id"=>"KA","s_nm"=>"Karnataka"],["c_id"=>"IN","s_id"=>"KL","s_nm"=>"Kerala"],["c_id"=>"IN","s_id"=>"LD","s_nm"=>"Lakshadweep"],["c_id"=>"IN","s_id"=>"MH","s_nm"=>"Maharashtra"],["c_id"=>"IN","s_id"=>"ML","s_nm"=>"Megalaya"],["c_id"=>"IN","s_id"=>"MN","s_nm"=>"Manipur"],["c_id"=>"IN","s_id"=>"MP","s_nm"=>"Madhya Pradesh"],["c_id"=>"IN","s_id"=>"MZ","s_nm"=>"Mizoram"],["c_id"=>"IN","s_id"=>"NL","s_nm"=>"Nagaland"],["c_id"=>"IN","s_id"=>"OR","s_nm"=>"Orissa"],["c_id"=>"IN","s_id"=>"PB","s_nm"=>"Punjab"],["c_id"=>"IN","s_id"=>"PY","s_nm"=>"Pondicherry"],["c_id"=>"IN","s_id"=>"RJ","s_nm"=>"Rajasthan"],["c_id"=>"IN","s_id"=>"SK","s_nm"=>"Sikkim"],["c_id"=>"IN","s_id"=>"TN","s_nm"=>"Tamil Nadu"],["c_id"=>"IN","s_id"=>"TR","s_nm"=>"Tripura"],["c_id"=>"IN","s_id"=>"UL","s_nm"=>"Uttaranchal"],["c_id"=>"IN","s_id"=>"UP","s_nm"=>"Uttar Pradesh"],["c_id"=>"IN","s_id"=>"WB","s_nm"=>"West Bengal"],["c_id"=>"SG","s_id"=>"SG","s_nm"=>"Singapore"],["c_id"=>"MY","s_id"=>"JOH","s_nm"=>"Johor"],["c_id"=>"MY","s_id"=>"KED","s_nm"=>"Kedah"],["c_id"=>"MY","s_id"=>"KEL","s_nm"=>"Kelantan"],["c_id"=>"MY","s_id"=>"KUL","s_nm"=>"Kuala Lumpur"],["c_id"=>"MY","s_id"=>"LAB","s_nm"=>"Labuan"],["c_id"=>"MY","s_id"=>"MEL","s_nm"=>"Melaka"],["c_id"=>"MY","s_id"=>"PAH","s_nm"=>"Pahang"],["c_id"=>"MY","s_id"=>"PEL","s_nm"=>"Perlis"],["c_id"=>"MY","s_id"=>"PER","s_nm"=>"Perak"],["c_id"=>"MY","s_id"=>"PIN","s_nm"=>"Pulau Pinang"],["c_id"=>"MY","s_id"=>"PSK","s_nm"=>"Wil. Persekutuan"],["c_id"=>"MY","s_id"=>"SAB","s_nm"=>"Sabah"],["c_id"=>"MY","s_id"=>"SAR","s_nm"=>"Sarawak"],["c_id"=>"MY","s_id"=>"SEL","s_nm"=>"Selangor"],["c_id"=>"MY","s_id"=>"SER","s_nm"=>"Negeri Sembilan"],["c_id"=>"MY","s_id"=>"TRE","s_nm"=>"Trengganu"],["c_id"=>"AU","s_id"=>"ACT","s_nm"=>"Aust Capital Terr"],["c_id"=>"AU","s_id"=>"NSW","s_nm"=>"New South Wales"],["c_id"=>"AU","s_id"=>"NT","s_nm"=>"Northern Territory"],["c_id"=>"AU","s_id"=>"QLD","s_nm"=>"Queensland"],["c_id"=>"AU","s_id"=>"SA","s_nm"=>"South Australia"],["c_id"=>"AU","s_id"=>"TAS","s_nm"=>"Tasmania"],["c_id"=>"AU","s_id"=>"VIC","s_nm"=>"Victoria"],["c_id"=>"AU","s_id"=>"WA","s_nm"=>"Western Australia"]);
        
        $decoded_countries = array(["c_id"=>"IN","c_nm"=>"India"],["c_id"=>"SG","c_nm"=>"Singapore"],["c_id"=>"MY","c_nm"=>"Malaysia"],["c_id"=>"AU","c_nm"=>"Australia"]);

        $test = array(["c_id" =>"IN","c_nm" =>"India"]);

         $response = [
                'state' => $decoded_states,
                'countries' => $decoded_countries
            ];
                return $response;  
    }

     public function showraisecomplaints() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
          
        
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
               $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
             $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
            $getnoc = DB::connection('mysql3')->table('noc')->get();
             foreach ($getcustomerdata as $value) {
                 if ($value->valid == 2) {
                      $response = [
                'error' => 'Not Valid to raise complaints',
            ];
                return $response;  
                 }
                 $response['customer_details'] = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager,
            ];

             }

              foreach ($getproject as $valueproj) {
                 $response['projectnames'][] = [
                'customerno' => $customerid,
                'projectname' => $valueproj->pname,
                'projid' => $valueproj->project_id,
                'unit_name' => $valueproj->unit_nm,
                'unit_id' => $valueproj->unit,
            ];

             }

              foreach ($getnoc as $valuenoc) {
                 $response['natureofcomplaints'][] = [
                'noc' => $valuenoc->natureofcomplaint,
                
            ];

             }
             
                return $response;
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }

    public function postraisecomplaints() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
               $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
             $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
           
            foreach ($getcustomerdata as $value) {
                 if ($value->valid == 2) {
                      $response = [
                'error' => 'Not Valid to raise complaints',
            ];
                return $response;  
                 }
                }

            $errors = array();
          $complaintprojectplantcode = isset($_POST['complaintprojectplantcode'])? $_POST['complaintprojectplantcode']: '';
          $complaintunit = isset($_POST['complaintunit'])? $_POST['complaintunit']: '';
          $complaintnature = isset($_POST['complaintnature'])? $_POST['complaintnature']: '';
          $desccomp = isset($_POST['desccomp'])? $_POST['desccomp']: '';
              

     if (empty($complaintprojectplantcode)) {  $errors['msg']['complaintprojectplantcode'][] = "Plant Code is required.";   }
     if (empty($complaintunit)) {  $errors['msg']['complaintunit'][] = "Unit Code is required.";   }
     if (empty($complaintnature)) {  $errors['msg']['complaintnature'][] = "Nature Of Complaint is required.";   }
     if (empty($desccomp)) {  $errors['msg']['desccomp'][] = "Complaint description is required.";   }
     if (strlen($desccomp) > 900) {  $errors['msg']['desccomp'][] = "Complaint description characters cannot exceed 900.";   }
    
         
        if (!empty($errors)) {
        return Response::json($errors);     
        }




            $projectname = '';
            $unitname = ''; 

             if (!empty($getproject)) {
                foreach ($getproject as $pvalue) {
                    
                    if(($pvalue->project_id == $complaintprojectplantcode)&&($pvalue->unit == $complaintunit))
                    {
                        $projectname = $pvalue->pname;
                        $unitname = $pvalue->unit_nm; 
                    }
                }
            }

            if (($projectname != '')&&($unitname != '')) {
                
            
            $now = Carbon::now();
            $SavecustomertoSAP = $this->savecomplaint($customerid, $complaintprojectplantcode, $complaintunit,
             $complaintnature, $desccomp  );
                        
            DB::connection('mysql3')->table('complaints')->insert(['complaint_no' => $SavecustomertoSAP['Compliant_no'],
            'project' => $projectname,
            'unit' => $unitname,
            'customer_id' => $customerid,
            'nature' => $complaintnature,
            'description' => $desccomp,
            'vgn_status' => 'OPEN',
            'cust_status' => 'OPEN',
            'final_status' => 'OPEN',
            'vgn_remarks' => null,
             'date' => date('Y-m-d'),
             'created' => $now,
             'updated' => $now,
             'Expecteddateofcomp' => null ]);


             $response = [
                'success' => "Complaint Registered Successfully! Your Complaint ID is: ".$SavecustomertoSAP['Compliant_no'],
                'status_code' => 200
            ];
                return $response;

            }else{
             
                
                 $response = [
                'success' => "Project name and unit not found",
                'status_code' => 204
            ];
                return $response;
            }

                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }


    public function closeraisecomplaints() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
             $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
           
            foreach ($getcustomerdata as $value) {
                 if ($value->valid == 2) {
                      $response = [
                'error' => 'Not Valid to raise complaints',
            ];
                return $response;  
                 }
                }

            $errors = array();
          $complaintcode = isset($_POST['complaintcode'])? $_POST['complaintcode']: '';              

     if (empty($complaintcode)) {  $errors['msg']['complaintcode'][] = "Complaint Code is required.";   }
         
        if (!empty($errors)) {
        return Response::json($errors);     
        }


            $now = Carbon::now();
            $checkcomplaint = DB::connection('mysql3')->table('complaints')->where('customer_id', '=', $customerid)->where('complaint_no', '=', $complaintcode)->where('cust_status', '=', 'OPEN')->count();
            
            if ($checkcomplaint == 1) {

               $Closecustomercomplaint = $this->closecomplaint($customerid, $complaintcode); 

               if ($Closecustomercomplaint['Status_Note']=="CLOSED") {
                   DB::connection('mysql3')->table('complaints')->where('customer_id','=', $customerid)->where('complaint_no','=',$complaintcode)->update(['cust_status' => 'CLOSE', 'updated' => $now]);
                   
                     $response = [
                'success' => "Complaint no ".$complaintcode." Closed Successfully!",
                'status_code' => 200
            ];
                return $response;
               }
                
            }
            else{
                  $response = [
                'success' => "Complaint no ".$complaintcode." Closed Already!",
                'status_code' => 200
            ];
                return $response;
            }


         

                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }


    public function showcomplaints() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                 $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }

              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
             $getcomplaints = DB::connection('mysql3')->table('complaints')->where('customer_id', '=', $customerid)->orderBy('updated', 'desc')->get();
             foreach ($getcustomerdata as $value) {
                 $validtoraisecomplaints = 'Valid';
                   if ($value->valid == 2) {
                    $validtoraisecomplaints = 'Not Valid';
                 }
                 $response['customer_details'] = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager,
                'validtoraisecomplaints' => $validtoraisecomplaints
            ];
             }

             if (count($getcomplaints) != 0) {
                  foreach ($getcomplaints as $valuecomp) {
                 $response['customer_complaints'][] = [
                'customerno' => $customerid,
                'complaint_no' => $valuecomp->complaint_no,
                'project_name' => $valuecomp->project,
                'unit_name' => $valuecomp->unit,
                'natureofcomplaint' => $valuecomp->nature,
                'description' => $valuecomp->description,
                'vgn_status' => $valuecomp->vgn_status,
                'cust_status' => $valuecomp->cust_status,
                'final_status' => $valuecomp->final_status,
                'vgn_remarks' => $valuecomp->vgn_remarks,
                'date' => $valuecomp->date,
                'date' => $valuecomp->date,
                'date' => $valuecomp->date,
                'expected_date_of_completion' => $valuecomp->Expecteddateofcomp


            ];
             }
             }
             else{
                 $response['customer_complaints'] = [];
             }

               
             
                return $response;
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }


     public function paymenthistory() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
          
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
            $payment = DB::connection('mysql3')->table('payments')->where('cust_id', '=', $customerid)->get();
             foreach ($getcustomerdata as $value) {
                 $response['customer_details'] = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager
            ];
             }

             if (count($payment) != 0) {
                  foreach ($payment as $valuecomp) {
                 $response['paymenthistory'][] = [
                'customerno' => $customerid,
                'document_no' => $valuecomp->doc_no,
                'invoice_amt' => $valuecomp->inv_amt,
                'payment_type' => $valuecomp->pay_type,
        

            ];
             }
             }
             else{
                 $response['paymenthistory'][] = [];
             }

               
             
                return $response;
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }

    public function paymenthistorynew() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
          
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
            $payment = DB::connection('mysql3')->table('payments')->where('cust_id', '=', $customerid)->get();
             foreach ($getcustomerdata as $value) {
                 $response['customer_details'] = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager,
                'netamount' => $value->net_amt
            ];
             }

             if (count($payment) != 0) {
                  foreach ($payment as $valuecomp) {
                 $response['paymenthistory'][] = [
                'customerno' => $customerid,
                'posteddate' => $valuecomp->posteddate,
                'document_no' => $valuecomp->doc_no,
                'invoice_amt' => $valuecomp->inv_amt,
                'payment_type' => $valuecomp->pay_type,
        

            ];
             }
             }
             else{
                 $response['paymenthistory'][] = [];
             }

               
             
                return $response;
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }

    public function projectstatus() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                 $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
            $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();

             foreach ($getcustomerdata as $value) {
                 $response['customer_details'] = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager
            ];
             }

             if (count($projects) != 0) {
                  foreach ($projects as $pro) {
                      $trimmed = trim(strtolower(str_replace("VGND", "", $pro->pname)));
                      $changename = str_replace(" ","_", $trimmed);

                 $response['projectstatus'][] = [
                'customerno' => $customerid,
                'projectlink' => $pro->projectlink,
                'projectname' => $trimmed,        

            ];
             }
             }
             else{
                 $response['projectstatus'][] = [];
             }

               
             
                return $response;
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }


     public function showcreatesnag() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
            $getproject = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();

              if(count($getproject) > 0){
									$valid = 0;
									$overallsnagperproject_created = 0;
									 
									foreach($getproject as $pro){
										if($pro->snagcreatedbyuser != null)
                                        {
											$overallsnagperproject_created +=  1;
										}

										 if(($pro->milestone == 'X')&&($pro->posession == ''))
                                         {
										 $valid +=  1;
                                         }
									}

                                    

									if($valid == 0)
                                    {
                                        
										$createsnag1 = 'Not valid';
                                    }
                                    if($valid > 0)
                                    {
										$createsnag1 = 'Valid';
                                    }	
									

									if($overallsnagperproject_created != 0){
									$createsnag2 = 'Not valid';
                                    }
                                    if($overallsnagperproject_created == 0){
									$createsnag2 = 'Valid';
                                    }

                                    if (($createsnag1 == 'Not valid') || ($createsnag2 == 'Not valid')) {
                                        $createsnag ='Not valid';
                                    }
                                    else{
                                        $createsnag ='Valid';
                                    }		
									
								}


             foreach ($getcustomerdata as $value) {
                  if($value->valid == 2){
                $response = [
                'error' => 'Not valid to create Snag Points',
                'status_code' => 204
            ];
                return $response;
            }
                 $response['customer_details'][] = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager,
                'overallcreatesnagvalid' => $createsnag
            ];
             }

             foreach ($getproject as $valueproj) {
                 $response['projectnames'][] = [
                'customerno' => $customerid,
                'projectname' => $valueproj->pname,
                'projid' => $valueproj->project_id,
                'unit_name' => $valueproj->unit_nm,
                'unit_id' => $valueproj->unit,
            ];

             }

               
             
                return $response;
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }

     public function postcreatesnag() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
           $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();

             foreach ($getcustomerdata as $value) {
                  if($value->valid == 2){
                $response = [
                'error' => 'Not valid to create Snag Points',
                'status_code' => 204
            ];
                return $response;
            }
             }


             $errors = array();
          $createsnagprojectid = isset($_POST['projectid'])? $_POST['projectid']: '';
          $createsnagunitno = isset($_POST['unitno'])? $_POST['unitno']: '';
          $snagdesc = isset($_POST['snag_desc'])? $_POST['snag_desc']: '';
          $snagpresent = 0;
          foreach ($snagdesc as $value) {
              if ($value != '') {
                  $snagpresent += 1;
              }
          }
          

     if (empty($createsnagprojectid)) {  $errors['msg']['projectid'][] = "ProjectID is required.";   }
     if (empty($createsnagunitno)) {  $errors['msg']['unitno'][] = "Unit No is required.";   }
     if ($snagpresent == 0) {  $errors['msg']['snag_desc'][] = "Snag Description cannot be empty. Atleast one snag is required!";   }
   
         
        if (!empty($errors)) {
        return Response::json($errors);     
        }

           $now = Carbon::now();
           
                $date = Carbon::parse($now)->format('Y-m-d');
                $time = Carbon::parse($now)->format('H:i:s');
                
                $count = 0;
                foreach($snagdesc as $v){
               
               if(!empty($v)){
                   $rmdate = str_replace("-","",$date);
                   $rmtime = str_replace(":","",$time);

                $insertsnag = $this->insert_inspection_snag($v,'',$rmdate, $rmtime, $customerid, $createsnagunitno, $createsnagprojectid, 0); 

                if($insertsnag['Status'] == 'Snag Created Sucessfully')
                {
                    $count += 1;
                DB::connection('mysql3')->table('inspection_snag')->insert(['cust_id' => $customerid,
            'project_id' => $createsnagprojectid,
            'unit_no' => $createsnagunitno,
            'snag_desc' => $v,
            'uniqueno' => null,
            'snag_created_date' => $date.' '.$time,
            'vgn_status' => 'OPEN',
            'Expecteddateofcomp' => null ]);

                }

               }
            }

            DB::connection('mysql3')->table('projects')->where('cust_id','=',$customerid)->where('project_id','=',$createsnagprojectid)->where('unit','=',$createsnagunitno)->update(['snagcreatedbyuser' => $count]);

             $response = [
                'success' => 'Snag Created Sucessfully',
                'status_code' => 200
            ];
                return $response;

                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }


 public function showsnag() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
              $snag = DB::connection('mysql3')->table('inspection_snag')->where('cust_id', '=', $customerid)->orderBy('snag_created_date', 'asc')->get();

              $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
              if(count($projects) > 0){
									$valid = 0;
									$overallsnagperproject_created = 0;
									 
									foreach($projects as $pro){
										if($pro->snagcreatedbyuser != null)
                                        {
											$overallsnagperproject_created +=  1;
										}

										 if(($pro->milestone == 'X')&&($pro->posession == ''))
                                         {
										 $valid +=  1;
                                         }
									}

									if($valid == 0)
                                    {
										$createsnag1 = 'Not valid';
                                    }
                                    if($valid > 0)
                                    {
										$createsnag1 = 'Valid';
                                    }	
									

									if($overallsnagperproject_created != 0){
									$createsnag2 = 'Not valid';
                                    }
                                    if($overallsnagperproject_created == 0){
									$createsnag2 = 'Valid';
                                    }	


                                     if (($createsnag1 == 'Not valid') || ($createsnag2 == 'Not valid')) {
                                        $createsnag ='Not valid';
                                    }
                                    else{
                                        $createsnag ='Valid';
                                    }	
									
								}
           
             foreach ($getcustomerdata as $value) {

                 $response['customer_details'][] = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager,
                'overallcreatesnagvalid' => $createsnag
            ];
             }


             if (count($snag) > 0) {
            foreach ($snag as $keypop => $valuepop) {
                
            
                 $getsnag = $this->get_inspection_snag($customerid, $valuepop->unit_no, $valuepop->project_id); 
                 
                 if (count($getsnag['Data']) != 0) {
                     
                     foreach ($getsnag['Data'] as $key => $value) {
                         if ($value['Indicator'] == 'X') {
                             $status = 'CLOSED';
                         }
                         else{
                             $status = 'OPEN';
                         }
                    $dt = substr($value['Created_Date'],0,4).'-'.substr($value['Created_Date'],4,2).'-'.substr($value['Created_Date'],6,2);
                    $expecteddate = substr($value['Expected_Date'],0,4).'-'.substr($value['Expected_Date'],4,2).'-'.substr($value['Expected_Date'],6,2);
                    $tm = substr($value['Time'],0,2).':'.substr($value['Time'],2,2).':'.substr($value['Time'],4,2);

                    $newdtime = $dt.' '.$tm;
                    
                    
                       $dd =  DB::connection('mysql3')->table('inspection_snag')->where('cust_id','=',$customerid)->where('project_id','=',$value['Plant_code'])
                         ->where('unit_no','=',$value['Unit_no'])
                         ->where('snag_desc','=',$value['Inspection_Snag'])
                         ->where('snag_created_date','=',$newdtime)
                         ->update(['uniqueno' => $value['Unique_No'], 'vgn_status' => $status, 'Expecteddateofcomp' => $expecteddate]);
                         
                         
                     }
                 }
                

            }
           }

        


        if((count($projects) > 0)&&(count($snag) > 0))
        {
			foreach($projects as $proj){
                
                if($proj->snagcreatedbyuser != null){


                    $overall = 0;
					foreach ($snag as $value) {
					if (($value->project_id == $proj->project_id)&&($value->unit_no == $proj->unit)) {
						if ($value->vgn_status == 'OPEN') {
								$overall += 1;	
							}
						}
												
					}
                    $vgnstatus = 'OPEN';
					if ($overall == 0) {
							$vgnstatus = 'CLOSED';
							}
						if ($overall > 0) {
							$vgnstatus = 'OPEN';
					}

                    foreach ($snag as $value1) {
				if (($value1->project_id == $proj->project_id)&&($value1->unit_no == $proj->unit)) {
							$snagcreated_date = $value1->snag_created_date;
						}
					break;																
				}

                foreach ($snag as $value2) {
					if (($value2->project_id == $proj->project_id)&&($value2->unit_no == $proj->unit)) {
																

						$date=date_create($value2->snag_created_date);
						date_add($date,date_interval_create_from_date_string("1 days"));
						$converteddate = date_format($date,"Y-m-d H:i:s");
						$todaydatetime = date('Y-m-d H:i:s');
																
							if ($todaydatetime > $converteddate) {
								$updatelink = 'no';
							}
							else
							{
                                $updatelink = 'yes';
					}												
					}
						break;																
					}


                    if($snag[0]->Expecteddateofcomp != null){
						$expecteddate = $snag[0]->Expecteddateofcomp;
                            }
					else{
						$expecteddate = '-';
                        }
                  

                     $response['snagpoints'][] = [
                         'customer_id' => $customerid,
                         'project_name' => $proj->pname,
                         'unit_name' => $proj->unit_nm,
                         'project_id' => $proj->project_id,
                         'unit_id' => $proj->unit,
                         'vgn_status' => $vgnstatus,
                         'snag_created_date' => $snagcreated_date,
                         'updatelink'  => $updatelink,
                         'expecteddateofcompletion' => $expecteddate
                     ];							

															
									}
								}

                                foreach ($snag as $snagvalue) {
                                     $response['snagpoints']['overallsnagpoints'][] = [
                         'points' => $snagvalue->snag_desc
                         
                     ];
                                }
							}
                            else{
                                $response['snagpoints'][] = null;
                                $response['snagpoints']['overallsnagpoints'] = [];
                            }

 
           return $response;

                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }

    public function showupdatesnag() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
              

           
               $errors = array();
          $inspectionprojectplantcode = isset($_POST['plantcode'])? $_POST['plantcode']: '';
          $inspectionunit = isset($_POST['unit'])? $_POST['unit']: '';
              

     if (empty($inspectionprojectplantcode)) {  $errors['msg']['plantcode'][] = "Plant Code is required.";   }
     if (empty($inspectionunit)) {  $errors['msg']['unit'][] = "Unit Code is required.";   }
     
         
        if (!empty($errors)) {
        return Response::json($errors);     
        }

            $snag = DB::connection('mysql3')->table('inspection_snag')->where('cust_id', '=', $customerid)->where('project_id', '=', $inspectionprojectplantcode)->where('unit_no', '=', $inspectionunit)->orderBy('snag_created_date', 'asc')->get();
             $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
              if(count($projects) > 0){
									$valid = 0;
									$overallsnagperproject_created = 0;
									 
									foreach($projects as $pro){
										if($pro->snagcreatedbyuser != null)
                                        {
											$overallsnagperproject_created +=  1;
										}

										 if(($pro->milestone == 'X')&&($pro->posession == ''))
                                         {
										 $valid +=  1;
                                         }
									}

									if($valid == 0)
                                    {
										$createsnag1 = 'Not valid';
                                    }
                                    if($valid > 0)
                                    {
										$createsnag1 = 'Valid';
                                    }	
									

									if($overallsnagperproject_created != 0){
									$createsnag2 = 'Not valid';
                                    }
                                    if($overallsnagperproject_created == 0){
									$createsnag2 = 'Valid';
                                    }	

                                     if (($createsnag1 == 'Not valid') || ($createsnag2 == 'Not valid')) {
                                        $createsnag ='Not valid';
                                    }
                                    else{
                                        $createsnag ='Valid';
                                    }	
									
								}
             foreach ($getcustomerdata as $value) {

                 $response['customer_details'][] = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager,
                'overallcreatesnagvalid' => $createsnag
            ];
             }

              if(count($snag) != 0){
                    $overallstatusforupdate = 0;
                foreach ($snag as $keynew => $valuenew) {
                    $date=date_create($valuenew->snag_created_date);
					date_add($date,date_interval_create_from_date_string("1 days"));
					$converteddate = date_format($date,"Y-m-d H:i:s");
    				$todaydatetime = date('Y-m-d H:i:s');
            		if ($todaydatetime > $converteddate) {                       
                         $response = [
                'error' => 'Snag Updation time limit exceeded!',
                'status_code' => 204
            ];
                return $response;

						}
                    break;
                }

                foreach ($snag as $keynew => $valuenew) {
                    if($valuenew->vgn_status == 'OPEN')
                    {
                        $overallstatusforupdate += 1;
                    }
                }

                if ($overallstatusforupdate == 0) {
            $response = [
                'error' => 'All Snags are closed for this Unit',
                'status_code' => 204
            ];
                return $response;
                }

                 $getsnag = $this->get_inspection_snag($customerid, $inspectionunit, $inspectionprojectplantcode); 
                 
                 if (count($getsnag['Data']) != 0) {
                     
                     foreach ($getsnag['Data'] as $key => $value) {
                         if ($value['Indicator'] == 'X') {
                             $status = 'CLOSED';
                         }
                         else{
                             $status = 'OPEN';
                         }
                    $dt = substr($value['Created_Date'],0,4).'-'.substr($value['Created_Date'],4,2).'-'.substr($value['Created_Date'],6,2);
                    $expecteddate = substr($value['Expected_Date'],0,4).'-'.substr($value['Expected_Date'],4,2).'-'.substr($value['Expected_Date'],6,2);
                    $tm = substr($value['Time'],0,2).':'.substr($value['Time'],2,2).':'.substr($value['Time'],4,2);

                    $newdtime = $dt.' '.$tm;
                    
                    
                       $dd =  DB::connection('mysql3')->table('inspection_snag')->where('cust_id','=',$customerid)->where('project_id','=',$value['Plant_code'])
                         ->where('unit_no','=',$value['Unit_no'])
                         ->where('snag_desc','=',$value['Inspection_Snag'])
                         ->where('snag_created_date','=',$newdtime)
                         ->update(['uniqueno' => $value['Unique_No'], 'vgn_status' => $status, 'Expecteddateofcomp' => $expecteddate]);
                         
                         
                     }
                 }


                 foreach ($snag as $snagvalue) {
                     $response['updatesnag_details'][] = [
                'customerno' => $customerid,
                'projectid' => $snagvalue->project_id,
                'unitid' => $snagvalue->unit_no,
                'snag_description' => $snagvalue->snag_desc,
                'unique_no' => $snagvalue->uniqueno,
                'vgn_status' => $snagvalue->vgn_status

            ];
                }

                return $response;
            }
            else
            {
                $response = [
                'error' => 'Invalid Snag details',
                'status_code' => 204
            ];
                return $response;
            }




 
           

                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }

     public function postupdatesnag() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
              $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();
            

                $snagdesc = isset($_POST['snag_desc'])? $_POST['snag_desc']: '';
          $snagpresent = 0;
          foreach ($snagdesc as $keys => $values) {
              if ($values != '') {
                  $snagpresent += 1;
              }
          }
               
     if ($snagpresent == 0) {  $errors['msg']['snag_desc'][] = "Snag Description cannot be empty. Atleast one snag is required!";   }
   
         
        if (!empty($errors)) {
        return Response::json($errors);     
        }

        
             //dd($request['snag']); 
           $check =count($snagdesc);
            
           if ($check != 0) {
               
               foreach ($snagdesc as $key => $value) {
                   
                   
                    $kk = 0;
                   $gettobeupdatedsnag = DB::connection('mysql3')->table('inspection_snag')
                   ->where('cust_id', '=', $customerid)
                   ->where('uniqueno', '=', $key)
                   ->where('vgn_status', '=','OPEN')
                   ->get();

                   
                    if(count($gettobeupdatedsnag) > 0){
                        
                        foreach ($gettobeupdatedsnag as $keypro => $valpro) {
                            
                            $splitdatetime = explode(" ",$valpro->snag_created_date);
                            
                            $rmdate = str_replace("-","",$splitdatetime[0]);
                            $rmtime = str_replace(":","",$splitdatetime[1]);
                            if ($valpro->vgn_status == 'OPEN') {
                                $indicator = '';
                            }
                            if ($valpro->vgn_status == 'CLOSED') {
                                $indicator = 'X';
                            }
                            
                            $insertsnag = $this->insert_inspection_snag($value,$indicator,$rmdate, $rmtime, $customerid, $valpro->unit_no, $valpro->project_id, $valpro->uniqueno);             
                            
                            if ($insertsnag['Status'] == 'Snag Created Sucessfully') {
                                $kk++;
                                DB::connection('mysql3')->table('inspection_snag')
                   ->where('cust_id', '=', $customerid)
                   ->where('uniqueno', '=', $key)
                   ->where('vgn_status', '=','OPEN')
                   ->update(['snag_desc' => $value]);
                            }
                            
                        }
                    }
                
               }

               
                if ($kk > 0) {
                       $response = [
                'success' => 'Snags Updated Successfully!',
                'status_code' => 200
            ];
                return $response;
                }
                else{
                     $response = [
                'error' => 'Snags not Updated',
                'status_code' => 204
            ];
                return $response;
                }
            
           }
           else
           {
               
                $response = [
                'error' => 'All Snags are closed for this Unit',
                'status_code' => 204
            ];
                return $response;
           }
           
                          

                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }

    public function showreferafriend() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
             
             foreach ($getcustomerdata as $value) {
                 $response['customer_details'] = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager,
            ];
             }


             $getunsold = $this->getUnsold($customerid);
           $ongoingprojects = $getunsold['UNSOLD_PROJECTS'];
           
           foreach ($ongoingprojects as $k => $valuesnew) {
              $response['project_list'][] = [
                'projectname' => $valuesnew['Project_Name'],
                'projectid' => $valuesnew['Project_No']
                
            ];
               
           }
           
             
                return $response;
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }

    public function postshowreferafriend() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                 $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
             
          
               $errors = array();
          $name = isset($_POST['name'])? $_POST['name']: '';
          $mobileno = isset($_POST['mobileno'])? $_POST['mobileno']: '';
          $emailid = isset($_POST['emailid'])? $_POST['emailid']: '';
          $intrestedproject = isset($_POST['intrestedproject'])? $_POST['intrestedproject']: '';
         
          

     if (empty($name)) {  $errors['msg']['name'][] = "Name field is required.";   }
     if (empty($mobileno)) {  
         
         $errors['msg']['mobileno'][] = "Mobile No field is required.";   
    }
    if (!empty($mobileno)) {  
        if (ctype_digit($mobileno)) {
            if (strlen($mobileno) != 10) {
                $errors['msg']['mobileno'][] = "Mobile No field must be 10 digit.";
            }
        }
        else{
            $errors['msg']['mobileno'][] = "Mobile No field must be numeric.";
        }
         
         
    }
     
     if (empty($emailid)) {  $errors['msg']['emailid'][] = "Email-ID field is required.";   }
     if (empty($intrestedproject)) {  $errors['msg']['intrestedproject'][] = "Intrested Project field is required.";   }
   
   if (!empty($emailid)) {
       
        if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {               
            $errors['msg']['emailid'][] = "Not a valid Email address"; 
        }
   }

   if (!empty($intrestedproject)) {
       $valid = 0;
        $getunsold = $this->getUnsold($customerid);
           $ongoingprojects = $getunsold['UNSOLD_PROJECTS'];
           
           foreach ($ongoingprojects as $k => $valuesnew) {
            if ($valuesnew['Project_No'] == $intrestedproject) {
                $valid = 1;
            }
               
           }

           if ($valid == 0) {
               $errors['msg']['intrestedproject'][] = "Not a valid Intrested Project"; 
           }
   }
         
        if (!empty($errors)) {
        return Response::json($errors);     
        }



                       
            $insertreferfriend = $this->sappostreferFriend($customerid,$name, $emailid, $mobileno, $intrestedproject);
            //dd($insertreferfriend);
           
            if ($insertreferfriend['Save_Note'] == 'Referal Accepted Successfully') {
             
                $response = [
                'success' => 'Referal Accepted Successfully',
                'status_code' => 200
            ];
                return $response; 
            }
            else{
                $response = [
                'error' => 'Referal Not accepted try again!',
                'status_code' => 204
            ];
                return $response;  
            }           
             
                
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }


    
public function sendmail($contents)
{
    require_once('phpmailer/PHPMailerAutoload.php');
// $contents['toname']=>
// $contents['toemail']=>
// $contents['subject']=>
// $contents['content']=>
// $contents['html']=>
// $contents['att_url']=>
//Create a new PHPMailer instance
$mail = new \PHPMailer();
$return=array();
//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
// $mail->Host = 'smtp.gmail.com';
$mail->Host = 'mail.vgn.in';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
// $mail->Port = 25;

//Set the encryption system to use - ssl (deprecated) or tls
//$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "customerzone3";

//Password to use for SMTP authentication
$mail->Password = "Vgn@321";

//Set who the message is to be sent from
$mail->setFrom('customerzone3@vgn.in', 'VGN Customer Zone');

//Set an alternative reply-to address
$mail->addReplyTo('no-reply@vgn.in', 'VGN Customer Zone');

//Set who the message is to be sent to
$mail->addAddress($contents['toemail'], $contents['toname']);

//Set the subject line
$mail->Subject = $contents['subject'];

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents($contents['html']), dirname(__FILE__));
$mail->Body=$contents['content'];

//Replace the plain text body with one created manually
$mail->AltBody = $contents['content'];

//Attach an image file
if(!empty($contents['att_url']))
$mail->addAttachment($contents['att_url']);

//send the message, check for errors
if (!$mail->send()) {
// if (0) {
    $return['code']= 500;
    $return['msg']= "Mailer Error: " . $mail->ErrorInfo."";
} else {
    $return['code']= 200;
    $return['msg']= "Mail Sent to your Registered EMail!";
}
return $return;
}

    public function postforgotpassword(Request $request) {
      
      if (isset($_POST['username'])) {
          $username = $_POST['username'];
          
        
        if (strpos($username, '@') !== false) {
            $loginmode = 'loginmode_emailid';
        }
        elseif (ctype_digit($username)) {

            if (strlen($username) == 10) {
                $loginmode = 'loginmode_mobileno';
            }
            elseif((strlen($username) >= 3)&&(strlen($username) < 10)){
                $loginmode = 'loginmode_customerid';
            }
            else{
                $response = [
                'error' => 'Sorry! Enter a valid CustomerId or Mobile Number',
                'status_code' => 204
            ];
                
                return $response;
            }
                
        }
        else{
            
            $response = [
                'error' => 'Sorry! Enter a valid Username',
                'status_code' => 204
            ];
                
                return $response;
        }

        
        if ($loginmode == 'loginmode_customerid') {
            if (!ctype_digit($username)) {
                 $response = [
                'error' => 'Sorry! Enter a valid Customer Id',
                'status_code' => 204
            ];
                
                return $response;
            }
            $check = DB::connection('mysql3')->table('customer')->where(['id' => $username ])->get();
        }

        elseif ($loginmode == 'loginmode_emailid') {

            if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                 $response = [
                'error' => 'Sorry! Enter a valid Email Id',
                'status_code' => 204
            ];
                return $response;
                

                }
            $check = DB::connection('mysql3')->table('customer')->where(['email' => $username])->get();
            
        }
        
        elseif ($loginmode == 'loginmode_mobileno') {

            if (!preg_match('/^[0-9]{10}+$/', $username)) {
                
                  $response = [
                'error' => 'Sorry! Enter a valid Mobile Number',
                'status_code' => 204
            ];
                return $response;

                }
            $check = DB::connection('mysql3')->table('customer')->where(['mobile' => $username ])->get();
        }
        else{                
                 $response = [
                'error' => 'Sorry! Enter a valid Username!',
                'status_code' => 204
            ];
                return $response;
        }
         



      }
      else
      {
            $response = [
                'error' => 'Please fill all the fields!',
                'status_code' => 204
            ];
                return $response;
      }

     
           if (count($check) == 1) {
                    
            
    foreach ($check as $newkey => $newvalue) {
        
        $username = $newvalue->id;
    }



    $getcustomerdatacount = DB::connection('mysql3')->table('customer')->where('id', '=', $username)->count();

        if ($getcustomerdatacount != 0) {
            $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $username)->get();
            $getresetdata = DB::connection('mysql3')->table('resetpwd')->where('customerid', '=', $username)->get();

            if (count($getresetdata) != 0) {
                
            
            foreach ($getresetdata as $key => $value) {
                $customerid = $value->customerid;
                $pwd_token = $value->token;
                $expiredate = $value->expiredate;
            }

            $now = Carbon::now();
           
            $date1=date_create($now);
			date_add($date1,date_interval_create_from_date_string("1 days"));
			$addedexpiredate = date_format($date1,"Y-m-d H:i:s");
            //dd($addedexpiredate);

            $str = date('YmdHis').'-42'.rand(0,189999);
            $shuffled = str_shuffle($str);
            $token = $shuffled;
            foreach ($getcustomerdata as $keycustomer => $customervalue) {
                    $name = $customervalue->name;
                    $email = $customervalue->email;
                    $mobile = $customervalue->mobile;
                }
            
            if ($now > $expiredate) {
//dd($addedexpiredate);
                $updateresetpwd = DB::connection('mysql3')->table('resetpwd')->where('customerid','=',$customerid)->update(['token'=>$token,'expiredate'=>$addedexpiredate]);
                
                $link="https://vgn.in/customerzone/resetpassword/".$customerid."/".$token;
				$newmail=array();
				$newmail['toname']=$name;
				$newmail['toemail']="it4@vgn.in";
                //$newmail['toemail']=$email;
				$newmail['subject']="VGN Customer Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="https://www.vgn.in/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="https://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";
                if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				
                //$smsurl = "http://www.adithya.me/adithya/Api/?username=vgn&password=vgn@123&senderid=VGNALT&message=$smscontent&msgtype=normal&mobileno=8754404619";
                $smscontent = 'Dear Customer, Click the below link to reset your password '.$link; 
                
               $sms_status = $this->smscurl($smscontent, $mobile);               
                DB::connection('mysql3')->table('sms_sent_data')->insert(['customerid' => $customerid,'sentdatetime' => $now]);
                    }
                }

				$mailstatus = $this->sendmail($newmail);
                
				//$return="<suc>Password reset link was sent to your registered email address successfully! <debug>" . $customerid."</debug></suc><br/>".$mailstatus['msg'];
				 $response = [
                'success' => 'Dear Customer your password has been reset and sent successfully to your registered email and phone!',
                'status_code' => 200
            ];
                return $response;
                
            }
            else{
                $link="https://vgn.in/customerzone/resetpassword/".$customerid."/".$pwd_token;
				$newmail=array();
				$newmail['toname']=$name;
				//$newmail['toemail']=$email;
                $newmail['toemail']="it4@vgn.in";
				$newmail['subject']="VGN Customer Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="https://www.vgn.in/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="https://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";

                  if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br>Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';

                $smscontent = 'Dear Customer, Click the below link to reset your password '.$link;  
				
                
                $sms_status = $this->smscurl($smscontent, $mobile);
                DB::connection('mysql3')->table('sms_sent_data')->insert(['customerid' => $customerid,'sentdatetime' => $now]);
                    }
                }
				$mailstatus = $this->sendmail($newmail);
                 $response = [
                'success' => 'Dear Customer your password has been reset and sent successfully to your registered email and phone!',
                'status_code' => 200
            ];
                return $response;
            }

            
             $response = [
                'success' => 'Dear Customer your password has been reset and sent successfully to your registered email and phone!',
                'status_code' => 200
            ];
                return $response;

            }
            else{
                
                
                $str = date('YmdHis').'-19'.rand(0,189999);
                $shuffled = str_shuffle($str);
                $token = $shuffled;
                $customerid = $username;
                $now = Carbon::now();
                $date=date_create($now);
				date_add($date,date_interval_create_from_date_string("1 days"));
				$expiredate = date_format($date,"Y-m-d H:i:s");
                
                $insertresetpwd = DB::connection('mysql3')->table('resetpwd')->insert(['customerid' => $customerid, 'token'=>$token,'expiredate'=>$expiredate]);
                //$last_id = mysqli_insert_id($conn);
                foreach ($getcustomerdata as $keycustomer => $customervalue) {
                    $name = $customervalue->name;
                    $email = $customervalue->email;
                    $mobile = $customervalue->mobile;
                }
                $link="https://vgn.in/customerzone/resetpassword/".$customerid."/".$token;
				$newmail=array();
				$newmail['toname']=$name;
				//$newmail['toemail']=$email;
                $newmail['toemail']="it4@vgn.in";
				$newmail['subject']="VGN Customer Zone - Reset Password Link!";
				$newmail['content']='<div style=" margin: 0 auto;  background-color: #eef5ff;padding: 2% 4%;font-size: 14px;"><div style="text-align: center;"><img src="https://www.vgn.in/images/custom/vgn-logo.png" alt="vgn-logo.jpg"></div>Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="https://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);
				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div></div>';
				$newmail['html']="user-detail-contents.html";
				//$newmail['att_url']="images/logo.jpg";
                 if(ctype_digit($mobile)){
                    if (strlen($mobile) == 10) {
                        
                //$smscontent='Dear '.$name.',<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please <a href="'.$link.'">Click Here</a> to reset your password.<br><br>Thanks,<br>VGN<br><div style="    text-align: center;    font-size: 88%;    color: rgb(124, 124, 124);">For Any details : <a href="http://www.vgn.in">www.vgn.in</a><br><span style="    color: rgb(23, 79, 163);				font-weight: bold;">VGN Property Developers Private Limited</span>&nbsp;- No.153, Wallace Garden, 2nd Street, Nungambakkam, Chennai-600006.<br>Call Us: +91 44 4343 9900</div>';
				$smscontent = 'Dear Customer, Click the below link to reset your password '.$link; 
                $sms_status = $this->smscurl($smscontent, $mobile);
                DB::connection('mysql3')->table('sms_sent_data')->insert(['customerid' => $customerid,'sentdatetime' => $now]);
                    }
                }
				$mailstatus = $this->sendmail($newmail);
                $response = [
                'success' => 'Dear Customer your password has been reset and sent successfully to your registered email and phone!',
                'status_code' => 200
            ];
                return $response;
            }
        }






            
             }
             else{
                 $request->session()->flash("error_msg", "");
                 
                   $response = [
                'error' => 'Sorry! Username Does not Match!',
                'status_code' => 204
            ];
                return $response;
                
             }

    }



    public function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true) 
	{
		if (is_array($messageParts) || is_object($messageParts))
		{
			foreach($messageParts as $part) {
				$flattenedParts[$prefix.$index] = $part;
				if(isset($part->parts)) {
				
					if($part->type == 2) {
						$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix.$index.'.', 0, false);
					}
					elseif($fullPrefix) {
						$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix.$index.'.');
					}
					else {
						$flattenedParts = $this->flattenParts($part->parts, $flattenedParts, $prefix);
					}
					unset($flattenedParts[$prefix.$index]->parts);
				}
				$index++;
			}
		}
		return $flattenedParts;		
	}
		
	public function getPart($connection, $messageNumber, $partNumber, $encoding) {
		
		$data = imap_fetchbody($connection, $messageNumber, $partNumber);
		
		switch($encoding) {
			case 0: return $data; // 7BIT
			case 1: return imap_8bit($data); // 8BIT
			case 2: return imap_base64(imap_binary($data)); // BINARY
			case 3: return base64_decode($data)/* imap_base64($text) */; // BASE64
			case 4: return quoted_printable_decode($data); // QUOTED_PRINTABLE
			case 5: return $data; // OTHER
		}
	}
	
	public function getFilenameFromPart($part) {
		
		$filename = '';
		
		if($part->ifdparameters) {
			foreach($part->dparameters as $object) {
				if(strtolower($object->attribute) == 'filename') {
					$filename = $object->value;
				}
			}
		}
		
		if(!$filename && $part->ifparameters) {
			foreach($part->parameters as $object) {
				if(strtolower($object->attribute) == 'name') {
					$filename = $object->value;
				}
			}
		}
		
		return $filename;
		
	}

    public function communication() {
      
      if (isset($_POST['key'])) {

          $customerkey = $_POST['key'];
                  
           $check = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->count();
           if ($check == 1) {
                $getcustomer = DB::connection('mysql4')->table('customersession')->where(['sessionkey' => $customerkey])->get();
               foreach ($getcustomer as $value) {
                   $customerid = $value->customerid;
               }
              $getcustomerdata = DB::connection('mysql3')->table('customer')->where('id', '=', $customerid)->get();       
             
             foreach ($getcustomerdata as $value) {
                 $response = [
                'customerno' => $value->id,
                'name' => $value->name,
                'customerexecutive' => $value->customer_executive,
                'customermanager' => $value->customer_manager,
                             
            ];
             }


                $projects = DB::connection('mysql3')->table('projects')->where('cust_id', '=', $customerid)->get();

             $getpwdforsap = DB::connection('mysql3')->table('sapcustomer')->where('customerid', '=', $customerid)->get();
                     foreach ($getpwdforsap as $sapkey => $sapvalue) {
                         $sapcustomerid = $sapvalue->customerid;
                         $sapcustomerpassword = $sapvalue->password;
                     }

                     
         if ($sapcustomerpassword != '') {
             
           
        require_once('phpmailer/PHPMailerAutoload.php');
        
        
        $pg_s=(!empty($_POST['size']))?$_POST['size']:10;
	    $pg_no=(!empty($_POST['page']))?$_POST['page']:1;
        

		ini_set('xdebug.var_display_max_depth', 5);
		ini_set('xdebug.var_display_max_children', 256);
		ini_set('xdebug.var_display_max_data', 1024);
		// $server = '{mail.vgn.in:143/notls}INBOX';61.8.145.222
		$server = '{client.vgn.in:143/notls}INBOX';
		$login = $customerid.'@client.vgn.in';
		$password = $sapcustomerpassword;
        $pagehtml = '';
$mailarray = array();
		if($connection = @imap_open($server, $login, $password))
		{
		//var_dump($connection);
		$message_count = imap_num_msg($connection);
		$pagesize=$pg_s;
		$pages=max(($message_count%$pagesize==0)?($message_count/$pagesize):(int)($message_count/$pagesize)+1,1);
		$pagenum=$pg_no;
		$n=min($pagesize,$message_count-($pagenum*$pagesize)+$pagesize);
		
		$pagehtml .="<div><ul class='pagination'>";
		for($i=1;$i<=$pages;$i++)
		{
		$pagehtml.="<li class='paginate_button";		
		$pagehtml.=($pagenum==$i)?" active":"";
		//$pagehtml.="'><a href='?page=".$i."&size=".$pg_s."'>".$i."</a></li>";
        $pagehtml.="'><a href='/customerzone/communication/".$pg_s."/".$i."'>".$i."</a></li>";
        $mailarray['pages'][] =['pageno'=>$i,'link'=>"https://vgn.in/customerzone/communication/".$pg_s."/".$i];
		}
		$pagehtml.="</ul></div>";
		


        
		//echo '<div  class="panel-group" id="accordion">';
		for ($m = 1; $m <= $n; ++$m){
			$messageNumber=$message_count-$m+1-($pagenum*$pagesize)+$pagesize;
			// if($debug)echo $messageNumber;
			$att=0;
			$structure = imap_fetchstructure($connection, $messageNumber);
			// if($debug)echo "<br>STRUCTURE<br>";
			// if($debug)print_r($structure);
			$header = imap_header($connection, $messageNumber);
			$parts = (isset($structure->parts) ? $structure->parts : array(0=>$structure));
			if(isset($debug)) {$pagehtml .= "<br>PARTS<br>";}
			if(isset($debug)){$pagehtml .= count($parts);}
			$flattenedParts = array();
			if(count($parts))
			{
                
			$flattenedParts = $this->flattenParts($parts);
				//flattenParts($parts);
                
			}
			else{
				if(isset($parts)) $flattenedParts = self::flattenParts($parts);
				else $flattenedParts[1] = $structure;
				}
			$pagehtml .= '<div class="panel"><div class="panel-heading">';
			
			// echo '<div class="tl-row"><div class="">';
			$pagehtml .= '<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$messageNumber.'"><span style="font-size:14px;">'.date('d-m-Y',$header->udate).'</span>&nbsp;&nbsp;-&nbsp;&nbsp;'.imap_utf8($header->subject).'</a></h4>';
			//echo '<div class="panel-subtitle disabled">'.date('d-m-Y g:i A',$header->udate).'</div></div>';
			$pagehtml .= '</div>';
			$pagehtml .= '<div  id="collapse'.$messageNumber.'" class="panel-collapse collapse"><div class="panel-body">';
			
			foreach($flattenedParts as $partNumber => $part) {
				
			if(isset($debug)){ $pagehtml .= "TYPE - SUB TYPE - ENCODING<br>";}
			if(isset($debug)){ $pagehtml .= $part->type."-".$part->subtype."-".$part->encoding;	}
			if(isset($debug)){ $pagehtml .= "<br>";	}
			
				switch($part->type) {
					
					case 0:
					// the HTML or plain text part of the email
					$message = $this->getPart($connection, $messageNumber, $partNumber, $part->encoding);
 
					//if($part->subtype=='HTML'&&$debug)
					if($part->subtype=='HTML')
                   
					$pagehtml .= "<div class='html' >".nl2br($message)."</div>";
					else if($part->subtype=='PLAIN')
					$pagehtml .= "<div class='plain' >".nl2br($message)."</div>";
					// now do something with the message, e.g. render it
					break;
					
					case 1:
					// multi-part headers, can ignore
					break;
					case 2:
					// attached message headers, can ignore
					break;
					
					case 3: // application
					case 4: // audio
					case 5: // image
					case 6: // video
					case 7: // other
					$filename = $this->getFilenameFromPart($part);
					if($filename) {
						// it's an attachment
						++$att;
						$attachment = $this->getPart($connection, $messageNumber, $partNumber, $part->encoding);
						// now do something with the attachment, e.g. save it somewhere
						$cid="";
						if(isset($customerid))$cid=$customerid;
						$name = 'attachments/'.$cid.'-'.$messageNumber.'-'.$partNumber.'-'.$filename;
						file_put_contents($name, $attachment);
						// echo '<div class="float-left padding10"><h6>Attachment '.$att.'</h6><a href="'.$name . '" target="_blank" >'.$filename.'</a></div>';
                        $newname = "https://vgn.in/attachments/".$cid.'-'.$messageNumber.'-'.$partNumber.'-'.$filename;
                        $mailarray['mails'][] = [
                            'pagenoactive' => $pg_no,
                'subject' => date('d-m-Y',$header->udate).' - '.imap_utf8($header->subject),
                'body' => nl2br($message),
                'attachment'=> $newname
            ];
						$pagehtml .= '<div class="float-left padding10"><i class="glyph-icon icon-linecons-attach"></i> <a href="'.$newname . '" target="_blank" >'.$filename.'</a></div>';
					}
					else {
						$mailarray['mails'][] = [
                            'pagenoactive' => $pg_no,
                'subject' => date('d-m-Y',$header->udate).' - '.imap_utf8($header->subject),
                'body' => nl2br($message),
                'attachment' => null
            ];
					}
					break;
					
				}
				
			}
			
			// echo '<a href="#" class="expand"></a></div>';
			$pagehtml .= '</div></div></div>';
		}
		$pagehtml .= '</div>';
		
		imap_close($connection);

        return $mailarray;

	}
	else
	{
	imap_errors();
    imap_alerts();
	$pagehtml .= "<div class='alert alert-notice'>This service is temporarily unavailable!</div>";
	}
         }
         else{
             $pagehtml = "<div class='alert alert-notice'>Login to Communication Failed!</div>";
         }


             
                return $pagehtml;
                 }
                 else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
                 }
                
             }
             else{
                  $response = [
                'error' => 'No data',
                'status_code' => 204
            ];
                return $response;
             }

    }



 public function postleads() {
         if ($_POST['projectid'] == null) {
              $response = [
                'error' => 'No Project',
                'status_code' => 204
            ];
                return $response;
         }
         else{
             $projid = $_POST['projectid'];
             if (ctype_digit($projid) == false) {
                 
                  $response = [
                'error' => 'ProjectId shoulf be a number',
                'status_code' => 204
            ];
                return $response;
             }
         
          $errors = array();
          $name = isset($_POST['name'])? preg_replace("/[^A-Za-z.?! ]/","",$_POST['name']): '';
          $mobile = isset($_POST['mobile'])? $_POST['mobile']: '';
          $email = isset($_POST['email'])? $_POST['email']: '';
          $city = isset($_POST['city'])? $_POST['city']: '';
            


    if (empty($name)) {  $errors['msg']['name'][] = "Name field is required.";   }
    if (strlen($name) > 40) {  $errors['msg']['name'][] = "Name field characters should not exceed 40.";   }

    if (empty($city)) {  $errors['msg']['city'][] = "City field is required.";   }
    if (strlen($city) > 40) {  $errors['msg']['city'][] = "City field characters should not exceed 40.";   }

    if (empty($email)) {  $errors['msg']['email'][] = "Email-ID field is required.";   }
    if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors['msg']['email'][] = "Sorry! Enter a valid Email-ID.";   }
                }
    if (empty($mobile)) {  $errors['msg']['mobile'][] = "Mobile Number field is required.";   }
    if (!empty($mobile)) {
            if (ctype_digit($mobile) == false) {
          $errors['msg']['mobile'][] = "Mobile Number must be numeric.";   }
          else
          {
              if (strlen($mobile) != 10) {
                  $errors['msg']['mobile'][] = "Mobile Number must be 10 digit.";   }
              }
          }
                }
        

             if (!empty($errors)) {
        return Response::json($errors);     
        }

            
            $projects = DB::table('projectlist')->where(['Status' => 'Ongoing','id' => $projid ])->get();
            
            if (count($projects) == 0) {
                 $response = [
                'error' => 'No Projects',
                'status_code' => 204
            ];
                return $response;
            }

            foreach ($projects as $key => $value) {
                $mobile_campaigncode =  $value->mobile_campaigncode;
                $plantcode =  $value->plantcode;
                $projectname = "VGND ".$value->Project_name;
                $table_name = $mobile_campaigncode.'_'.$plantcode;
            }
            $now = date('Y-m-d H:i:s');
            $leaddttime = date('Y-m-d H:i:s');
            $addoneday = date('Y-m-d H:i:s');
            $ins = 0;
            $insweb = 0;
           
           $pid = date('Ymdhis').mt_rand(6, 1900);
            if (($mobile_campaigncode != '')&&($plantcode != '')) {

                 $data = lead_data::select('lead_datetime')->where('Source_type','=','MobileApp')->where('Project_id','=',$projid)->where('Email','=',$email)->orderBy('lead_datetime', 'desc')->first();
                    
                
                 if(!empty($data)) {
                   
                    $leadexist =$data['lead_datetime'];
                
                
                $dt = Carbon::parse($leadexist);

                $now = Carbon::now();
                $dtformat = Carbon::create($dt->year, $dt->month, $dt->day, $dt->hour, $dt->minute, $dt->second);
                $addoneday = $dtformat->addHours(24);
                
                $are_different = $now->gt($addoneday);

                    if($are_different === true) {
                        $ins = 1;
                    }
                    else{
                    
                    $ins = 0;
                    }
                    
                }

                if(empty($data)) {
                   $ins = 1;
                }

                
               

            }
            else
            {
                
                 $lead_check = lead_data::select('lead_datetime')->where('Source_type','=','MobileApp')->where('Project_id','=',$projid)->where('Email','=',$email)->orderBy('lead_datetime', 'desc')->first();
                    //only website not leaddb
                    
                
                     if(!empty($lead_check)) {
                    $leadexist = $lead_check['lead_datetime'];
                    
                                   
                $dt = Carbon::parse($leadexist);
                
                $now = Carbon::now();
                $dtformat = Carbon::create($dt->year, $dt->month, $dt->day, $dt->hour, $dt->minute, $dt->second);
                $addoneday = $dtformat->addHours(24);
                
                $are_different = $now->gt($addoneday);
                    
                    if($are_different === true) {
                        $insweb = 1;
                    }
                    else{
                    
                    $insweb = 0;
                    }
                    
                }

                 if(empty($lead_check)) {
                     
                   $insweb = 1;
                   
                }
            }


             if(($ins == 0)&&($insweb == 0))
            {
                 $response = [
                'error' => 'You can enquire after 24 hours from the last enquired datetime.',
                'status_code' => 204
            ];
                return $response;


            }
            elseif(($ins == 0)&&($insweb == 1))
            {
                
                $lead = new lead_data();
                $lead->Project_id = $projid;
                $lead->PID = $pid;
                $lead->Project_name = $projectname;
                $lead->Source_type = 'MobileApp';
                $lead->Name = $name;
                $lead->Email = $email;
                $lead->Mobile = $mobile;
                $lead->City = $city;
                $lead->msg = null;
                $lead->lead_datetime = $now;
                $lead->plantcode = $plantcode;
                $lead->google_campaigncode = null;
                $lead->facebook_campaigncode = null;
                $lead->linkedin_campaigncode = null;
                $lead->website_campaigncode = null;
                $lead->mobile_campaigncode = $mobile_campaigncode;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();
            
           $response = [
                'success' => 'Thanks for your Enquiry. Your data recorded!',
                'status_code' => 200
            ];
                return $response;
            
            }
            elseif(($ins == 1)&&($insweb == 0)){
                                
                $insert = DB::connection('mysql2')->table($table_name)->insert(['Id' => null,'PID' => $pid, 'Project_name' => $projectname,
                'Name' => $name, 'Email' => $email, 'Mobile' => $mobile,'City' => $city, 'msg' => null, 'lead_datetime'=> $now,'inserteddate' => $now]);
                

                $lead = new lead_data();
                $lead->Project_id = $projid;
                $lead->PID = $pid;
                $lead->Project_name = $projectname;
                $lead->Source_type = 'MobileApp';
                $lead->Name = $name;
                $lead->Email = $email;
                $lead->Mobile = $mobile;
                $lead->City = $city;
                $lead->msg = null;
                $lead->lead_datetime = $now;
                $lead->plantcode = $plantcode;
                $lead->google_campaigncode = null;
                $lead->facebook_campaigncode = null;
                $lead->linkedin_campaigncode = null;
                $lead->website_campaigncode = null;
                $lead->mobile_campaigncode = $mobile_campaigncode;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();
            
            $response = [
                'success' => 'Thanks for your Enquiry. Your data recorded!',
                'status_code' => 200
            ];
                return $response;
            }
            else{
                
                 $response = [
                'error' => 'You can enquire after 24 hours from the last enquired datetime.',
                'status_code' => 204
            ];
                return $response;
            }




           
         }
            

public function shownewlaunch()
{
    $getopennewlaunch = DB::connection('mysql4')->table('newlaunch')->select('projectid')->where(['overall_status' => 'OPEN'])->groupBy('projectid')->get();

    if (count($getopennewlaunch) > 0) {
        $key = 0;
        foreach ($getopennewlaunch as $value) {
            
            $projects = DB::table('projectlist')->where(['id' => $value->projectid])->get();

            foreach($projects as $project){
                
        $sqftrange = DB::table('sqft_range')->where('P_id','=',$project->id)->get();
           
                    $response['projects'][] = [
                    'id' => $project->id,
                    'name' => $project->Project_name,
                    'type' => $project->Type,
                    'location' => $project->Location,
                    'startingrange' => $project->Startingrange,
                    'single_quote' => $project->single_quote,
                    'googlemaplink' => $project->googlemap_link,
                    'youtubelink' => $project->youtube_link,
                    'locationsection' => $project->location_section,
                    'locationadvantage' => $project->location_adv_section,
                ];


                $arraynewlaunch = DB::connection('mysql4')->table('newlaunch')->where('projectid','=',$project->id)->orderBy('arrangeorder')->get();

                foreach ($arraynewlaunch as $launchvalue) {
                    $response['projects'][$key]['availability_details'][$project->id][] = [
                        'id' => $launchvalue->id,
                        'arrangeorder' => $launchvalue->arrangeorder,
                        'unit_no' => $launchvalue->unit_no,
                        'unit_name' => $launchvalue->unit_name,
                        'availability' => $launchvalue->availability,
                        ];
                }

              if(view()->exists('amenities.'.$project->id)){  
    $contents = view('amenities.'.$project->id)->render();
    $response['projects'][$key]['amenities'] = $contents;
              }
              else{
                  $response['projects'][$key]['amenities'] = null;
              }

                $bannerdirectory = public_path()."/images/mobbanner/".$project->id.'.jpg';
                if (File::exists($bannerdirectory))
                {
                        $response['projects'][$key]['link'] = "https://vgn.in/images/mobbanner/".$project->id.'.jpg';
                }
                else{
                      $response['projects'][$key]['link'] = null;
                }

                 $constructiondirectory = public_path()."/images/construction/".$project->id;
                 
                if (is_dir($constructiondirectory) === true)
                {
                    //$files = File::allFiles($constructiondirectory);
                    $files = collect(File::allFiles($constructiondirectory))
        ->sortBy(function ($file) {
            return $file->getRelativePathname();
        });
                    
                    $inc = 0;
                    foreach ($files as $file)
                    {
                        $response['projects'][$key]['constructionpics'][] = [
                            $inc => "https://vgn.in/images/construction/".$project->id.'/'.$file->getRelativePathName()
                        ];
                    }
                    
                        
                }
                else{
                      $response['projects'][$key]['constructionpics'][] = [];
                }
               

                if (count($sqftrange) != 0) {
                    foreach ($sqftrange as $newkey => $newvalue) {
                         
                    $response['projects'][$key]['plot'] = $newvalue->Plot;
                    $response['projects'][$key]['bhk'] = $newvalue->BHK;
                    $response['projects'][$key]['sqftstartrange'] = $newvalue->Start;
                    $response['projects'][$key]['sqftendrange'] = $newvalue->End;
                
                    }
                }
                else
                {
                       $response['projects'][$key]['plot'] = null;
                    $response['projects'][$key]['bhk'] = null;
                    $response['projects'][$key]['sqftstartrange'] = null;
                    $response['projects'][$key]['sqftendrange'] = null;
                }
        


            }
            $key++;

        }

        return $response;
    }
    else{
         $response = [
                'error' => 'No new launch announced',
                'status_code' => 204
            ];
                return $response;
    }
}

public function blockplotorflat()
{
    if(isset($_POST['id']) && isset($_POST['apikey'])){
        $id = $_POST['id'];
        $apikey = $_POST['apikey'];
        $getsalesmanager = DB::connection('mysql4')->table('saleslogin')->where(['apikey' => $apikey])->get();
    if((count($getsalesmanager) > 0) && ($apikey != '') && ($apikey != null)){
    $getopennewlaunch = DB::connection('mysql4')->table('newlaunch')->select('projectid')->where(['overall_status' => 'OPEN','availability' => '0','id' => $id])->get();
    $now = Carbon::now();
    if (count($getopennewlaunch) > 0) {
        $updatelaunch = DB::connection('mysql4')->table('newlaunch')->where(['id' => $id])->update(['overall_status' => 'CLOSED','availability' => '1','lastupdated_date'=> $now ]);
         $response = [
                'success' => 'Booked Successfully',
                'status_code' => 200
            ];
                return $response;
    }
    else
    {
         $response = [
                'error' => 'Already Booked',
                'status_code' => 204
            ];
                return $response;
    }
    }
    else{
         $response = [
                'error' => 'Not Valid',
                'status_code' => 204
            ];
                return $response;
    }

    }
    else{
        $response = [
                'error' => 'Not Valid',
                'status_code' => 204
            ];
                return $response;
    }
}


public function saleslogin()
{
    if(isset($_POST['salesid']) && isset($_POST['password'])){
        $salesid = $_POST['salesid'];
        $password = $_POST['password'];
    $getsalesmanager = DB::connection('mysql4')->table('saleslogin')->where(['salesid' => $salesid,'password' => $password])->get();
    $now = Carbon::now();
    if (count($getsalesmanager) > 0) {
        
         $toencrypt = $salesid.'-#yption92'.$now;
         $encrypt = substr(Crypt::encrypt($toencrypt),0,16);
        $updatelaunch = DB::connection('mysql4')->table('saleslogin')->where(['salesid' => $salesid])->update(['apikey' => $encrypt ]);
         $response = [
                'apikey' => $encrypt,
                'status_code' => 200
            ];
                return $response;
    }
    else
    {
         $response = [
                'error' => 'Invalid Login',
                'status_code' => 204
            ];
                return $response;
    }
    }
    else{
        $response = [
                'error' => 'Invalid Login',
                'status_code' => 204
            ];
                return $response;
    }
}


public function saleslogout()
{
    if(isset($_POST['apikey'])){
        
        $apikey = $_POST['apikey'];
    $getsalesmanager = DB::connection('mysql4')->table('saleslogin')->where(['apikey' => $apikey])->get();
    $now = Carbon::now();
    if (count($getsalesmanager) > 0) {
        
        
        $updatelaunch = DB::connection('mysql4')->table('saleslogin')->where(['apikey' => $apikey])->update(['apikey' => null ]);
         $response = [
                'success' => 'Successfully Logged Out',
                'status_code' => 200
            ];
                return $response;
    }
    else
    {
         $response = [
                'error' => 'Invalid Logout',
                'status_code' => 204
            ];
                return $response;
    }
    }
    else{
        $response = [
                'error' => 'Invalid Logout',
                'status_code' => 204
            ];
                return $response;
    }
}
       
    
    public function getcustomerdata_ivrs()
       {
           if (isset($_GET['apikey']) && isset($_GET['mobileno'])) {
               
               $apikey = $_GET['apikey'];
               $mobileno = $_GET['mobileno'];

               if ($apikey == 'a9f341940a34c3428f1aab475df777ee25f6117f') {
               	if (!ctype_digit($mobileno)) {
               		 $response['customerdetails'] = [];
                return $response;
               	}
               	else
               	{
               		if (strlen($mobileno) != 10) {
               			 $response['customerdetails'] = [];
                return $response;
               		}
               	}
               	
                $check = DB::connection('mysql3')->table('customer')->where(['mobile' => $mobileno])->get();

                if (count($check) > 0) {
                    $key = 0;
                    foreach ($check as $key => $value) {
                        
                        $response['customerdetails'] = [
                'Name' => $value->name,
                'email' => $value->email,
                'customer_executive' => $value->customer_executive,
                'customer_manager' => $value->customer_manager,
                'telephone'        => $value->tel
            ];

             $projects = DB::connection('mysql3')->table('projects')->where(['cust_id' => $value->id])->get();

            if (count($projects) > 0) {
                $nkey = 0;
                 foreach ($projects as $prokey => $provalue) {
                $response['customerdetails'][$key]['projectname'][$nkey]['Projectname'] = $provalue->pname;
                $response['customerdetails'][$key]['projectname'][$nkey]['unit_name'] = $provalue->unit_nm;
                $nkey++;
            }
            
            }
            else{
                $response['customerdetails'][$key]['projectname'][] = []; 
            }
           
               $key++;
                    }
                     return $response;
                }
                else
                {
                	 $response['customerdetails'] = [];
                return $response;
                }


               }
               else{
                      $response['customerdetails'] = [];
                return $response;
               }
           }
       }

    
    
}
