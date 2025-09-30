<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use vgn\projectlist;
use Illuminate\Http\Response;
use DB;

class SearchController extends Controller
{

    public function single_link_parse_path_gen_link($path)
    {

        $directory = Storage::disk('s3')->files($path);
                //dd($directory);
                $floorplanfiles = array();
                if(count($directory) > 0) {
                $planfiles = Storage::disk('s3')->files($path);

                return $planfiles[0];
                }
                else{
                    return 0;
                }

    }

    public function index() {
        $searchlist = DB::table('projectlist')->where('Status','=','Ongoing')->orderBy('id', 'asc')
        ->get();
        /* $list = DB::table('projectlist')
                ->select('Location')
                ->where('Status','=','Ongoing')
                ->groupBy('Location')
                ->orderBy('Project_name', 'asc')
                ->get();*/
		/*$list = DB::table('projectlist')
                ->select('Location')
                ->where('Status','=','Ongoing')
                ->groupBy('Location')
                ->get();*/

                $orderlist = ['Fairmont','Notting Hill','Varnabhoomi Phase II','Crofton Gardens Phase III','Oval Gardens','Victoria Park','Mayfield Park','Sandstone','Southern Fortune','Expanza','Stafford','Coasta','Temple Town','Brixton','Pearl Blossom','Florence'];

         
         $newlist = [];
         $newlist1 = [];
         $newlist2 = [];

         //dd($list);
		 //new
         foreach ($orderlist as $key22 => $value22) {
            
             foreach ($searchlist as $key11 => $value11) {
                 if (strtolower($value22) == strtolower($value11->Project_name)) {
                        
                         $newlist1[] = $value11;
                         
                     }
             }
         }

         $ikj = count($newlist1);
         if (count($newlist1) == 0) {
             $newlist1 = $list;
         }else{
         foreach ($searchlist as $key31 => $value31) {
            $ii = 0;
                foreach ($newlist1 as $key41 => $value41) {
                    if (strtolower($value41->Project_name) == strtolower($value31->Project_name)) {
                        
                         $ii = 1;
                         
                     }
                }

                if ($ii == 0) {
                    $ikj += 1;
                    $newlist1[$ikj] = $value31;
                    //$ii++;
                }

             }
         }
         //dd($newlist1);
         //new
           /*  foreach ($searchlist as $key => $value) {
                $ii = 0;
                 foreach ($orderlist as $key1 => $value1) {
                     if (strtolower($value->Project_name) == strtolower($value1)) {
                        $ii = 1;
                         $newlist1[] = $value;
                     }
                 }

                 if ($ii == 0) {
                     $newlist2[] = $value;
                 }
             }

             $newlist = array_merge($newlist1,$newlist2);*/
		$newlist = $newlist1;
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
        return view('search.index')->with(['searchlist' => $newlist, 'list' => $listfinal,'forjs' => $final_arr] );
    }
    public function show(Request $request) {

         /*$list = DB::table('projectlist')
                ->select('Location')
                ->where('Status','=','Ongoing')
                ->groupBy('Location')
                ->orderBy('Location', 'asc')
                ->get();*/

                //dd($request);

        $projects =  DB::table('projectlist')->where(function($query) use($request){
            $location = $request->location;
            $budget = $request->budget;
            $projecttype = $request->projecttype;
            $projectstatus = $request->pstatus;

            //dd($request);
           

            if(!empty($location)){
                $query->where('Location','=',$location);
            }

             if(!empty($projecttype)){
                $query->where('Type','=',$projecttype);
            }

            /*if(($projectstatus == 'RTC') || ($projectstatus == 'UC') ) {

                if($projectstatus == 'RTC'){

                    $query->where('projectstatus','=',$projectstatus);
                }

                if($projectstatus == 'UC'){

                    $query->where('Type','=','Apartments')->where('Status','=','Ongoing')->where('projectstatus','=',null);
                }

            }*/
            

            /*if(!empty($budget)){
                $lowercasebudget = strtolower($budget);
                $amount1 = '';
                $amount2 = '';
                if (strpos($lowercasebudget, '-') !== false) {
                $amt = explode("-", $lowercasebudget);
                $amt1 = substr($amt[0], -1);
                $amt2 = substr($amt[1], -1);

                

                if(strtolower($amt1) == 'l') { 
                    $amount1 = str_replace('l', '00000', strtolower($amt[0]));
                }
                if(strtolower($amt2) == 'l') { 
                    
                    $amount2 = str_replace('l', '00000', strtolower($amt[1]));
                    
                }
                }
                
                if (strpos($lowercasebudget, 'c') !== false) {
                    $amount2 = '';
                    $amt1 = substr($lowercasebudget, -1);
                    if(strtolower($amt1) == 'c') {
                        $amount1 = str_replace('c', '0000000', strtolower($lowercasebudget));
                    }
                }

                
                if($amount2 == ''){
                    $query->where('Startingrange','>=',$amount1);
                }
                if($amount2 != ''){
                    
                    $query->whereBetween('Startingrange', [$amount1, $amount2]);
                }
                
            }*/

            /*if(!empty($projecttype)){
                $query->where('Type','=',$projecttype);
            }*/

            $query->where('Status','=','Ongoing');
        })
        ->orderBy('Project_name', 'asc')
        ->get();
		//dd($projects);
		//dd($projects->toSql(), $projects->getBindings());
        $request->session()->flash("scroll", '1');
        
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
        
        return view('search.index')->with(['searchlist' => $projects, 'list' => $listfinal,'forjs' => $final_arr] );
        //return view('search.index')->with(['searchlist' => $projects, 'list' => $list] )->withInput();
        //return redirect()->route('search', ['searchlist' => $projects, 'list' => $list])->withInput();
    }

