<?php
use Illuminate\Support\Facades\Route;


Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});


Route::get('/', function () {
    return redirect('/api/hsbc/hsbcfinalupdate_table');
});

//website Pages(front-end)
Route::controller(PageController::class)->group(function () {
   // Route::get('/', 'home')->name('home');
    Route::get('/about-us', 'aboutus')->name('aboutus');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/investors', 'investors')->name('investors');
    Route::get('/careers', 'careers')->name('careers.apply');
    Route::get('/completed-projects', 'completed_projects')->name('completed_projects');
    Route::get('/vgn-2bhk-flats-in-chennai', 'vgn_2bhk_flats')->name('vgn.2bhk.flats');
    Route::get('/vgn-3bhk-flats-in-chennai', 'vgn_3bhk_flats')->name('vgn.3bhk.flats');
    Route::get('/vgn-4bhk-flats-in-chennai', 'vgn_4bhk_flats')->name('vgn.4bhk.flats');
    Route::get('/infra', 'infra')->name('infra');
    Route::get('/commercial', 'commercial')->name('commercial');
    Route::get('/sports', 'sports')->name('sports');
    Route::get('/media-corner', 'media')->name('media');
    Route::get('/disclaimer', 'disclaimer')->name('disclaimer');
    Route::get('/privacy-policy', 'privacy_policy')->name('privacy_policy');
    Route::get('/terms-and-conditions', 'terms_and_conditions')->name('terms_and_conditions');
    Route::get('/coming-soon', 'coming_soon')->name('coming_soon');
    Route::get('/upcoming-projects', 'upcoming_projects')->name('upcoming_projects');
});

Route::prefix('projects')->controller(PageController::class)->group(function () {
    Route::get('/brixton-irungattukottai-chennai', 'project_brixton')->name('brixtonnewlink');
    Route::get('/notting-hill-nungambakkam-chennai', 'project_notting_hill')->name('notting_hillnewlink');
    Route::get('/fairmont-guindy-chennai', 'project_fairmont')->name('fairmontnewlink');
    Route::get('/marble-arch-tambaram-chennai', 'project_marble_arch')->name('marble_archnewlink');
    Route::get('/kensington-towers-guindy-chennai', 'project_kensington_towers')->name('kensington_towers');
    Route::get('/richmond-towers-guindy-chennai', 'project_richmond_towers')->name('richmond_towers');
    Route::get('/seattle-mogappair-chennai', 'project_seattle')->name('seattle');

    // Thank-you pages
    Route::get('/fairmont-guindy-chennai-thank-you', 'fairmontproject_thanks')->name('fairmontproject_thanks');
    Route::get('/notting-hill-nungambakkam-chennai-thank-you', 'nottinghillproject_thanks')->name('nottinghillproject_thanks');
    Route::get('/brixton-irungattukottai-chennai-thank-you', 'brixtonproject_thanks')->name('brixtonproject_thanks');
    Route::get('/marble-arch-tambaram-chennai-thank-you', 'marblearchproject_thanks')->name('marblearchproject_thanks');
    Route::get('/kensington-towers-guindy-chennai-thank-you', 'kensington_towers_thanks')->name('kensington_towers_thanks');
    Route::get('/richmond-towers-guindy-chennai-thank-you', 'richmond_towers_thanks')->name('richmond_towers_thanks');
    Route::get('/seattle-mogappair-chennai-thank-you', 'seattle_thanks')->name('seattle_thanks');
});

//website Pages(Project-Leads)
Route::controller(CommonLeadController::class)->group(function () {
    Route::post('/notting-lead', 'nottinglead');
    Route::post('/marble-lead', 'marblelead');
    Route::post('/kensington-lead', 'kensingtonlead');
    Route::post('/fairmont-lead', 'fairmontlead');
    Route::post('/brixton-lead', 'brixtonlead');
    Route::post('/projects/post-marble-arch-tambaram-chennai', 'postmarble');
    Route::post('/projects/kensington-towers-guindy-chennai', 'postkensington');
    Route::post('/richmond-lead', 'richmondlead');
    Route::post('/richmond-lead-google', 'richmondleadgoogle');
    Route::post('/richmond-lead-spotify', 'richmondleadspotify'); // Spotify
    Route::post('/richmond-lead-google-ifx', 'richmondleadgoogleifx');
    Route::post('/richmond-lead-google-spt', 'richmondleadgooglespt');
    Route::post('/richmond-lead-google-dmz', 'richmondleadgoogledmz');
    Route::post('/seattle-lead', 'seattlelead');
    Route::post('/seattle-lead-google', 'seattleleadgoogle');
    Route::post('/seattle-lead-google-ifx', 'seattleleadgoogleifx');
    Route::post('/seattle-lead-google-dmz', 'seattleleadgoogledmz');
    Route::post('/verify-enquiry', 'verify_enquiry');
    Route::post('/verify-otp', 'verify_otp');
});

Route::controller(CommonLeadController::class)->middleware('cors')->group(function () {
    Route::post('/project-lead', 'projectlead');
    Route::post('/interior-lead', 'interiorlead');
});

Route::get('/pageblocked', 'SiteblockedController@pageblocked');


//Old-projects
Route::prefix('project')->controller(ProjectController::class)->group(function () {
    Route::get('/coasta', 'redir_coastawebenquiry');
    Route::get('/notting_hill', 'redir_nottingwebenquiry');
    Route::get('/brixton', 'redir_brixtonwebenquiry');
    Route::get('/fairmont', 'redir_fairmontwebenquiry');
    Route::get('/krona_phase_ii', 'redir_kronaphaseiiwebenquiry');
    Route::get('/stafford', 'redir_staffordwebenquiry');
    Route::get('/temple_town', 'redir_temple_townwebenquiry');
});

Route::controller(ProjectController::class)->group(function () {
    // OTP Routes
    Route::get('/projectotpverify/project/{name?}', 'potpshow')->where('name', '[0-9a-zA-Z\_]+')->name('potpproject');
    Route::post('/projectotpverify/project/{name}', 'potpinsertlead')->where('name', '[0-9a-zA-Z\_]+')->name('potpprojectleadinsert');
    Route::get('/projectotpverify/otplogout/{name}', 'otplogout')->where('name', '[0-9a-zA-Z\_]+')->name('potplogout');

    // Floor and Construction Images
    Route::get('/floorimages/{name?}', 'floorfn')->where('name', '[0-9a-zA-Z\_]+')->name('floorfn');
    Route::get('/constructionimages/{name?}', 'constructionfntest')->where('name', '[0-9a-zA-Z\_]+')->name('constructionfntest');
    Route::get('/constructionimages/{name?}/{folder?}', 'constructionfntestfolder')->where('name', '[0-9a-zA-Z\_]+')->name('constructionfntestfolder');
    Route::get('/newconstructionimages/{name?}', 'newconstructionfn')->where('name', '[0-9a-zA-Z\_]+')->name('newconsfn');

    // Thank You Page
    Route::get('/thank-you/{name?}', 'thanks')->name('project_thanks');

    // Coasta Project
    Route::get('/coasta/Luxury-Apartments-in-ECR', 'coastawebenquiry')->name('coastanewlink');
    Route::post('/coasta/Luxury-Apartments-in-ECR', 'postcoastawebenquiry');
    Route::get('/coasta/thank-you/Luxury-Apartments-in-ECR', 'coastathanks')->name('coastaproject_thanks');

    // Link OTP Verification
    Route::get('/linkotpverify/{name?}/{routelink}', 'linkchangeotpshow')->name('linkchangeotpshow');
    Route::post('/linkotpverify/{name?}/{routelink}', 'postlinkchangeotp');
    Route::get('/linkotpverify/otplogout/{name}/{routelink}', 'linkotplogout')->where('name', '[0-9a-zA-Z\_]+')->name('lotplogout');

    // Lead Capture Forms
    Route::post('/notting_hill/Flats-for-sale-nungambakkam', 'postnottinghillwebenquiry');
    Route::post('/brixton/Residential-Property-Irungattukottai', 'postbrixtonwebenquiry');
    Route::post('/fairmont/Buy-premium-flats-Guindy', 'postfairmontwebenquiry');
    Route::post('/fairmont/Buy-luxury-flats-Guindy', 'postfairmontwebenquirylux')->middleware('cors');
    Route::post('/coasta/commercial', 'postcoastacommercial')->middleware('cors');
    Route::post('/fairmont/duplex', 'postfairmontwebenquirydup')->middleware('cors');
    Route::post('/kensington-towers-lead', 'postkensingtonwebenquiry')->middleware('cors');
    Route::post('/kensington-towers-lead-google', 'postkensingtonwebenquirygoogle')->middleware('cors');
    Route::post('/kensington-towers-lead-google-blackmount', 'postkensingtonwebenquirygooglebm')->middleware('cors');

    // Dynamic Project Routes
    Route::get('/project/{name?}', 'show')->where('name', '[0-9a-zA-Z\_]+')->name('project');
    Route::post('/project/{name}', 'insertlead')->where('name', '[0-9a-zA-Z\_]+')->name('projectleadinsert');

    // Utility
    Route::get('/checkimage', 'checkimagenew');
});


