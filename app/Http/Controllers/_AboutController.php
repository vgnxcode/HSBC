<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;
use vgn\news;
use File;



class AboutController extends Controller
{
    public function index () {
        //added comment
        $news = news::where('newsname', '<>', '')->orderBy('posted_date', 'desc')->take(2)->get();
        return view('about.index')->with(['news'=>$news]);
    }
    public function contact_us()
    {
        return view('about.contact_us');
    }

    public function disclaimer(){
    	return view('about.disclaimer');
    }
     public function privacy_policy(){
    	return view('about.privacy_policy');
    }
     public function terms_and_conditions(){
        return view('about.terms_and_condition');
    }

    public function maptest(){
        return view('about.maptest');
    }

    public function resumeaccess() {
            
            $imagearray = array();
             
             //$consdirectory = Storage::disk('s3')->files("/careersportal/employee-zone/resumes");
		$consdirectory = File::allFiles("/../../../public/portal/employee-zone/resumes");
                dd($consdirectory);
                
                $consplanfiles = array();
                if(count($consdirectory) > 0) {
                //$consplanfiles = File::allFiles($consdirectory);
                
               $consplanfiles = collect(Storage::disk('s3')->files("/careersportal/employee-zone/resumes"))
        ->sortBy(function ($file) {
            return $file->getATime();
        });
        //dd($consplanfiles);
                
               
                }
                
                return view('Resumes.folderaccess')->with(['consplanfiles' => $consplanfiles] );

        

    }
    
    
}