    public function ongoing() {

        $list = DB::table('projectlist')
                ->where('Status','=','Ongoing')
                ->orderBy('Project_name', 'asc')
                ->get();
                
               
        return view('Project.ongoing')->with(['list' => $list] );
    }
    
     public function searchongoing() {

        $list = DB::table('projectlist')
                ->where('Status','=','Ongoing')
                ->orderBy('id', 'asc')
                ->get();
         
         /*$locationlist = DB::table('projectlist')
                ->select('Location')
                ->where('Status','=','Ongoing')
                ->groupBy('Location')
                ->orderBy('Location', 'asc')
                ->get();*/
         
         foreach($list as $k=>$filecheck){
          
           /* $filepath = '/images/project_thumb/'.$filecheck->id.'.jpg';
             if(Storage::disk('s3')->exists($filepath)){
            $list[$k]->projectthumbimagelink = Storage::disk('s3')->url($filepath);
                 
             }
             else
             {
                 if($filecheck->Type == 'Apartments'){
                     $list[$k]->projectthumbimagelink = Storage::disk('s3')->url("/images/project_thumb/default_flats.jpg");
                 } elseif($filecheck->Type == 'Plots'){
                $list[$k]->projectthumbimagelink = Storage::disk('s3')->url("/images/project_thumb/default_plots.jpg");
                 }
             }*/

              $projectthumbpath = "images/project_thumb/".$filecheck->id;
            
            $pthumbpath = $this->single_link_parse_path_gen_link($projectthumbpath);
            if ($pthumbpath == '0') {
                if($filecheck->Type == 'Apartments'){
                     $list[$k]->projectthumbimagelink = "images/project_thumb/default_flats.jpg";
                 } elseif($filecheck->Type == 'Plots'){
                $list[$k]->projectthumbimagelink = "images/project_thumb/default_plots.jpg";
                 }
            }
            else{
                $list[$k]->projectthumbimagelink = $pthumbpath;
            }
         }
         
         $orderlist = ['Fairmont','Notting Hill','Varnabhoomi Phase II','Crofton Gardens Phase III','Oval Gardens','Victoria Park','Mayfield Park','Sandstone','Southern Fortune','Samudra','Divine','Expanza','Stafford','Coasta','Temple Town','Brixton','Pearl Blossom','Florence','Monte Carlo','Royale','Windsor park PHASE V','Spring Field Phase II'];
         
         $newlist = [];
         $newlist1 = [];
         $newlist2 = [];

         //dd($list);
//new
         foreach ($orderlist as $key22 => $value22) {
            
             foreach ($list as $key11 => $value11) {
                 if (strtolower($value22) == strtolower($value11->Project_name)) {
                        
                         $newlist1[] = $value11;
                         
                     }
             }
         }

         $ikj = count($newlist1);
         if (count($newlist1) == 0) {
             $newlist1 = $list;
         }else{
         foreach ($list as $key31 => $value31) {
            $ii = 0;
                foreach ($newlist1 as $key41 => $value41) {
                    if (strtolower($value41->Project_name) == strtolower($value31->Project_name)) {
                        
                         $ii = 1;
                         
                     }
                }

                if ($ii == 0) {
                    $ikj += 1;
                    $newlist1[$ikj] = $value31;
                    //$ii++;
                }

             }
         }
         //dd($newlist1);
         //new
           /*  foreach ($list as $key => $value) {
                $ii = 0;
                 foreach ($orderlist as $key1 => $value1) {
                     if (strtolower($value->Project_name) == strtolower($value1)) {
                        $ii = 1;
                         $newlist1[] = $value;
                     }
                 }

                 if ($ii == 0) {
                     $newlist2[] = $value;
                 }
             }

             $newlist = array_merge($newlist1,$newlist2);*/
		$newlist = $newlist1;
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
               
        return view('Project.ongoingsearch')->with(['locationlist'=>$listfinal,'list' => $newlist,'forjs' => $final_arr] );
    }
    