//Public Project Pages - Google Ads
Route::prefix('googlead-display/project')->controller(GoogleProjectController::class)->where(['name' => '[0-9a-zA-Z_]+'])->group(function () {
    Route::get('/{name?}', 'gdshow')->name('gdproject');
    Route::post('/{name}', 'gdinsertlead')->name('gdprojectleadinsert');
});
Route::controller(GoogleProjectController::class)->group(function () {
    Route::get('/googlead-display/otplogout/{name}', 'otplogout')->where(['name' => '[0-9a-zA-Z_]+'])->name('otplogout');
    Route::get('/googlead-display/thank-you/{name?}', 'gdthanks')->name('gdproject_thanks');
});

/* new google urls */
Route::controller(GoogleProjectController::class)->group(function () {
    // OTP Generic Routes
    Route::prefix('googlead-otpverify/project')->where(['name' => '[0-9a-zA-Z_]+'])->group(function () {
        Route::get('/{name?}', 'gdotpshow')->name('gotpproject');
        Route::post('/{name}', 'gdotpinsertlead')->name('gotpprojectleadinsert');
    });

    // Coasta
    Route::prefix('google/flats/ecr/coasta')->group(function () {
        Route::get('/', 'coastagoogleenquiry')->name('coastagoogleenquiry');
        Route::post('/', 'postcoastagoogleenquiry');
        Route::get('/otpverify', 'coastashowotpgoogleenquiry')->name('coastagoogleurlnew');
        Route::post('/otpverify', 'coastapostotpgoogleenquiry');
        Route::get('/thank-you', 'coastathanks')->name('coasta_thanks');
    });
    Route::get('/google/otplogout/coasta', 'coastaotplogout')->name('coastaotplogout');

    // Notting Hill
    Route::prefix('google/flats/nungambakkam/notting_hill')->group(function () {
        Route::get('/', 'nottinghillgoogleenquiry')->name('nottinghillgoogleenquiry');
        Route::post('/', 'postnottinghillgoogleenquiry');
        Route::get('/otpverify', 'nottinghillshowotpgoogleenquiry')->name('nottinghillgoogleurlnew');
        Route::post('/otpverify', 'nottinghillpostotpgoogleenquiry');
        Route::get('/thank-you', 'nottinghillthanks')->name('nottinghill_thanks');
    });
    Route::get('/google/otplogout/notting_hill', 'nottinghillotplogout')->name('nottinghillotplogout');

    // Stafford
    Route::prefix('google/flats/ambattur/stafford')->group(function () {
        Route::get('/', 'staffordgoogleenquiry')->name('staffordgoogleenquiry');
        Route::post('/', 'poststaffordgoogleenquiry');
        Route::get('/otpverify', 'staffordshowotpgoogleenquiry')->name('staffordgoogleurlnew');
        Route::post('/otpverify', 'staffordpostotpgoogleenquiry');
        Route::get('/thank-you', 'staffordthanks')->name('stafford_thanks');
    });
    Route::get('/google/otplogout/stafford', 'staffordotplogout')->name('staffordotplogout');

    // Brent Park
    Route::prefix('google/plots/ambattur/brent_park')->group(function () {
        Route::get('/', 'brentparkgoogleenquiry')->name('brentparkgoogleenquiry');
        Route::post('/', 'postbrentparkgoogleenquiry');
        Route::get('/otpverify', 'brentparkshowotpgoogleenquiry')->name('brentparkgoogleurlnew');
        Route::post('/otpverify', 'brentparkpostotpgoogleenquiry');
        Route::get('/thank-you', 'brentparkthanks')->name('brentpark_thanks');
    });
    Route::get('/google/otplogout/brent_park', 'brentparkotplogout')->name('brentparkotplogout');

    // Mayfield Park
    Route::prefix('google/plots/tambaram/mayfield_park')->group(function () {
        Route::get('/', 'mayfieldparkgoogleenquiry')->name('mayfieldparkgoogleenquiry');
        Route::post('/', 'postmayfieldparkgoogleenquiry');
        Route::get('/otpverify', 'mayfieldparkshowotpgoogleenquiry')->name('mayfieldparkgoogleurlnew');
        Route::post('/otpverify', 'mayfieldparkpostotpgoogleenquiry');
        Route::get('/thank-you', 'mayfieldparkthanks')->name('mayfieldpark_thanks');
    });
    Route::get('/google/otplogout/mayfield_park', 'mayfieldparkotplogout')->name('mayfieldparkotplogout');

    // Temple Town
    Route::prefix('google/flats/thiruverkadu/temple_town')->group(function () {
        Route::get('/', 'templetowngoogleenquiry')->name('templetowngoogleenquiry');
        Route::post('/', 'posttempletowngoogleenquiry');
        Route::get('/otpverify', 'templetownshowotpgoogleenquiry')->name('templetowngoogleurlnew');
        Route::post('/otpverify', 'templetownpostotpgoogleenquiry');
        Route::get('/thank-you', 'templetownthanks')->name('templetown_thanks');
    });
    Route::get('/google/otplogout/temple_town', 'fairmontotplogout')->name('templetownotplogout'); // special logout method

    // Crofton Gardens
    Route::prefix('google/plots/avadi/crofton_gardens')->group(function () {
        Route::get('/', 'croftongardensgoogleenquiry')->name('croftongardensgoogleenquiry');
        Route::post('/', 'postcroftongardensgoogleenquiry');
        Route::get('/otpverify', 'croftongardensshowotpgoogleenquiry')->name('croftongardensgoogleurlnew');
        Route::post('/otpverify', 'croftongardenspostotpgoogleenquiry');
        Route::get('/thank-you', 'croftongardensthanks')->name('croftongardens_thanks');
    });
    Route::get('/google/otplogout/crofton_gardens', 'croftongardensotplogout')->name('croftongardensotplogout');

    // Crofton Gardens Phase II
    Route::prefix('google/plots/avadi/crofton_gardens_phase_ii')->group(function () {
        Route::get('/', 'croftongardensphaseiigoogleenquiry')->name('croftongardensphaseiigoogleenquiry');
        Route::post('/', 'postcroftongardensphaseiigoogleenquiry');
        Route::get('/otpverify', 'croftongardensphaseiishowotpgoogleenquiry')->name('croftongardensphaseiigoogleurlnew');
        Route::post('/otpverify', 'croftongardensphaseiipostotpgoogleenquiry');
        Route::get('/thank-you', 'croftongardensphaseiithanks')->name('croftongardensphaseii_thanks');
    });
    Route::get('/google/otplogout/crofton_gardens_phase_ii', 'croftongardensphaseiiotplogout')->name('croftongardensphaseiiotplogout');

    // Crofton Gardens Phase III
    Route::prefix('google/plots/avadi/crofton_gardens_phase_iii')->group(function () {
        Route::get('/', 'croftongardensphaseiiigoogleenquiry')->name('croftongardensphaseiiigoogleenquiry');
        Route::post('/', 'postcroftongardensphaseiiigoogleenquiry');
        Route::get('/otpverify', 'croftongardensphaseiiishowotpgoogleenquiry')->name('croftongardensphaseiiigoogleurlnew');
        Route::post('/otpverify', 'croftongardensphaseiiipostotpgoogleenquiry');
        Route::get('/thank-you', 'croftongardensphaseiiithanks')->name('croftongardensphaseiii_thanks');
    });
    Route::get('/google/otplogout/crofton_gardens_phase_iii', 'croftongardensphaseiiiotplogout')->name('croftongardensphaseiiiotplogout');

    // Victoria Park
    Route::prefix('google/plots/ambattur/victoria_park')->group(function () {
        Route::get('/', 'victoriaparkgoogleenquiry')->name('victoriaparkgoogleenquiry');
        Route::post('/', 'postvictoriaparkgoogleenquiry');
        Route::get('/otpverify', 'victoriaparkshowotpgoogleenquiry')->name('victoriaparkgoogleurlnew');
        Route::post('/otpverify', 'victoriaparkpostotpgoogleenquiry');
        Route::get('/thank-you', 'victoriaparkthanks')->name('victoriapark_thanks');
    });
    Route::get('/google/otplogout/victoria_park', 'victoriaparkotplogout')->name('victoriaparkotplogout');

    // Oval Gardens
    Route::prefix('google/plots/ambattur/oval_gardens')->group(function () {
        Route::get('/', 'ovalgardensgoogleenquiry')->name('ovalgardensgoogleenquiry');
        Route::post('/', 'postovalgardensgoogleenquiry');
        Route::get('/otpverify', 'ovalgardensshowotpgoogleenquiry')->name('ovalgardensgoogleurlnew');
        Route::post('/otpverify', 'ovalgardenspostotpgoogleenquiry');
        Route::get('/thank-you', 'ovalgardensgoogleenquiry')->name('ovalgardensgoogle_thanks');
    });
    Route::get('/google/otplogout/oval_gardens', 'ovalgardensotplogout')->name('ovalgardensgoogleotplogout');
});
/* end of new google urls */

