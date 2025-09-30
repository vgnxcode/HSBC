<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::controller(MobileappController::class)->group(function () {
    Route::get('/aboutus', 'aboutus');
    Route::get('/contactus', 'contactus');
    Route::post('/postmobile', 'postmobile');
    Route::post('/otpverify', 'otpverify');
    Route::post('/forgetotplogin', 'forgetotplogin');

    Route::get('/shownewlaunch', 'shownewlaunch');
    Route::post('/blockplotorflat', 'blockplotorflat');
    Route::post('/saleslogin', 'saleslogin');
    Route::post('/saleslogout', 'saleslogout');

    Route::get('/ongoing', 'ongoing');
    Route::get('/completed', 'completed');
    Route::get('/ongoingviewdetails/{projid}', 'ongoingviewdetails')->where(['projid' => '[0-9]+']);
    Route::get('/completedviewdetails/{projid}', 'completedviewdetails')->where(['projid' => '[0-9]+']);
    Route::get('/newongoingviewdetails/{projid}', 'newongoingviewdetails')->where(['projid' => '[0-9]+']);
    Route::get('/newcompletedviewdetails/{projid}', 'newcompletedviewdetails')->where(['projid' => '[0-9]+']);
    Route::get('/locationlist', 'locationlist');

    Route::post('/postlogin', 'postlogin');
    Route::post('/postlogout', 'postlogout');
    Route::post('/dashboard', 'dashboard');
    Route::post('/mydetails', 'mydetails');
    Route::post('/postchangemydetails', 'postchangemydetails');
    Route::post('/postchangepassword', 'postchangepassword');
    Route::get('/countryandstatenames', 'countryandstatenames');

    Route::post('/showraisecomplaints', 'showraisecomplaints');
    Route::post('/postraisecomplaints', 'postraisecomplaints');
    Route::post('/closeraisecomplaints', 'closeraisecomplaints');
    Route::post('/showcomplaints', 'showcomplaints');

    Route::post('/paymenthistory', 'paymenthistory');
    Route::post('/paymenthistorynew', 'paymenthistorynew');
    Route::post('/projectstatus', 'projectstatus');

    Route::post('/showcreatesnag', 'showcreatesnag');
    Route::post('/postcreatesnag', 'postcreatesnag');
    Route::post('/showsnag', 'showsnag');
    Route::post('/showupdatesnag', 'showupdatesnag');
    Route::post('/postupdatesnag', 'postupdatesnag');

    Route::post('/showreferafriend', 'showreferafriend');
    Route::post('/postshowreferafriend', 'postshowreferafriend');
    Route::post('/postforgotpassword', 'postforgotpassword');
    Route::post('/communication', 'communication');
    Route::post('/postleads', 'postleads');
});

Route::prefix('ameyo')->controller(AmeyoController::class)->group(function () {
    Route::get('/api1', 'api1');
    Route::post('/api2', 'api2');
    Route::get('/api3', 'api3');
    Route::get('/api4', 'api4');
    Route::get('/api5', 'api5');
    Route::get('/api6', 'api6');
    Route::post('/api7', 'api7');
    Route::get('/api8', 'api8');
    Route::get('/api9', 'api9');
    Route::get('/api10', 'api10');
    Route::get('/api11', 'api11');

    Route::get('/showactivecampaigns', 'showactivecampaigns');
    Route::get('/showactiveplants', 'showactiveplants');
    Route::get('/showbudgetrange', 'showbudgetrange');
    Route::post('/fetch-leads-detail-using-incomingcallno', 'fetch_leads_detailusingincomingcallno');
    Route::get('/fetch-tatacrm-call-log', 'fetch_tatacrm_call_log');
    Route::get('/fetch-tatacrm-call-log-did', 'fetch_tatacrm_call_log_did');
    Route::post('/agent_inbondcall_from_tatasmartflo', 'agent_inbondcall_from_tatasmartflo');
    Route::get('/agent_inbondcall_from_tatasmartflo', 'agent_inbondcall_from_tatasmartflo');
    Route::get('/fetch_tatacrm_currentdate_call_log', 'fetch_tatacrm_currentdate_call_log');
    Route::post('/fetch_tatacrm_currentdate_call_log', 'fetch_tatacrm_currentdate_call_log');
    Route::post('/getFilteredDailyReport', 'getFilteredDailyReport');
    
});

Route::prefix('hsbc')->controller(HSBCController::class)->group(function () {
    Route::get('/hsbc_getdatafromsap', 'get_the_datafrom_sap_process');
    Route::post('/posttohsbc_instant_receipt', 'posttohsbc_instant_receipt');
    Route::get('/hsbccheckstatusforsentdata', 'hsbccheckstatusforsentdata');
    Route::post('/hsbccheckstatusforsentdata', 'posthsbccheckstatusforsentdata');
    Route::post('/hsbcfinalupdate', 'hsbcfinalupdate');
    Route::post('/hsbcfinalupdate_decrypt', 'hsbcfinalupdate_decrypt');
    Route::get('/hsbcfinalupdate_table', 'hsbcfinalupdate_table');
    Route::post('/hsbcfinalencdec', 'hsbcfinalencdec');
    Route::post('/gethsbcbankpaymentstatus', 'gethsbcbankpaymentstatus');
    Route::post('/gethsbcbankpaymenttoprocess', 'gethsbcbankpaymenttoprocess');
});

// Project Leads
Route::post('/homes/leadpush', 'ProjectController@inserthomeslead');