    public function postsearchongoing() {
        if(isset($_POST['location']) || isset($_POST['budget']) || isset($_POST['ptype']) || isset($_POST['pstatus'])){
            
            if(!empty(isset($_POST['location']))){ $location = $_POST['location'];}else{ $location = null;}
            if(!empty(isset($_POST['budget']))){ $budget = $_POST['budget'];}else{ $budget = null;}
            if(!empty(isset($_POST['ptype']))){ $ptype = $_POST['ptype'];}else{ $ptype = null;}
            if(!empty(isset($_POST['pstatus']))){ $pstatus = $_POST['pstatus'];}else{ $pstatus = null;}
            
            
             $projects =  DB::table('projectlist')->where('Status','=','Ongoing')->where(function($query) use($location,$budget,$ptype,$pstatus){
            
            //dd($request);
            if(!empty($location)){
                $query->where('Location','=',$location);
            }

            /*if(($pstatus == 'RTC') || ($pstatus == 'UC') ) {

                if($pstatus == 'RTC'){

                    $query->where('projectstatus','=',$pstatus);
                }

                if($pstatus == 'UC'){

                    $query->where('projectstatus','=',null)->where('Type','=','Apartments');
                }

            }*/
            

            /*if(!empty($budget)){
                $lowercasebudget = strtolower($budget);
                $amount1 = '';
                $amount2 = '';
                if (strpos($lowercasebudget, '-') !== false) {
                $amt = explode("-", $lowercasebudget);
                $amt1 = substr($amt[0], -1);
                $amt2 = substr($amt[1], -1);

                

                if(strtolower($amt1) == 'l') { 
                    $amount1 = str_replace('l', '00000', strtolower($amt[0]));
                }
                if(strtolower($amt2) == 'l') { 
                    
                    $amount2 = str_replace('l', '00000', strtolower($amt[1]));
                    
                }
                }
                
                if (strpos($lowercasebudget, 'c') !== false) {
                    $amount2 = '';
                    $amt1 = substr($lowercasebudget, -1);
                    if(strtolower($amt1) == 'c') {
                        $amount1 = str_replace('c', '0000000', strtolower($lowercasebudget));
                    }
                }

                
                if($amount2 == ''){
                    $query->where('Startingrange','>=',$amount1);
                }
                if($amount2 != ''){
                    
                    $query->whereBetween('Startingrange', [$amount1, $amount2]);
                }
                
            }*/

            if(!empty($ptype)){
                $query->where('Type','=',$ptype);
            }

            
        })
        ->orderBy('Project_name', 'asc')
        ->get();
            
            
            
        }else{
            
            return redirect()->route('home');
        }
        
         
         $locationlist = DB::table('projectlist')
                ->select('Location')
                ->where('Status','=','Ongoing')
                ->groupBy('Location')
                ->orderBy('Location', 'asc')
                ->get();
        
        foreach($projects as $k=>$filecheck){
             /*if(Storage::disk('s3')->exists('/images/project_thumb/'.$filecheck->id.'.jpg')){
            $projects[$k]->projectthumbimagelink = Storage::disk('s3')->url("/images/project_thumb/".$filecheck->id.'.jpg');
                 
             }
             else
             {
                 if($filecheck->Type == 'Apartments'){
                     $projects[$k]->projectthumbimagelink = Storage::disk('s3')->url("/images/project_thumb/default_flats.jpg");
                 } elseif($filecheck->Type == 'Plots'){
                $projects[$k]->projectthumbimagelink = Storage::disk('s3')->url("/images/project_thumb/default_plots.jpg");
                 }
             }*/

              $projectthumbpath = "images/project_thumb/".$filecheck->id;
            
            $pthumbpath = $this->single_link_parse_path_gen_link($projectthumbpath);
            if ($pthumbpath == '0') {
                if($filecheck->Type == 'Apartments'){
                     $projects[$k]->projectthumbimagelink = "images/project_thumb/default_flats.jpg";
                 } elseif($filecheck->Type == 'Plots'){
                $projects[$k]->projectthumbimagelink = "images/project_thumb/default_plots.jpg";
                 }
            }
            else{
                $projects[$k]->projectthumbimagelink = $pthumbpath;
            }
            
         }
                
               return response()
            ->json(['list' => $projects, 'location' => $location]);
        //return view('Project.ongoingsearch')->with(['locationlist'=>$locationlist,'list' => $projects, 'location'=>$location,'budget'=>$budget,'ptype'=>$ptype,'pstatus'=>$pstatus] );
    }