Route::controller(ExternalProjectController::class)->group(function () {
    // OTP Verify
    Route::get('/extproject-otpverify/{vendor}/{name?}', 'extotpshow')
        ->where('name', '[0-9a-zA-Z_]+')->name('extotpproject');

    Route::post('/extproject-otpverify/{vendor}/{name}', 'extotpinsertlead')
        ->where('name', '[0-9a-zA-Z_]+')->name('extotpprojectleadinsert');

    // Main Project View
    Route::get('/extproject/{vendor}/{name?}', 'extshow')
        ->where('name', '[0-9a-zA-Z_]+')->name('extproject');

    Route::post('/extproject/{vendor}/{name}', 'extinsertlead')
        ->where('name', '[0-9a-zA-Z_]+')->name('extprojectleadinsert');

    // Thank You Page
    Route::get('/extproject-display/thank-you/{vendor}/{name?}', 'extthanks')
        ->name('extproject_thanks');

    // OTP Logout
    Route::get('/extproject-display/otplogout/{vendor}/{name}', 'extotplogout')
        ->where('name', '[0-9a-zA-Z_]+')->name('extotplogout');
});

/**
 * start of linkedin Url
 */
Route::controller(LinkedinController::class)->group(function () {
    // Notting Hill
    Route::get('/linkedin/flats/nungambakkam/notting_hill', 'nottinghilllinkedinenquiry')->name('nottinghilllinkedinenquiry');
    Route::post('/linkedin/flats/nungambakkam/notting_hill', 'postnottinghilllinkedinenquiry');
    Route::get('/linkedin/otpverify/flats/nungambakkam/notting_hill', 'nottinghillshowotplinkedinenquiry')->name('nottinghilllinkedinurlnew');
    Route::post('/linkedin/otpverify/flats/nungambakkam/notting_hill', 'nottinghillpostotplinkedinenquiry');
    Route::get('/linkedin/thank-you/flats/nungambakkam/notting_hill', 'nottinghillthanks')->name('nottinghill_thankslinkedin');
    Route::get('/linkedin/otplogout/notting_hill', 'nottinghillotplogout')->name('nottinghillotplogout');

    // Fairmont
    Route::get('/linkedin/flats/guindy/fairmont', 'fairmontlinkedinenquiry')->name('fairmontlinkedinenquiry');
    Route::post('/linkedin/flats/guindy/fairmont', 'postfairmontlinkedinenquiry');
    Route::get('/linkedin/otpverify/flats/guindy/fairmont', 'fairmontshowotplinkedinenquiry')->name('fairmontlinkedinurlnew');
    Route::post('/linkedin/otpverify/flats/guindy/fairmont', 'fairmontpostotplinkedinenquiry');
    Route::get('/linkedin/thank-you/flats/guindy/fairmont', 'fairmontthanks')->name('fairmont_thankslinkedin');
    Route::get('/linkedin/otplogout/fairmont', 'fairmontotplogout')->name('fairmontotplogout');

    // Oval Gardens
    Route::get('/linkedin/plots/ambattur/oval_gardens', 'ovalgardenslinkedinenquiry')->name('ovalgardenslinkedinenquiry');
    Route::post('/linkedin/plots/ambattur/oval_gardens', 'postovalgardenslinkedinenquiry');
    Route::get('/linkedin/otpverify/plots/ambattur/oval_gardens', 'ovalgardensshowotplinkedinenquiry')->name('ovalgardenslinkedinurlnew');
    Route::post('/linkedin/otpverify/plots/ambattur/oval_gardens', 'ovalgardenspostotplinkedinenquiry');
    Route::get('/linkedin/thank-you/plots/ambattur/oval_gardens', 'ovalgardensthanks')->name('ovalgardens_thankslinkedin');
    Route::get('/linkedin/otplogout/oval_gardens', 'ovalgardensotplogout')->name('ovalgardensotplogout');
});

Route::controller(TwitterprojectController::class)->group(function () {
    Route::get('/twitter-page/project/{name?}', 'twshow')->where('name', '[0-9a-zA-Z_]+')->name('twproject');
    Route::post('/twitter-page/project/{name}', 'twinsertlead')->where('name', '[0-9a-zA-Z_]+')->name('twprojectleadinsert');

    Route::get('/twitter-otpverify/project/{name?}', 'twotpshow')->where('name', '[0-9a-zA-Z_]+')->name('twotpproject');
    Route::post('/twitter-otpverify/project/{name}', 'twotpinsertlead')->where('name', '[0-9a-zA-Z_]+')->name('twotpprojectleadinsert');

    Route::get('/twitter-page/thank-you/{name?}', 'twthanks')->name('twproject_thanks');
    Route::get('/twitter-page/otplogout/{name}', 'otplogout')->where('name', '[0-9a-zA-Z_]+')->name('twotplogout');
});



Route::prefix('vendorzone')->controller(VendorzoneController::class)->group(function () {
    // Registration
    Route::get('registration', 'registration')->name('vendorregistration');
    Route::post('registration', 'postregistration');
    Route::get('otpregistration', 'otpregistration')->name('vendorotpproject');
    Route::post('otpregistration', 'postotpregistration');
    Route::post('vendorreg_filesrequired', 'vendorreg_filesrequired');
    Route::post('sendandsavevendor_registerotp', 'sendandsavevendor_registerotp');
    Route::post('validatemobileotp', 'validatemobileotp');
    Route::post('sendandsavevendor_registerotpemail', 'sendandsavevendor_registerotpemail');
    Route::post('validateemailotp', 'validateemailotp');
    Route::post('panno_validation', 'panno_validation');

    // Login & Dashboard
    Route::get('vendorlogin', 'newindex')->name('newvendor_home');
    Route::post('vendorlogin', 'logincheck');
    Route::get('dashboard/{vendid}', 'newdashboard')->name('newvendor_dashboard');
    Route::get('logout', 'newlogout');

    // My Details
    Route::get('mydetails', 'newmydetails')->name('newvendor_mydetails');
    Route::get('mydetails_changepassword', 'newmydetails_passchange')->name('newvendor_mydetails_passchange');
    Route::post('mydetails_changepassword', 'newpasswordchange');

    // Forgot Password
    Route::get('forgotpassword', 'newforgotpwd')->name('newvendforgotpassword');
    Route::post('forgotpassword', 'modifiedforgotpwd');
    Route::post('otpvalidation', 'otpvalidation');
    Route::get('resetlink', 'resetlink')->name('vendresetlink');
    Route::post('resetlink', 'postresetlink');

    // File & Form Submissions
    Route::post('editdetailsstep1', 'editdetailsstep1');
    Route::post('editdetailsstep2', 'editdetailsstep2');
    Route::post('editdetailsstep3', 'editdetailsstep3');
    Route::post('editdetailsstep4', 'editdetailsstep4');

    Route::post('editemaildetailsstep1', 'editemaildetailsstep1');
    Route::post('editemaildetailsstep2', 'editemaildetailsstep2');
    Route::post('editemaildetailsstep3', 'editemaildetailsstep3');
    Route::post('editemaildetailsstep4', 'editemaildetailsstep4');

    Route::post('editbankdetailsstep1', 'editbankdetailsstep1');
    Route::post('editbankdetailsstep2', 'editbankdetailsstep2');
    Route::post('editpasswordstep1', 'editpasswordstep1');
    Route::post('editpasswordstep2', 'editpasswordstep2');

    // Bank & Invoice
    Route::get('mybankdetails', 'mybankdetails')->name('vendbankdetails');
    Route::get('editbankdetails', 'editbankdetails');
    Route::post('editbankdetails', 'posteditbankdetails');
    Route::get('invoiceattachment', 'invoiceattachment')->name('invoiceattachment');
    Route::post('invoiceattachment', 'postinvoiceattachment');

    // Communications & Complaints
    Route::get('communication', function () {
        return view('page.under-construction');
    });
    //Route::get('communication/{size?}/{page?}', 'newcommunication')->name('newvendorcommunication');
    Route::get('complaints', 'newvendcomplaints')->name('newvendcomplaints');
    Route::get('raisecomplaints', 'newraisecomplaints')->name('newvendraisecomplaints');
    Route::post('raisecomplaints', 'newpostraisecomplaints');
    Route::post('complaints', 'newclosecomplaints');

    // Bids
    Route::get('newbidcorner', 'newbidcorner')->name('newvendbidcorner');
    Route::post('newbidcorner', 'postnewbidcorner')->name('postnewbidcorner');
    Route::get('myrecentbids', 'recentbids')->name('recentbids');
    Route::get('myrecentbids/{refno}', 'recentbidsonclick')->name('recentbidsonclick');

    // Refer & Photo
    Route::get('referfriend', 'newvendreferfriend')->name('newvendreferfriend');
    Route::post('referfriend', 'newpostvendreferfriend');
    Route::get('editphoto', 'newvendeditphoto')->name('newvendeditphoto');
    Route::post('editphoto', 'newvendposteditphoto');

    // Rate Update
    Route::get('rateupdate/{refno}', 'rateupdate')->name('rateupdate');
    Route::post('rateupdate/{refno}', 'postrateupdate')->name('postrateupdate');

    // Channel Partner
    Route::get('channel_partner_leadcreation', 'channel_partner_leadcreation');
    Route::post('channel_partner_leadcreation', 'postchannel_partner_leadcreation');
    Route::post('negotiated_discountprice', 'postnegotiated_discountprice');

    // Verified Vendor
    Route::get('verifiedvendor', 'verifiedvendor')->name('verifiedvendor');
    Route::post('verifiedvendor', 'postverifiedvendor');
    Route::get('verifiedvendorlogout', 'verifiedvendorlogout');

    // GetVerify Variants
    Route::get('getverifypangst/{vode}', 'getverifypangst')->name('getverifypangst');
    Route::post('getverifypangst/{vcode}', 'postgetverifypangst');
    Route::post('getverifysendandsavevendor_registerotp', 'getverifysendandsavevendor_registerotp');
    Route::post('getverifyvalidatemobileotp', 'getverifyvalidatemobileotp');
    Route::post('getverifysendandsavevendor_registerotpemail', 'getverifysendandsavevendor_registerotpemail');
    Route::post('getverifyvalidateemailotp', 'getverifyvalidateemailotp');
    Route::post('getverifypanno_validation', 'getverifypanno_validation');
    Route::get('getverifyverifiedvendor', 'getverifyverifiedvendor')->name('getverifyverifiedvendor');
    Route::post('getverifyverifiedvendor', 'postgetverifyverifiedvendor');
    Route::get('getverifyverifiedvendorlogout', 'getverifyverifiedvendorlogout');
});

