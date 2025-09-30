<?php

namespace vgn\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('page.home');
    }
    public function aboutus()
    {
        return view('page.aboutus');
    }
    public function contact()
    {
        return view('page.contact');
    }
    public function investors()
    {
        return view('page.investors');
    }
    public function careers()
    {
        return view('page.careers');
    }

    public function project_brixton()
    {
        return view('page.project-brixton');
    }
    public function project_notting_hill()
    {
        return view('page.project-notting-hill');
    }
    public function project_fairmont()
    {
        return view('page.project-fairmont');
    }
    public function project_marble_arch()
    {
        return view('page.project-marble-arch');
    }
    public function project_kensington_towers()
    {
        return view('page.project-kensington-towers');
    }
    public function fairmontproject_thanks()
    {
        return view('page.projects-fairmont-thankyou');
    }
    public function nottinghillproject_thanks()
    {
        return view('page.project-notting-hill-thankyou');
    }
    public function brixtonproject_thanks()
    {
        return view('page.project-brixton-thankyou');
    }
    public function marblearchproject_thanks()
    {
        return view('page.project-marble-arch-thankyou');
    }
    public function kensington_towers_thanks()
    {
        return view('page.project-kensington-towers-thankyou');
    }
    public function completed_projects()
    {
        return view('page.completed-projects');
    }

    public function vgn_engineer()
    {
        return view('page.vgn-engineer');
    }
    public function vgn_foreman_civil()
    {
        return view('page.vgn-foreman-civil');
    }
    public function vgn_front_office_exec()
    {
        return view('page.vgn-front-office-exec');
    }
    public function vgn_supervisor()
    {
        return view('page.vgn-supervisor');
    }
    public function vgn_2bhk_flats()
    {
        return view('page.vgn-2bhk-flats');
    }
    public function vgn_3bhk_flats()
    {
        return view('page.vgn-3bhk-flats');
    }
    public function vgn_4bhk_flats()
    {
        return view('page.vgn-4bhk-flats');
    }
    public function infra()
    {
        return view('page.infra');
    }
    public function commercial()
    {
        return view('page.commercial');
    }
    public function sports()
    {
        return view('page.sports');
    }
    public function media()
    {
        return view('page.media');
    }
    public function disclaimer()
    {
        return view('page.disclaimer');
    }
    public function privacy_policy()
    {
        return view('page.privacy_policy');
    }
    public function terms_and_conditions()
    {
        return view('page.terms_and_condition');
    }
    public function coming_soon()
    {
        return view('page.coming-soon');
    }
    public function upcoming_projects()
    {
        return view('page.upcoming-projects');
    }
    public function project_richmond_towers()
    {
        return view('page.project-richmond-towers');
    }
    public function richmond_towers_thanks()
    {
        return view('page.project-richmond-towers-thankyou');
    }
    public function project_seattle()
    {
        return view('page.project-seattle');
    }
    public function seattle_thanks()
    {
        return view('page.project-seattle-thankyou');
    }
}

