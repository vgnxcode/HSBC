<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use vgn\projectlist;
use Illuminate\Support\Facades\Log;
use vgn\contact;
use DB;
use Validator;

class HomeController extends Controller
{
    public function index () {
        /*$list = DB::table('projectlist')
                ->select('Location')
                ->where('Status','=','Ongoing')
                ->groupBy('Location')
                ->orderBy('Location', 'asc')
                ->get();*/
	//Log::info('Homepage Accessed...');
		$list2 = DB::table('projectlist')
                ->select('Type','Location')
                ->where('Status','=','Ongoing')
                ->orderBy('Location', 'asc')
                ->get();

                $mod_arr['Plots'] = [];
                $mod_arr['Apartments'] = [];
                $listfinal['Location'] = [];

                //dd($list2);
                foreach ($list2 as $key => $value) {
                    //$newarr[$value->Location] = $value->Type; 
                    array_push($listfinal['Location'],$value->Location);
                    if ($value->Type == 'Plots') {
                        array_push($mod_arr['Plots'], $value->Location);
                    }
                    if ($value->Type == 'Apartments') {
                        array_push($mod_arr['Apartments'], $value->Location);
                    }
                    
                }
                $final_arr['Plots'] = array_unique($mod_arr['Plots']);
                $final_arr['Apartments'] = array_unique($mod_arr['Apartments']);
                $listfinal['Location'] = array_unique($listfinal['Location']);

        $testimonials = DB::table('testimonials')->get();
        $completedcount = projectlist::where('Status','=','Completed')->count();
        $featuredproject = projectlist::where('featured_projects','<>','')->get();
        return view('home.index')->with(['list' => $listfinal, 'completedcount'=> $completedcount,'featuredproject' => $featuredproject,'testimonials' => $testimonials,'forjs' => $final_arr]);
    }

   

    public function contactpost(Request $request){
          
           $validator = Validator::make($request->all(), [
            'Name' => 'required|regex:/^[\pL\s\.]+$/u|min:4',
			'Email' => 'required|email',
			'Mobile' => 'required|digits:10',
            'City' => 'required|regex:/^[\pL\s]+$/u|min:4',
            'Message' => 'required|regex:/^[\pL\s]+$/u|min:4'
        ]);

           if ($validator->fails()) {
               $request->session()->flash("contact_post_error", 'error');
            return redirect('/#contact')
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $leaddttime = date('Y-m-d h:i:s');
            $lead_check = contact::where('Email','=',$request->Email)->count();
            $leadcontacted_check = contact::where('Email','=',$request->Email)->get();
            
            if($lead_check == 0){

                
                

                $lead = new contact();
                
                $lead->Name = preg_replace("/[^A-Za-z.?! ]/","",$request->Name);
                $lead->Email = $request->Email;
                $lead->Mobile = $request->Mobile;
                $lead->City = preg_replace("/[^A-Za-z.?! ]/","",$request->City);
                $lead->Message = $request->Message;
                $lead->contacted_count = 1;
                $lead->created_at = date('Y-m-d H:i:s');
                $lead->updated_at = date('Y-m-d H:i:s');
                $lead->save();
            }
            else{
                
                $countplusone = $leadcontacted_check[0]['contacted_count'] + 1;
                
            
                $leadupdate = contact::where('Email','=',$request->Email)->update(['updated_at' => $leaddttime,'contacted_count' => $countplusone ]);
            }

            $request->session()->flash("contact_post_success", 'success');
            return redirect()->route('home');
        }
    }


    public function sitemap(){
        return view('home.sitemap');
    }

    public function history_of_vgn()
    {
    	return view('about.history_of_vgn');
    }

    public function awards()
    {
        return view('about.awards');
    }

    public function sponsorships()
    {
        return view('about.sponsorships');
    }

    public function projectdetails_crud(Request $request){
        try{
           $data = DB::connection('mysql')
                ->table('projectlist')
                ->insertGetId([
                'id' => $request['id'],
                'Project_name' => $request['Project_name'],
                'Status' => $request['Status'],
                'Type' => $request['Type'],
                'Location' => $request['Location'],
                'Startingrange' => $request['Startingrange'],
                'single_quote' => $request['single_quote'],
                'googlemap_link' => $request['googlemap_link'],
                'location_section' => $request['location_section'],
                'location_adv_section' => $request['location_adv_section'],
                'youtube_link' => $request['youtube_link'],
                'no_details' => $request['no_details'],
                'featured_projects' => $request['featured_projects'],
                'plantcode' => $request['plantcode'],
                'google_campaigncode' => $request['google_campaigncode'],
                'facebook_campaigncode' => $request['facebook_campaigncode'],
                'linkedin_campaigncode' => $request['linkedin_campaigncode'],
                'website_campaigncode' => $request['website_campaigncode'],
                'mobile_campaigncode' => $request['mobile_campaigncode'],
                'projectstatus' => $request['projectstatus']
                ]);
                return $data;
        } catch (Exception $e) {
            return dd($e);
        }
        
    }

    public function projectdetails_crud_update(Request $request){
        try{
            DB::connection('mysql')
                ->table('projectlist')
                ->where('id', $request['id'])
                ->update($request->all());
        } catch (Exception $e) {
            return dd($e);
        }
    }

    public function projectsqftins_update(Request $request){
        try{
                $pid = $request->pid;
                $isplot = $request->isplot;
                $BHK = $request->BHK;
                $startsqft = $request->stsqft;
                $endsqft = $request->endsqft;
                if ($isplot == 'Y') {
                    $check = DB::connection('mysql')->table('sqft_range')->where(['P_id' => $pid])->get();
                }
                else{
                    $check = DB::connection('mysql')->table('sqft_range')->where(['P_id' => $pid, 'BHK' => $BHK])->get();
                }
            

            if (count($check) > 0) {
                
                if ($isplot == 'Y') { 
                        DB::connection('mysql')->table('sqft_range')->where(['P_id' => $pid])->update(['Plot' => 1, 'BHK' => $BHK, 'Start' => $startsqft,'End' => $endsqft]);
                    }
                    else{
                        DB::connection('mysql')->table('sqft_range')->where(['P_id' => $pid, 'BHK' => $BHK])->update(['Plot' => null, 'BHK' => $BHK, 'Start' => $startsqft,'End' => $endsqft]);
                    }
            }
            else{
                if ($isplot == 'Y') { 
                    DB::connection('mysql')->table('sqft_range')->insert(['P_id' => $pid,'Plot' => 1, 'BHK' => $BHK, 'Start' => $startsqft,'End' => $endsqft]);
                }
                else{
                    DB::connection('mysql')->table('sqft_range')->insert(['P_id' => $pid,'Plot' => null, 'BHK' => $BHK, 'Start' => $startsqft,'End' => $endsqft]);
                }

            }

           return 'Updated';
        } catch (Exception $e) {
            return dd($e);
        }
    }

    



}