// Additional routes outside /vendorzone
Route::get('/testvendor', 'VendorzoneController@test');
Route::get('/vthup/{code}', 'VendorzoneController@vendauthupd');
Route::get('/vendauthupdemail/{code}', 'VendorzoneController@vendauthupdemail');
Route::post('/checkvendorregfile', 'VendorzoneController@checkvendorregfile');



Route::prefix('customerzone')->controller(CustomerzoneController::class)->group(function () {
    // Login & Dashboard
    Route::get('customerlogin', 'newindex')->name('newcustomer_home');
    Route::post('customerlogin', 'logincheck');
    Route::get('dashboard/{custid}', 'newdashboard')->name('newcustomer_dashboard');
    Route::get('logout', 'newlogout');

    // My Details & Profile
    Route::get('mydetails', 'newmydetails')->name('newcustomer_mydetails');
    Route::get('mydetails_changepassword', 'newmydetails_passchange')->name('newcustomer_mydetails_passchange');
    Route::post('mydetails_changepassword', 'newpasswordchange');
    Route::get('editphoto', 'neweditphoto')->name('neweditphoto');
    Route::post('editphoto', 'newposteditphoto');

    // Complaints
    Route::get('complaints', 'newcomplaints')->name('newcomplaints');
    Route::get('raisecomplaints', 'newraisecomplaints')->name('newraisecomplaints');
    Route::post('raisecomplaints', 'newpostraisecomplaints');
    Route::get('closecomplaint', 'openclosecomplaints');
    Route::post('closecomplaint', 'postopenclosecomplaints');
    Route::post('complaints', 'newclosecomplaints');

    // Bank Details
    Route::get('mybankdetails', 'mybankdetails')->name('custbankdetails');
    Route::get('editbankdetails', 'editbankdetails');
    Route::post('editbankdetails', 'posteditbankdetails');

    // Communication & Project
    Route::get('communication', function () {
        return view('page.under-construction');
    });
    // Route::get('communication/{size?}/{page?}', 'newcommunication')->name('newcommunication');
    Route::get('paymenthistory', 'newpaymenthistory')->name('newpaymenthistory');
    Route::get('projectstatus', 'newprojectstatus')->name('newprojectstatus');

    // Snag Reports
    Route::get('inspectionsnag', 'newinspectionsnag')->name('newinspectionsnag');
    Route::get('createsnag', 'newcreatesnag')->name('newcreatesnag');
    Route::post('createsnag', 'newpostcreatesnag');
    Route::get('updatesnag/{plant}/{unit}', 'newupdatesnag')->name('newupdatesnag');
    Route::post('updatesnag', 'newpostupdatesnag');

    // Refer Friend
    Route::get('referfriend', 'newreferfriend')->name('newreferfriend');
    Route::post('referfriend', 'newpostreferfriend');

    // Forgot Password
    Route::get('forgotpassword', 'newforgotpwd')->name('newforgotpassword');
    Route::post('forgotpassword', 'modifiedforgotpwd');
    Route::post('otpvalidation', 'otpvalidation');
    Route::get('resetlink', 'resetlink')->name('resetlink');
    Route::post('resetlink', 'postresetlink');

    // Satisfaction Survey
    Route::get('customer_satisfaction_survey', 'customer_satisfaction_survey');
    Route::post('customer_satisfaction_survey', 'post_customer_satisfaction_survey');

    // WhatsApp Schedulers
    Route::get('whatsapp_schedular', 'whatsapp_schedular');
    Route::get('whatsapp_schedular_warm_hot_underfollowup', 'whatsapp_schedular_for_warm_hot_underfollowup_promotionla');
    Route::get('runcustomerzone_schedular', 'Schedular_run_for_SAP_to_DB');

    // Registration Details
    Route::get('registrationdetails', 'registrationdetails')->name('registrationdetails');
    Route::post('registrationdetails', 'postregistrationdetails');
    Route::post('getcustomer_reg_details', 'getregistereddata');
    Route::post('checkcustomersaleagreement', 'checksale_agreement_taken');
    Route::post('generate_otp', 'generate_otp');

    // Photo Upload
    Route::get('customerphotoupload', 'customerphotoupload')->name('customerphotoupload');
    Route::post('csphotouploadgetdata', 'csphotouploadgetdata');
    Route::post('customerphoto_nameupdate', 'customerphoto_nameupdate');
    Route::post('photoupload', 'postcustomerphotoupload');
    Route::post('getcustomeruploadedphotos', 'getcustomeruploadedphotos');
    Route::post('deleteuploadedphoto', 'deleteuploadedphoto');

    // Occupant Details
    Route::get('occupantdetails', function () {
        return view('page.under-construction');
    });
    // Route::get('occupantdetails', 'occupantdetailsshow');
    // Route::get('showoccupantdetails', 'showuploadedoccupantdetails');
    // Route::post('occupantdetails', 'postoccupantdetailsshow');

    // Rent Sell
    Route::get('rentsellmyunit', 'rentsellmyunit');
    Route::post('rentsellmyunit', 'postrentsellmyunit');
});

Route::controller(CustomerzoneController::class)->group(function () {
    // Customer Satisfaction Survey
    Route::prefix('csurvey')->group(function () {
        Route::get('/{customerid}', 'open_customer_satisfaction_survey');
        Route::post('/{customerid}', 'post_open_customer_satisfaction_ratings');
    });
    // Site Visit Feedback
    Route::prefix('svfb')->group(function () {
        Route::get('/{leadid}', 'sitevisitfeedback');
        Route::post('/{leadid}', 'postsitevisitfeedback');
    });
    // Sale Registration
    Route::prefix('salereg')->group(function () {
        Route::get('/{customerid}', 'saleregopen')->name('saleregopen');
        Route::post('/{customerid}', 'postsaleregopen');
    });
    // Occupant Details
    Route::get('/ocpd/{id}', 'open_occupantdetailsshow');
    Route::post('/ocpd/{id}', 'open_postoccupantdetailsshow');
    Route::get('/socpd/{id}', 'open_showuploadedoccupantdetails');
    // Rent/Sell Unit
    Route::get('/rsu/{id}', 'openrentsellunit');
    Route::post('/rsu/{id}', 'post_openrentsellunit');
    Route::post('/opencheckrsu/{id}', 'open_checkunitrentsell');
    Route::post('/checkrsu', 'checkunitrentsell');
    // TATA Smart Flow APIs
    Route::get('/collectcustomerid', 'collectcustomerid');
    Route::get('/collect_customer_mobile_number', 'collect_customer_mobile_number');
    Route::get('/collect_customer_mobile_number_using_leadno', 'collect_customer_mobile_number_using_leadno');
    Route::get('/tata-dail-plan-api-one-customerid', 'tata_first_dailplan_api_custid');
    // Dissatisfaction Trigger
    Route::post('/checksurvey/triggerdissatisfactionsmsmail', 'triggerdissatisfactionsmsmail');
    // Interest Surveys
    Route::prefix('ids')->group(function () {
        Route::get('/{saleordernumber}', 'interior_design_interested_survey');
        Route::post('/{saleordernumber}', 'post_interior_design_interested_survey');
    });
    Route::prefix('hbs')->group(function () {
        Route::get('/{saleordernumber}', 'homebuilding_interested_survey');
        Route::post('/{saleordernumber}', 'post_homebuilding_interested_survey');
    });
    Route::prefix('plc')->group(function () {
        Route::get('/{saleordernumber}', 'plotcare_interested_survey');
        Route::post('/{saleordernumber}', 'post_plotcare_interested_survey');
    });

    Route::get('/customerzone/whatsapp_cron_initiate', 'whatsapp_cron_initiate');

    //delete whatsapp records
    Route::get('/customerzone/deleteOldWhatsappRecords', 'deleteOldWhatsappRecords');



});