    public function completed() {

        $list = DB::table('projectlist')
                ->where('Status','=','Completed')
                ->orderBy('Project_name', 'asc')
                ->get();
        return view('Project.completed')->with(['list' => $list] );
    }
    public function searchcompleted() {

        $list = DB::table('projectlist')
                ->where('Status','=','Completed')
                ->orderBy('Project_name', 'asc')
                ->get();
         
         /*$locationlist = DB::table('projectlist')
                ->select('Location')
                ->where('Status','=','Completed')
                ->groupBy('Location')
                ->orderBy('Location', 'asc')
                ->get();*/
         
         foreach($list as $k=>$filecheck){

             $filepath = '/images/project_thumb/'.$filecheck->id.'.jpg';
             if(Storage::disk('s3')->exists($filepath)){
            $list[$k]->projectthumbimagelink = Storage::disk('s3')->url($filepath);
                 
             }
             else
             {
                 if($filecheck->Type == 'Apartments'){
                     $list[$k]->projectthumbimagelink = Storage::disk('s3')->url("/images/project_thumb/default_flats.jpg");
                 } elseif($filecheck->Type == 'Plots'){
                $list[$k]->projectthumbimagelink = Storage::disk('s3')->url("/images/project_thumb/default_plots.jpg");
                 }
             }
         }
         

         $list2 = DB::table('projectlist')
                ->select('Type','Location')
                ->where('Status','=','Completed')
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
                
               
        return view('Project.completedsearch')->with(['locationlist'=>$listfinal,'list' => $list,'forjs' => $final_arr] );
    }

    public function postsearchcompleted() {
        if(isset($_POST['location']) || isset($_POST['budget']) || isset($_POST['ptype'])){
            
            if(!empty(isset($_POST['location']))){ $location = $_POST['location'];}else{ $location = null;}
            if(!empty(isset($_POST['budget']))){ $budget = $_POST['budget'];}else{ $budget = null;}
            if(!empty(isset($_POST['ptype']))){ $ptype = $_POST['ptype'];}else{ $ptype = null;}           
            
             $projects =  DB::table('projectlist')->where('Status','=','Completed')->where(function($query) use($location,$budget,$ptype){
            
            //dd($request);
            if(!empty($location)){
                $query->where('Location','=',$location);
            }          

            /*if(!empty($budget)){
                $lowercasebudget = strtolower($budget);
                $amount1 = '';
                $amount2 = '';
                if (strpos($lowercasebudget, '-') !== false) {
                $amt = explode("-", $lowercasebudget);
                $amt1 = substr($amt[0], -1);
                $amt2 = substr($amt[1], -1);

                

                if(strtolower($amt1) == 'l') { 
                    $amount1 = str_replace('l', '00000', strtolower($amt[0]));
                }
                if(strtolower($amt2) == 'l') { 
                    
                    $amount2 = str_replace('l', '00000', strtolower($amt[1]));
                    
                }
                }
                
                if (strpos($lowercasebudget, 'c') !== false) {
                    $amount2 = '';
                    $amt1 = substr($lowercasebudget, -1);
                    if(strtolower($amt1) == 'c') {
                        $amount1 = str_replace('c', '0000000', strtolower($lowercasebudget));
                    }
                }

                
                if($amount2 == ''){
                    $query->where('Startingrange','>=',$amount1);
                }
                if($amount2 != ''){
                    
                    $query->whereBetween('Startingrange', [$amount1, $amount2]);
                }
                
            }*/

            if(!empty($ptype)){
                $query->where('Type','=',$ptype);
            }

            
        })
        ->orderBy('Project_name', 'asc')
        ->get();
            
            
            
        }else{
            
            return redirect()->route('home');
        }
        
         
         $locationlist = DB::table('projectlist')
                ->select('Location')
                ->where('Status','=','Completed')
                ->groupBy('Location')
                ->orderBy('Location', 'asc')
                ->get();
        
        foreach($projects as $k=>$filecheck){
             if(Storage::disk('s3')->exists('/images/project_thumb/'.$filecheck->id.'.jpg')){
            $projects[$k]->projectthumbimagelink = Storage::disk('s3')->url("/images/project_thumb/".$filecheck->id.'.jpg');
                 
             }
             else
             {
                 if($filecheck->Type == 'Apartments'){
                     $projects[$k]->projectthumbimagelink = Storage::disk('s3')->url("/images/project_thumb/default_flats.jpg");
                 } elseif($filecheck->Type == 'Plots'){
                $projects[$k]->projectthumbimagelink = Storage::disk('s3')->url("/images/project_thumb/default_plots.jpg");
                 }
             }
         }
                
               return response()
            ->json(['list' => $projects, 'location' => $location]);
        //return view('Project.ongoingsearch')->with(['locationlist'=>$locationlist,'list' => $projects, 'location'=>$location,'budget'=>$budget,'ptype'=>$ptype,'pstatus'=>$pstatus] );
    }
}