// IVRS
Route::controller(CustomerzoneController::class)->group(function () {
    Route::get('/ivrsfeedbackapi', 'ivrsfeedback');
});
Route::post('/ivrsfeedbackpost', 'IVRSController@postfeedback');
Route::get('/ivrs/getcustomerdata', 'MobileappController@getcustomerdata_ivrs');

// Billdesk
Route::controller(BilldeskController::class)->group(function () {
    //Route::post('/customerzone/onlinepayment_response', 'onlinepayment_response');
    Route::post('/customerzone/onlinepayment_response', 'postcustomerzoneonlinepaymentresponse'); // ✅ use only the latest version
    Route::get('/billdesserverkquery', 'billdesserverkquery');
});

// HSBC Encryption
Route::controller(HSBCFinalController::class)->group(function () {
    Route::get('/hsbcencrypt', 'encryptSecret');
    Route::get('/hsbcdecrypt', 'decryptSecret');
});

// Site Visit
Route::get('/employeezone/viewschedulesitevisitmap/{leadno}/{mobile}', 'EmployeezoneController@viewschedulesitevisitmap')
    ->name('viewschedulesitevisit');

// Kotak APIs
Route::controller(KotakBankController::class)->group(function () {
    Route::get('/KotakPaymentRequest', 'GetSapDataProcess1');
    Route::get('/KotakReversalRequest', 'reversalrequest');
});

// Kotak Dev APIs
Route::controller(DevKotakController::class)->group(function () {
    Route::get('/DevKotakPaymentRequest', 'GetSapDataProcess1');
    Route::get('/DevKotakReversalRequest', 'reversalrequest');
});

// VGN Chatbot
Route::prefix('vgncustomchatreq')->controller(vgnchatbotcontroller::class)->group(function () {
    Route::post('/acceptname', 'acceptname');
    Route::post('/gettypelocations', 'gettypelocations');
    Route::post('/getlocationprojectslist', 'getlocationprojectslist');
    Route::post('/submitprojectslist', 'submitprojectslist');
    Route::post('/submitemailandclose', 'submitemailandclose');
});
Route::post('/vgnleadpost', 'vgnchatbotcontroller@postlead');

// Facebook Messenger
Route::controller(fbmessagnercontroller::class)->group(function () {
    Route::get('/fb_messengerpost', 'verify_token');
    Route::post('/fb_messengerpost', 'postedfromfb');
});
Route::controller(fbapipushcontroller::class)->group(function () {
    Route::get('/fbpushleads', 'verify_token');
    Route::post('/fbpushleads', 'postedfromfb');
    Route::get('/processfbleads', 'getleadsfromfacebook');
});

// LinkedIn Auth Callback
Route::get('/linkedinapi/auth/callback', 'linkedinapipushcontroller@linkedinapiauthcallback');

// Paytm
Route::controller(PaytmController::class)->group(function () {
    Route::get('/paytm/customervalidateapi', 'customervalidateapi');
    Route::post('/paytm/paymentpostingapi', 'paymentpostingapi');
    Route::get('/paytm/statuscheckapi', 'statuscheckapi');
});

// FB Chatbot
Route::controller(FBchatbotController::class)->group(function () {
    Route::any('/fbchat_step1', 'fbchat_step1');
    Route::get('/checkfb', 'check');
});

// Common Lead APIs
Route::controller(CommonLeadController::class)->group(function () {
    Route::post('/lead-data', 'leadDataApi');
    Route::post('/common-lead', 'commonLead');
    Route::post('/magicbricksapi', 'commonLead');
    Route::get('/fetch-interakt', 'fetchInteraktData');
    Route::get('/fetch-facebook-leads', 'fetch_facebook_Static');
    Route::get('/fetch-facebook-leads-Coasta-marble-arch', 'fetch_facebook_Static_Coasta_marblearch');
    Route::get('/fetch_facebook_Seattle', 'fetch_facebook_Seattle');
    Route::post('/calling945-newincoming-call-data', 'calling945_newincoming_call_data');
    // Route::get('/spt_agency_richmond_social_media_campaigns', 'spt_agency_richmond_social_media_campaigns');
    //Route::get('/spt_agency_ma_fm_social_media_campaigns', 'spt_agency_ma_fm_social_media_campaigns');
    // Infinix Agency Seattle Social Media Campaigns
    // Route::get('/infinix_agency_Seattle_social_media_campaigns', 'infinix_agency_Seattle_social_media_campaigns');
    //Route::get('/dmt_agency_richmond_social_media_campaigns', 'dmt_agency_richmond_social_media_campaigns');
    //Spinta Agency  Social Media Campaigns
    Route::get('/spt_agency_social_media_campaigns', 'spt_agency_social_media_campaigns');
    //Digital Mantraaz Agency  Social Media Campaigns
    Route::get('/dmt_agency_social_media_campaigns', 'dmt_agency_social_media_campaigns');
    // Infinix Agency Social Media Campaigns
    Route::get('/infinix_agency_social_media_campaigns', 'infinix_agency_social_media_campaigns');
});

// Attendance
Route::controller(AttendanceController::class)->group(function () {
    Route::match(['get', 'post'], '/fetch-attendance', 'getattendancefromapi');
    Route::get('/pushsap-attendance', 'pushsapattendance');
});

// Customerzone - BHK Details
Route::post('/getcustomerbhk', 'CustomerzoneController@getbhkdetails_service');

//get kaleyra sms log 
Route::post('/kaleyra/sms-callback', 'KaleyraController@smsCallback');
//get gupshup sms log 
Route::post('/gupshup/sms-callback', 'KaleyraController@gupshup');

Route::get('/get_wa_report_sap', 'CustomerzoneController@get_wa_report_sap');