// Bulk SMS/Email
// Route::controller(BulksmsemailController::class)->group(function () {
//     Route::get('/processbulksmsemail', 'process_sms');
//     Route::get('/loadbulksmstosend', 'loadbulksmstosend');
// });


//Billdesk - Not in Use
Route::controller(BilldeskController::class)->group(function () {
    // Customerzone Payment
    Route::get('/customerzone/payonline', 'customerzoneonlinepayment')->name('paymentpage');
    Route::post('/customerzone/payonline', 'postcustomerzoneonlinepayment');
    Route::get('/customerzone/onlinepayment', 'processonlinepayment')->name('paymentredirectpage');
    Route::post('/customerzone/getnetbalance', 'getnetbalance');

    // Payment Link
    Route::get('/newgeneratepaymentlink', 'newgeneratepaymentlink');
    Route::get('/bps/{shortcode}', 'paymentlink1home')->name('paymentlink1page');
    Route::post('/bps/{shortcode}', 'paymentlink1');

    // BPS Response
    Route::get('/bps_response', 'bps_response')->name('bps_responseview');
    Route::post('/bps_response', 'postbps_response');
});

Route::get('/news', 'NewsController@index')->name('news');
Route::get('/sponsorships', 'HomeController@sponsorships')->name('sponsorships');
Route::get('/vgnsitemap', 'HomeController@sitemap');

//Aadhaar verification routes
Route::post('/aadhaarverify/genotp', 'AadhaarController@gentop');
Route::post('/aadhaarverify/submitotp', 'AadhaarController@submitotp');


//Admin Controll
Route::get('/login_from_calling945', 'AdminController@login_from_calling945');
Route::get('/apidailplanconfigintodb', 'AdminController@apidailplanconfigintodb');
Route::get('/apidailplanupdateconfigintodb', 'AdminController@apidailplanupdateconfigintodb');
Route::get('/listdailplanconfig', 'AdminController@listdailplanconfig');

//feth inbond call
Route::post('/inbondcall_from_tatasmartflo', 'AmeyoController@inbondcall_from_tatasmartflo');
Route::get('/inbondcall_from_tatasmartflo', 'AmeyoController@inbondcall_from_tatasmartflo');
Route::get('/tata_inbond_call_datafetch', 'AmeyoController@tata_inbond_call_datafetch');


//calling945 report
Route::get('/dailyCallReport', 'AmeyoController@dailyCallReport');
Route::get('/calling945_report_job', 'AmeyoController@calling945_report_job');




Route::fallback(function () {
    return view('page.404');
});

//Redirections from old removed links to new ones (to avoid 404 errors and keep the SEO of previous links to the new ones)
$redirections = [
    '/vgn' => '/',
    '/vgn/' => '/',
    '/vgn/home' => '/',
    '/aboutus' => '/about-us',
    '/contact_us' => '/contact',
    '/fairmont/Buy-premium-flats-Guindy' => '/projects/fairmont-guindy-chennai',
    '/notting_hill/Flats-for-sale-nungambakkam' => '/projects/notting-hill-nungambakkam-chennai',
    '/brixton/Residential-Property-Irungattukottai' => '/projects/brixton-irungattukottai-chennai',
    '/projects/brixton-Irungattukottai-chennai' => '/projects/brixton-irungattukottai-chennai',
    '/fairmont/thank-you/Buy-premium-flats-Guindy' => '/projects/fairmont-guindy-chennai-thank-you',
    '/notting_hill/thank-you/Flats-for-sale-nungambakkam' => '/projects/notting-hill-nungambakkam-chennai-thank-you',
    '/brixton/thank-you/Residential-Property-Irungattukottai' => '/projects/brixton-irungattukottai-chennai-thank-you',
    '/search' => '/',
    '/Flat-Builders-Chennai' => '/',
    '/history_of_vgn' => '/about-us',
    '/Premium-Real-Estate-Developers-in-Chennai' => '/',
    '/wp-content/uploads/2015/11/presidency-brouchure.pdf' => '/projects/notting-hill-nungambakkam-chennai',
    '/vgn-engineer' => '/careers',
    '/vgn-foreman-civil' => '/careers',
    '/vgn-front-office-exec' => '/careers',
    '/vgn-supervisor' => '/careers',
    '/awards' => '/about-us',
];

foreach ($redirections as $oldUrl => $newUrl) {
    Route::get($oldUrl, function () use ($newUrl) {
        return redirect($newUrl, 301);
    });
}




//Msproject
// Route::post('/msppercentageupdate', 'MsprojectController@msproject_update_percentage');
// Route::post('/msproject_fetchstetdate', 'MsprojectController@msproject_fetchstetdate');

//employee zone
// Route::get('/employeezone/employeelogin', 'EmployeezoneController@newindex')->name('newemployee_home');
// Route::get('/employeezone/vgnticket_redirection', 'EmployeezoneController@vgnticket_redirection');
// Route::get('/employeezone/checkandinactive_ticketsystem', 'EmployeezoneController@checkandinactive_ticketsystem');
// Route::get('/changeprojectstatus/{status}/{id}', 'EmployeezoneController@changeprojectstatus');
// Route::post('/employeezone/employeelogin', 'EmployeezoneController@newlogin');
// Route::get('/employeezone/dashboard/{empid}', 'EmployeezoneController@newdashboard')->name('newemployee_dashboard');
// Route::get('/employeezone/logout', 'EmployeezoneController@newlogout');
// Route::get('/employeezone/mydetails', 'EmployeezoneController@newmydetails')->name('newemployee_mydetails');
// Route::get('/employeezone/changemydetails', 'EmployeezoneController@newchangemydetails');
// Route::post('/employeezone/changemydetails', 'EmployeezoneController@newpostchangemydetails');
// Route::get('/employeezone/mydetails_changepassword', 'EmployeezoneController@newmydetails_passchange')->name('newemployee_mydetails_passchange');
// Route::post('/employeezone/mydetails_changepassword', 'EmployeezoneController@newpasswordchange');
// Route::get('/employeezone/forgotpassword', 'EmployeezoneController@newforgotpwd')->name('newemployeeforgotpassword');
// Route::post('/employeezone/forgotpassword', 'EmployeezoneController@newpostforgotpwd');
// Route::get('/employeezone/resetpassword/{id}/{key}', 'EmployeezoneController@resetpassword')->name('employeeresetpassword');
// Route::post('/employeezone/resetpassword/{id}/{key}', 'EmployeezoneController@postresetpassword');
// Route::get('/employeezone/mynoticeboard', 'EmployeezoneController@noticeboard')->name('employeenoticeboard');
// Route::get('/employeezone/forgotpassword', 'EmployeezoneController@newforgotpwd')->name('newempforgotpassword');
// Route::post('/employeezone/forgotpassword', 'EmployeezoneController@modifiedforgotpwd');
// Route::post('/employeezone/otpvalidation','EmployeezoneController@otpvalidation');
// Route::get('/employeezone/resetlink','EmployeezoneController@resetlink')->name('empresetlink');;
// Route::post('/employeezone/resetlink','EmployeezoneController@postresetlink');
// Route::get('/employeezone/leadsfollowup/{plantcode?}', 'EmployeezoneController@leadsfollowup')->name('leadsfollowup');
// Route::post('/employeezone/leadsfollowup/{plantcode?}', 'EmployeezoneController@postleadsfollowup');
// Route::get('/employeezone/getleadstypedata/{type}', 'EmployeezoneController@getleadstypedata')->name('getleadstypedata');
// Route::get('/employeezone/leadsfollowreference/{type}/{leadno}', 'EmployeezoneController@leadsfollowreference')->name('leadsfollowreference');
// Route::post('/employeezone/sendsmsforleads', 'EmployeezoneController@sendsmsforleads')->name('sendsmsforleads');
// Route::post('/employeezone/getsingleunits', 'EmployeezoneController@getsingleunits');
// Route::get('/employeezone/leadfollowupviewquote', 'EmployeezoneController@leadfollowupviewquote')->name('leadfollowupviewquote');
// Route::post('/employeezone/leadfollowupviewquote', 'EmployeezoneController@postleadfollowupviewquote');
// Route::get('/employeezone/esalesdiary/{type}', 'EmployeezoneController@esalesdiary');
// Route::get('/employeezone/availstatus/{plantcode}', 'EmployeezoneController@availstatus');
// Route::get('/employeezone/script/{type}', 'EmployeezoneController@leadscript')->name('leadscript');
// Route::get('/employeezone/leadscriptdetails/{type}/{plantid}', 'EmployeezoneController@viewleadscript');
// Route::get('/employeezone/printviewleadscript/{type}/{plantcode}', 'EmployeezoneController@printviewleadscript');
// Route::get('/employeezone/leadsdetail/{type}/{typeview}', 'EmployeezoneController@typeview');
// Route::post('/employeezone/insertleadsfollowup', 'EmployeezoneController@insertleadsfollowup');
// Route::get('/employeezone/todayfollowup', 'EmployeezoneController@todayfollowup');
// Route::post('/employeezone/expecteddob', 'EmployeezoneController@postexpecteddob');
// Route::post('/employeezone/forapproval_mngr', 'EmployeezoneController@postforapproval_mngr');
// Route::get('/employeezone/requestforcoldapproval', 'EmployeezoneController@requestforcoldapproval');
// Route::get('/employeezone/complaints', 'EmployeezoneController@newempcomplaints')->name('newvendcomplaints');
// Route::get('/employeezone/raisecomplaints', 'EmployeezoneController@newraisecomplaints')->name('newempraisecomplaints');
// Route::post('/employeezone/raisecomplaints', 'EmployeezoneController@newpostraisecomplaints');
// Route::post('/employeezone/complaints', 'EmployeezoneController@newclosecomplaints');
// Route::get('/employeezone/myattendance', 'EmployeezoneController@newmyattendance')->name('newmyattendance');
// Route::post('/employeezone/myattendance', 'EmployeezoneController@newpostmyattendance');
// Route::get('/employeezone/holidaycalendar', 'EmployeezoneController@newholidaycalendar')->name('newholidaycalendar');
// Route::post('/employeezone/holidaycalendar', 'EmployeezoneController@newpostholidaycalendar');
// Route::post('/employeezone/getevents', 'EmployeezoneController@getevents');
// Route::post('/employeezone/deleteevents', 'EmployeezoneController@deleteevents');
// Route::get('/employeezone/empreferfriend', 'EmployeezoneController@emprefer_a_friend')->name('newempreferfriend');
// Route::get('/employeezone/empreferfriendapplyjob/{plant}/{ref1}/{ref2}', 'EmployeezoneController@emprefer_a_friend_applyjob');
// Route::post('/employeezone/empreferfriendapplyjob/{plant}/{ref1}/{ref2}', 'EmployeezoneController@postemprefer_a_friend_applyjob');
// Route::get('/employeezone/reportingstructure', 'EmployeezoneController@reportingstructure')->name('reportingstructure');
// Route::get('/employeezone/newreportingstructure', 'EmployeezoneController@newreportingstructure')->name('newreportingstructure');
// Route::get('/employeezone/empmemos', 'EmployeezoneController@empmemos')->name('empmemos');
// Route::get('/employeezone/hrpolicy', 'EmployeezoneController@hrpolicy')->name('hrpolicy');
// Route::get('/employeezone/mydutiesandresponsibilities', 'EmployeezoneController@mydutiesandresponsibilities')->name('mydutiesandresponsibilities');
// Route::get('/employeezone/empeligibility', 'EmployeezoneController@empeligibility')->name('empeligibility');
// Route::post('/employeezone/empeligibility', 'EmployeezoneController@postempeligibility');
// Route::get('/employeezone/leadselection', 'EmployeezoneController@leadselection')->name('leadselection');
// Route::post('/employeezone/leadselection', 'EmployeezoneController@postleadselection');
// Route::get('/employeezone/filterleadselection', 'EmployeezoneController@filterleadselection')->name('filterleadselection');
// Route::get('/employeezone/customercreationstep1/{leadno}', 'EmployeezoneController@customercreationstep1')->name('customercreationstep1');
// Route::post('/employeezone/customercreationstep1/{leadno}', 'EmployeezoneController@postcustomercreationstep1');
// Route::get('/employeezone/customercreationstep2', 'EmployeezoneController@customercreationstep2')->name('customercreationstep2');
// Route::post('/employeezone/customercreationstep2','EmployeezoneController@postcustomercreationstep2');
// Route::get('/employeezone/saleorderconversion', 'EmployeezoneController@saleorderconversion')->name('saleorderconversion');
// Route::post('/employeezone/uploadsaleorderfile', 'EmployeezoneController@uploadsaleorderfile');
// Route::post('/employeezone/createsaleorder', 'EmployeezoneController@createsaleorder');
// Route::get('/employeezone/viewuploadedsaleorderfiles', 'EmployeezoneController@viewuploadedsaleorderfiles')->name('viewuploadedsaleorderfiles');
// Route::post('/employeezone/viewquote', 'EmployeezoneController@viewquote');
// Route::get('/employeezone/viewquote', 'EmployeezoneController@getviewquote');
// Route::post('/employeezone/getunits', 'EmployeezoneController@getunits');
// Route::post('/employeezone/getpaymentterms', 'EmployeezoneController@getpaymentterms');
// Route::get('/employeezone/empstock', 'EmployeezoneController@empstock')->name('empstock');
// Route::get('/employeezone/payslip', 'EmployeezoneController@payslip')->name('payslip');
// Route::post('/employeezone/viewpayslip', 'EmployeezoneController@postpayslip');
// Route::get('/employeezone/viewpayslip', 'EmployeezoneController@getviewpayslip');
// Route::get('/employeezone/emprequest', 'EmployeezoneController@emprequest')->name('emprequest');
// Route::post('/employeezone/emprequest', 'EmployeezoneController@postemprequest');
// Route::get('/employeezone/empraiserequest', 'EmployeezoneController@empraiserequest')->name('empraiserequest');
// Route::post('/employeezone/empraiserequest', 'EmployeezoneController@postempraiserequest');
// Route::get('/employeezone/mytraining', 'EmployeezoneController@mytraining')->name('mytraining');
// Route::get('/employeezone/feedback', 'EmployeezoneController@feedback')->name('feedback');
// Route::post('/employeezone/feedback', 'EmployeezoneController@postfeedback');
// Route::get('/employeezone/form16', 'EmployeezoneController@form16');
// Route::post('/employeezone/form16', 'EmployeezoneController@postform16');
// Route::get('/employeezone/bulkleadupload', 'EmployeezoneController@bulkleadupload');
// Route::post('/employeezone/bulkleadupload', 'EmployeezoneController@postbulkleadupload');
// Route::get('/employeezone/downloadcustomerphoto','EmployeezoneController@downloadcustomerphoto');
// Route::post('/employeezone/downloadcustomerphoto','EmployeezoneController@postdownloadcustomerphoto');
// Route::post('/employeezone/print_taken', 'EmployeezoneController@postprint_taken');
// Route::get('/employeezone/jobapplications','EmployeezoneController@jobapplications');
// Route::get('/employeezone/empbankdetails', 'EmployeezoneController@empbankdetails')->name('empbankdetails');
// Route::get('/employeezone/editempbankdetails', 'EmployeezoneController@editempbankdetails');
// Route::post('/employeezone/editempbankdetails', 'EmployeezoneController@posteditempbankdetails');

//add and list api key only MD emp account 
// Route::get('/employeezone/vendro_auth_key_insert', 'EmployeezoneController@vendro_auth_key_insert')->name('add_api_key');
// Route::post('/employeezone/add_api_key', 'EmployeezoneController@add_api_key')->name('add_api_key');

// Route::get('/employeezone/vendro_auth_key_insert/{id}', 'EmployeezoneController@edit_api_form')->name('edit_api_form');
// Route::post('/employeezone/vendro_auth_key_update/{id}', 'EmployeezoneController@update_api_form')->name('update_api_form');

// Route::get('/employeezone/list_api_key', 'EmployeezoneController@list_api_key')->name('list_api_key');
// Route::get('/employeezone/editphoto', 'EmployeezoneController@newempeditphoto')->name('newempeditphoto');
// Route::post('/employeezone/editphoto', 'EmployeezoneController@newempposteditphoto');
// Route::get('/employeezone/viewschedulesitevisitmap/{leadno}/{mobile}', 'EmployeezoneController@viewschedulesitevisitmap')->name('viewschedulesitevisit');
// Route::post('/employeezone/viewschedulesitevisitmap/{leadno}/{mobile}', 'EmployeezoneController@postviewschedulesitevisitmap');
// Route::get('/employeezone/postedschedulesitevisitmap/{leadno}/{mobile}', 'EmployeezoneController@postedschedulesitevisitmap')->name('postedsitevisit');
// Route::get('/employeezone/editschedulesitevisitmap/{leadno}/{mobile}', 'EmployeezoneController@editschedulesitevisitmap')->name('editpostedsitevisit');
// Route::post('/employeezone/editschedulesitevisitmap/{leadno}/{mobile}', 'EmployeezoneController@posteditschedulesitevisitmap');
// Route::post('/selldo_4thapi', 'EmployeezoneController@selldo_4thapi');
// Route::post('/selldo_5thapi', 'EmployeezoneController@selldo_5thapi');
// Route::post('/manual_leave_quota', 'EmployeezoneController@leavequota_manualentry');
// Route::get('/employeezone/getlistofvendorskycupdated', 'EmployeezoneController@getlistofvendorskycupdated');
Route::post('/landowners', 'EmployeezoneController@landowners');
Route::get('/landownersform', 'EmployeezoneController@landownersform');

//lms
// Route::get('/employeezone/leavemanagementsystem', 'LMSController@index')->name('lmshome');
// Route::get('/employeezone/lms/employee_request_application/{id}', 'LMSController@requestapplication')->name('request_application');
// Route::get('/employeezone/lms/viewallapplication', 'LMSController@viewallapplication')->name('viewallapplication');
// Route::post('/employeezone/lms/employee_request_application/{id}', 'NewLMSController@postleaveapplication');
// Route::get('/employeezone/lms/compoff', 'NewLMSController@compoff')->name('compoff');
// Route::post('/employeezone/lms/compoff', 'NewLMSController@postcompoff');
// Route::get('/employeezone/lms/lop', 'NewLMSController@lop')->name('lop');
// Route::post('/employeezone/lms/lop', 'NewLMSController@newpostlop');
// Route::get('/employeezone/lms/mispunch', 'NewLMSController@mispunch')->name('mispunch');
// Route::post('/employeezone/lms/mispunch', 'NewLMSController@postmispunch');
// Route::get('/employeezone/lms/hodreport', 'LMSController@hodreport')->name('hodreport');
// Route::post('/employeezone/lms/hodreport', 'LMSController@posthodreport');
// Route::get('/employeezone/lms/payrollprocess_screen', 'NewLMSController@payrollprocess_screen')->name('payrollprocess_screen');
// Route::post('/employeezone/lms/payrollprocess_clrduplicterecords', 'NewLMSController@payrollprocess_clrduplicterecords');
// Route::get('/employeezone/lms/subordinate_application', 'NewLMSController@subordinate_application')->name('subordinate_application');
// Route::post('/employeezone/lms/subordinate_application', 'NewLMSController@postsubordinate_application');
// Route::post('/employeezone/lms/runautoapprove_forautorejection', 'NewLMSController@autorejecton_approve');
// Route::post('/employeezone/lms/runautoapprove_forpending', 'NewLMSController@runautoapprove_forpending');
// Route::post('/employeezone/lms/make_a_newemployee_balance_record', 'NewLMSController@make_a_newemployee_balance_record');
// Route::post('/employeezone/lms/startpayrollprocessinportal', 'NewLMSController@startpayrollprocessinportal');
// Route::post('/employeezone/lms/sendlatetosapviaportal', 'NewLMSController@sendlatetosapviaportal');
// Route::post('/employeezone/lms/sendapprovedappltosapviaportal', 'NewLMSController@sendapprovedappltosapviaportal');
// Route::post('/employeezone/lms/sendapprovedapplicationsprocess', 'NewLMSController@sendapprovedapplicationsprocess');
// Route::post('/employeezone/lms/downloadleavebalance', 'NewLMSController@downloadleavebalance');
// Route::post('/employeezone/lms/downloadleaveappl', 'NewLMSController@downloadleaveappl');
// Route::post('/employeezone/lms/downloadleavedatetimeref', 'NewLMSController@downloadleavedatetimeref');
// Route::post('/employeezone/lms/downloadlateappl', 'NewLMSController@downloadlateappl');
// Route::post('/employeezone/saveactive_emplisttodb', 'EmployeezoneController@saveactive_emplisttodb');
// Route::post('/employeezone/lms/intercompanytransfer','NewLMSController@intercompanytransfer');
// Route::post('/employeezone/lms/addrestrictholiday', 'NewLMSController@addrestrictholiday');
// Route::post('/employeezone/lms/downloadpayrollview', 'NewLMSController@downloadpayrollview');
// Route::post('/employeezone/lms/payrollviewsession', 'NewLMSController@payrollviewsession');
// Route::get('/employeezone/lms/admin_application', 'NewLMSController@admin_application')->name('admin_application');
// Route::post('/employeezone/lms/admin_application', 'NewLMSController@postadmin_application');
// Route::get('/employeezone/lms/hodoperation/{hod_status}/{hashedkey}', 'NewLMSController@hodleaveoperation');
// Route::post('/employeezone/lms/hodoperation/{hod_status}/{hashedkey}', 'NewLMSController@posthodleaveoperation');
// Route::get('/employeezone/lms/adminoperation/{admin_status}/{hashedkey}', 'NewLMSController@adminleaveoperation');
// Route::post('/employeezone/lms/adminoperation/{admin_status}/{hashedkey}', 'NewLMSController@postadminleaveoperation');
// Route::post('/employeezone/lms/getcompoffpunches', 'NewLMSController@getcompoffpunches');
// Route::post('/employeezone/lms/getleavebalance', 'NewLMSController@getleavebalancedata');
// Route::post('/employeezone/lms/getodpunches', 'NewLMSController@getnewodpunches');
// Route::post('/employeezone/lms/getodmissing_punch', 'NewLMSController@getodmissing_punch');
// Route::post('/employeezone/lms/getfinaloneodpunch', 'NewLMSController@getfinaloneodpunch');
// Route::post('/employeezone/lms/getsubordinatepunches', 'NewLMSController@getsubordinatepunches');
// Route::get('/employeezone/lms/viewemployee_punches', 'NewLMSController@viewemployee_punches');
// Route::get('/employeezone/lms/view_overall_employee_punches', 'NewLMSController@view_overall_employee_punches');
// Route::get('/employeezone/lms/newmyattendance', 'NewLMSController@newmyattendance');

//sendmailqueue
// Route::get('/employeezone/lms/sendmail', 'NewLMSController@lmsmailsendqueue');
//automatic rejection within 3 days
// Route::get('/employeezone/lms/auto_rejection_script', 'NewLMSController@auto_rejection_script');
// Route::get('/employeezone/myattendance_1', 'NewLMSController@attendance_sheet')->name('attendance_sheet');
// Route::get('/employeezone/sendlmsdatatosap', 'NewLMSController@sendlmsdatatosap');
// Route::get('/employeezone/latesprocess', 'NewLMSController@latesprocess');
// Route::get('/employeezone/lms/attendance_view', 'NewLMSController@attendance_view');
// Route::post('/employeezone/lms/attendance_view', 'NewLMSController@postattendance_view');
//acrual process
//one process - starts at 1 am
// Route::get('/employeezone/lms/load_data_for_late_deduction', 'NewLMSController@load_data_for_late_deduction');
//multiple process until completes
// Route::get('/employeezone/lms/lateprocess_accrual', 'NewLMSController@lateprocess_accrual');
//one process - starts at 2 am
// Route::get('/employeezone/lms/load_data_for_accrualprocess', 'NewLMSController@load_data_for_accrualprocess');
//one process - starts at 5 am
// Route::get('/employeezone/lms/leave_balance_accrual', 'NewLMSController@leave_balance_accrual');
// Route::get('/employeezone/lms/loaddailylate', 'NewLMSController@daily_process_load_data_for_late_deduction');
// Route::get('/employeezone/lms/latescriptrun', 'NewLMSController@latescriptrun');
// Route::get('/employeezone/lms/monthly_deductions_screen', 'NewLMSController@monthly_deductions_screen')->name('daily_latededuction_screen');
// Route::get('/employeezone/lms/dailylatescript3hoursintervel', 'NewLMSController@dailylatescript3hoursinterval');
// Route::get('/employeezone/lms/fullmonthod', 'NewLMSController@sendfullmonthod');
// Route::get('/employeezone/lms/overall_employeeattendance', 'NewLMSController@overall_employeeattendance');
// Route::post('/employeezone/lms/overall_employeeattendance', 'NewLMSController@postoverall_employeeattendance');
// Route::get('/employeezone/lms/payroll_reportview', 'NewLMSController@payroll_reportview');
// Route::get('/employeezone/lms/savepayrolldata', 'NewLMSController@savepayrolldata' );
// Route::get('/employeezone/lms/processremainderemailsms', 'NewLMSController@remaindermail_sms');
// Route::get('/employeezone/lms/sendremaindermail_hod', 'NewLMSController@sendremaindermail_hod');
// Route::get('/employeezone/lms/sendremaindermail_emp', 'NewLMSController@sendremaindermail_emp');
// Route::get('/employeezone/lms/leavecrudhr', 'NewLMSController@leavecrudhr');
// Route::post('/employeezone/lms/leavecrudhr', 'NewLMSController@postleavecrudhr');
// Route::post('/employeezone/lms/leavecrudhr_bal', 'NewLMSController@postleavecrudhr_bal');
// Route::post('/employeezone/lms/employeedeleteleave', 'NewLMSController@employeedeleteleave');
// Route::post('/employeezone/lms/employeedeleteleaverequest_tohod', 'NewLMSController@employeedeleteleaverequest_tohod');
// Route::get('/employeezone/lms/hoddeleteleaveurl/{hashkey}', 'NewLMSController@hoddeleteleaveurl');
// Route::get('/employeezone/lms/applications_delete_request', 'NewLMSController@applications_delete_request');
// Route::post('/employeezone/lms/postdate_leavecrudhr', 'NewLMSController@postdate_leavecrudhr');
// Route::get('/employeezone/lms/sendapplication_with_range', 'NewLMSController@sendapplication_with_range');
// Route::get('/employeezone/reversesentloplate', 'NewLMSController@reversesentloplate');
// Route::get('/deleteuploaded_late','NewLMSController@deleteuploadedlate');
// Route::get('/openpayrollmonthtoedit/{month}/{year}', 'NewLMSController@openpayrollmonthtoedit');
// Route::get('/latescriptrunopen/{month}/{year}', 'NewLMSController@latescriptrunopen');
// Route::get('/viewapprovedapplication/{empid}/{month}/{year}', 'NewLMSController@viewapprovedapplication');
// Route::get('/employeezone/lms/attendancecorrection', 'NewLMSController@leavecrudhr');
// Route::post('/employeezone/lms/attendancecorrection', 'NewLMSController@postleavecrudhr');
// Route::post('/employeezone/lms/attendancecorrection_bal', 'NewLMSController@postleavecrudhr_bal');
// Route::post('/employeezone/lms/postdate_attendancecorrection', 'NewLMSController@postdate_leavecrudhr');

//vgnhomes
// Route::get('/vgnhomes/signin', 'vgnhomesController@index')->name('vgnhomessignin');
// Route::post('/vgnhomes/signin', 'vgnhomesController@postindex');
// Route::get('/vgnhomes/leads', 'vgnhomesController@showleads')->name('showleads');
// Route::post('/vgnhomes/leads', 'vgnhomesController@postleads');
// Route::get('/vgnhomes/changepassword', 'vgnhomesController@changepwd')->name('changepwd');
// Route::post('/vgnhomes/changepassword', 'vgnhomesController@postchangepwd');
// Route::get('/vgnhomes/logout', 'vgnhomesController@logoutvgnhomes')->name('logoutvgnhomes');
// Route::get('/vgnhomesleads/copyvgnleadsandsendmail_to_homes','vgnhomesController@copyvgnleadsandsendmail_to_homes');

//ivrsfeedback
// Route::get('/ivrs/signin', 'IVRSController@index')->name('ivrssignin');
// Route::post('/ivrs/signin', 'IVRSController@postindex');
// Route::get('/ivrs/feedback', 'IVRSController@showfeedback')->name('showfeedback');
// Route::post('/ivrs/feedback', 'IVRSController@postfeedback');
// Route::get('/ivrs/changepassword', 'IVRSController@changepwd')->name('ivrschangepwd');
// Route::post('/ivrs/changepassword', 'IVRSController@postchangepwd');
// Route::get('/ivrs/logout', 'IVRSController@logoutivrs')->name('logoutivrs');

//Report
// Route::get('/leadreport', 'ReportController@show')->name('report');
// Route::post('/leadreport', 'ReportController@postlead')->name('postreport');

//Cache clear
// Route::get('/clear-cache', function() {
//     Artisan::call('cache:clear');
//     return 'Application cache has been cleared';
// });
// Route::get('/route-cache', function() {
//     Artisan::call('route:cache');
//     return 'Routes cache has been cleared';
// });
// Route::get('/config-cache', function() {
//     Artisan::call('config:cache');
//     return 'Config cache has been cleared';
// }); 
// Route::get('/view-cache', function() {
//     Artisan::call('view:clear');
//     return 'View cache has been cleared';
// });
// Route::get('/all-cache', function() {
//     Artisan::call('optimize:clear');
//     return 'All cache has been cleared';
// });




//Route::get('/hr/resumes', 'AboutController@resumeaccess')->name('resumeaccess');
//Route::get('/testinglms', 'NewLMSController@testinglms');



// Route::get('/nri/project/{name?}', 'AbroadController@show')->where(['name' => '[0-9a-zA-Z\_]+'])->name('nriproject');
// Route::post('/nri/project/{name}', 'AbroadController@insertlead')->where(['name' => '[0-9a-zA-Z\_]+'])->name('nriprojectleadinsert');
// Route::get('/nri/thank-you/{name?}', 'AbroadController@thanks')->name('nriproject_thanks');

//Route::get('/googlemap/{projectname}', 'ProjectController@googlemap')->name('googlemap');
//Route::get('/embeddedgooglemap/{projectname}', 'ProjectController@embeddedgooglemap')->name('embeddedgooglemap');




//Route::get('/facebook/project/{name?}', 'FBProjectController@fbshow')->where(['name' => '[0-9a-zA-Z\_]+'])->name('fbproject');
//Route::post('/facebook/project/{name}', 'FBProjectController@fbinsertlead')->where(['name' => '[0-9a-zA-Z\_]+'])->name('fbprojectleadinsert');


// Route::post('/projectdetails_crud', 'HomeController@projectdetails_crud');
// Route::post('/projectdetails_crud_update', 'HomeController@projectdetails_crud_update');
// Route::post('/projectsqftins_update', 'HomeController@projectsqftins_update');


// Route::get('/', 'HomeController@index')->name('home');


// Route::post('/', 'HomeController@contactpost');


/*Route::any('/employeezone/{name1?}/{name2?}/{name3?}/{name4?}/{name5?}/{name6?}', function ()
{
    return view('maintenance');
});

Route::any('/customerzone/{name1?}/{name2?}/{name3?}/{name4?}/{name5?}/{name6?}', function ()
{
    return view('maintenance');
});

Route::any('/vendorzone/{name1?}/{name2?}/{name3?}/{name4?}/{name5?}/{name6?}', function ()
{
    return view('maintenance');
});*/

// Route::get('/landownersdata', 'EmployeezoneController@landownersData');

/*Fairmont*/
// Route::get('/google/flats/guindy/fairmont', 'GoogleProjectController@fairmontgoogleenquiry')->name('fairmontgoogleenquiry');
// Route::post('/google/flats/guindy/fairmont', 'GoogleProjectController@postfairmontgoogleenquiry');
// Route::get('/google/otpverify/flats/guindy/fairmont', 'GoogleProjectController@fairmontshowotpgoogleenquiry')->name('fairmontgoogleurlnew');
// Route::post('/google/otpverify/flats/guindy/fairmont', 'GoogleProjectController@fairmontpostotpgoogleenquiry');
// Route::get('/google/thank-you/flats/guindy/fairmont', 'GoogleProjectController@fairmontthanks')->name('fairmont_thanks');
// Route::get('/google/otplogout/fairmont', 'GoogleProjectController@fairmontotplogout')->name('fairmontotplogout');


//Route::get('/facebook-display/project/{name?}', 'FBProjectController@gdshow')->where(['name' => '[0-9a-zA-Z\_]+'])->name('fproject');
//Route::post('/facebook-display/project/{name}', 'FBProjectController@gdinsertlead')->where(['name' => '[0-9a-zA-Z\_]+'])->name('fprojectleadinsert');
//Route::get('/facebook-display/otplogout/{name}', 'FBProjectController@otplogout')->where(['name' => '[0-9a-zA-Z\_]+'])->name('fotplogout');

//Route::get('/facebook-otpverify/project/{name?}', 'FBProjectController@gdotpshow')->where(['name' => '[0-9a-zA-Z\_]+'])->name('fotpproject');
//Route::post('/facebook-otpverify/project/{name}', 'FBProjectController@gdotpinsertlead')->where(['name' => '[0-9a-zA-Z\_]+'])->name('fotpprojectleadinsert');







//Route::get('/googlead/project/{name?}', 'GoogleProjectController@gshow')->where(['name' => '[0-9a-zA-Z\_]+'])->name('gproject');
//Route::post('/googlead/project/{name}', 'GoogleProjectController@ginsertlead')->where(['name' => '[0-9a-zA-Z\_]+'])->name('gprojectleadinsert');



/*Route::get('/constructionimages/{name?}', 'ProjectController@constructionfn')->where(['name' => '[0-9a-zA-Z\_]+'])->name('consfn');*/


//Route::get('/facebook/floorimages/{name?}', 'FBProjectController@fbfloorfn')->where(['name' => '[0-9a-zA-Z\_]+'])->name('fbfloorfn');
//Route::get('/facebook/constructionimages/{name?}', 'FBProjectController@fbconstructionfn')->where(['name' => '[0-9a-zA-Z\_]+'])->name('fbconsfn');

//Route::get('/googlead/floorimages/{name?}', 'GoogleProjectController@gfloorfn')->where(['name' => '[0-9a-zA-Z\_]+'])->name('gfloorfn');
//Route::get('/googlead/constructionimages/{name?}', 'GoogleProjectController@gconstructionfn')->where(['name' => '[0-9a-zA-Z\_]+'])->name('gconsfn');


//Route::get('/facebook/thank-you/{name?}', 'FBProjectController@fbthanks')->name('fbproject_thanks');
//Route::get('/googlead/thank-you/{name?}', 'GoogleProjectController@gthanks')->name('gproject_thanks');

//Route::get('/facebook-display/thank-you/{name?}', 'FBProjectController@gdthanks')->name('fproject_thanks');