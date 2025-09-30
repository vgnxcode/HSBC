<?php

/**
 * Production System
 */
return [

    'sapusername' => "vijay",
    'sappassword' => "Oct@1234",
	
    'getemployee_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/eb11cf1bcb333dd1a448279fd865d8d6",
    'getemployee_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'checkLogin_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/cf5f13e001ae35dfada0510b25e4abe8",
    'checkLogin_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_LOGIN_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'dashboard_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/16db5635154637a28f1195c640364da2",
    'dashboard_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_DASHBOARD_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'updateemployeedetails_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/a4009df31ced3c449780ce259b45c359",
    'updateemployeedetails_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_DETAILS_EDIT_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'changesappassword_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/676fe6b56fdb31c5a7965f3edb93d806",
    'changesappassword_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_PWD_CHANGE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'forgotsappassword_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/8f2064d641b53f44aef86a8857f8f120",
    'forgotsappassword_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_LOGIN_FORGET_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getnoticeboard_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/424abd9a736933bea5fb0e14a2eb3892",
    'getnoticeboard_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_NOTICE_BOARD_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'attendance_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/9215869cfda436c0b6d8203611851bfe",
    'attendance_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_ATTEND_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'holiday_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/df8ab11a23e73be2aedb0e0e19ad8294",
    'holiday_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MEMO_CAL_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'empreferafriend_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/acb52e9191e634e3bffdbceefa1a290d",
    'empreferafriend_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=ST_VGN_CAREERS_OUT&interfaceNamespace=http%3A%2F%2Fsap_careers_data_to_webpage.com",

    'applyjob_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/7c100db9094d3127b0b7181a99fcecd6",
    'applyjob_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=ST_CAREERS_JOBAPPLY_OUT&interfaceNamespace=http%3A%2F%2Fsap_careers_data_to_webpage.com",

    'reportStructure_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/66b89cde006135f0b814799ec3951fe1",
    'reportStructure_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_REPORTING_STRUCT_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getmemos_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/df8ab11a23e73be2aedb0e0e19ad8294",
    'getmemos_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MEMO_CAL_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'gethrpolicy_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/efc80d27876f3098b3e2fbcb9d359743",
    'gethrpolicy_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_HR_POLICY_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'eligibilty_update_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/4b37f6adff8e3129a81c8925aa6da99e",
    'eligibilty_update_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_ELIGIBILITY_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getstock_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/2a3c5186c4f93642aba0f34d80da8f6f",
    'getstock_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_STOCK_LOAN_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getpayslip_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/cb2fea509d74361791ef58617f9054bf",
    'getpayslip_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_PAYSLIP_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'ShowRequest_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/98ad69ba0f053c40b83af2f3fa5bcbdf",
    'ShowRequest_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_REQUEST_ALL_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'CloseRequest_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/1310b82223aa3f6385b4b64ee12fcb2e",
    'CloseRequest_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_REQUEST_CLOSE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'raiserequest_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/c2a40ce354a03692a7fcaaedb7ea16f3",
    'raiserequest_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_REQUEST_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'mynewtraining_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/a2f42d011a1e3f38a211a1e407a2e5f3",
    'mynewtraining_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_TRAINING_SCH_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'searchlead_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/64d8ff15d3903962b121013f1362319e",
    'searchlead_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_LEADSEARCH_HELP_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'customerleadmove_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/8f4a05bdd26a3c5aa5451c499365448d",
    'customerleadmove_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUSTOMER_DETAILS_SALES_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'customerleadcreate_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/604553b393b73e76bcc6f945922bc2a1",
    'customerleadcreate_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUSTOMER_CREATION_SALES_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'getsaleorderunits_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/2201a2a5e4f83054a0ec844f51cd3893",
    'getsaleorderunits_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUSTOMER_PROJECT_SEARCH_HELP_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'getsaleorderpaymentterms_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/45344fb998743ecf80900e311a7eef34",
    'getsaleorderpaymentterms_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUSTOMER_PAYMENTTERMS_SEARCH_HELP_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'viewquotetrait_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/894f6792c78e329b929758186ec18cb7",
    'viewquotetrait_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUSTOMER_VIEWQUOTES_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'convertsaleorder_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/d816572a13ff3391b69c45eb0dca61f5",
    'convertsaleorder_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUSTOMER_SALES_ORDERCREATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'getleadsfollowup_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/69493ef45bd23e0690a5455b436920a4",
    'getleadsfollowup_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'leadsfollowupinsert_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/b36cb61520873eb1a09eb65822c5bf14",
    'leadsfollowupinsert_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_OVERALL_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getcoldreason_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/ae187b78410a3b08aa91b852863bdc5e",
    'getcoldreason_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_COLD_HELP_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'sendsmsleads_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/219012c52aaa343ca7debeefe39e1c51",
    'sendsmsleads_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_SMS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getediary_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/f3284f37376b360cbe17811ae2946233",
    'getediary_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_SALES_EDAIRY_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getleadsfollowupdata_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/fd8dbc925f6d3cd0b85d7d7fe776534d",
    'getleadsfollowupdata_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_STATUS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getleadscript_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/b43b98de42ff393c81ed25681c8acad0",
    'getleadscript_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_SCRIPT_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getleadtypeview_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/b526a8007a183536acb403a11df11069",
    'getleadtypeview_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_SITE_VISIT_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'expected_booking_date_wsdl' => 'http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/4e89070969503ed9beace72882fef0ee',
    'expected_booking_date_endpoint' => 'http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_EXPECTED_DATE_BOOK_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

    'requestforcoldapproval_data_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/4f2bf3b87f3331d2a63b08afc67498e9',
    'requestforcoldapproval_data_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_ZSD_MANAGER_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

    'forupdatemngr_coldapproval_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/6814537cfd163c61bd91504bebb87015',
    'forupdatemngr_coldapproval_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_MANAGER_APPROVAL_STATUS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

    'savecomplaint_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/1100cc0658973b508a23ba88004dd0a5",
    'savecomplaint_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_COMP_RAISE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'closecomplaint_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/a77513d8500f3649a0e69c5ec14642f7",
    'closecomplaint_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_EMPLOYEE_COMP_CLOSE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",
    
    'getUnsold_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/00f3f3ebd6a836598f53213193a86eb3",
    'getUnsold_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_Unsold_Out&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'empgetpunches_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/0f996a88543935528c76370bfc6ae6fb",
    'empgetpunches_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LMS_SORTED_PUNCHES_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'shiftdetails_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/999ff53d6e3236459e2c6c30c981372f",
    'shiftdetails_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LMS_EXISTING_SHIFT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'shiftdetailschangesreq_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/ab183b7f24bf348d8ad50e3551e91792",
    'shiftdetailschangesreq_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LMS_SHIFT_CHANGES_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'activeemployees_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/4584e43a254f3fedbcb4056b1197dbd0",
    'activeemployees_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LMS_ACTIVE_EMP_LIST_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getshift_details_wsdl' => "http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/d0f9a0fdd53239a9aef3af22bb866896",
    'getshift_details_endpoint' => "http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LMS_EMP_SHIFT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",
     
     'update_apprv_rej_wsdl' => 'http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/9fe0808c837236a49dfbab3f083d6324',
     'update_apprv_rej_endpoint' => 'http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LMS_UPDATE_LEAVE_BALANCE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

     'update_leave_wsdl' => 'http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/ebb31e3c5b1c36f6b14e3a861b206923',
     'update_leave_endpoint' => 'http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LMS_DEDUCT_LEAVE_BALANCE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

     'getactivecampaigns_wsdl' => 'http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/0cffa39c7bdc3c488f4299f874b1f172',
     'getactivecampaigns_endpoint' => 'http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=VGN_AD&receiverParty=&receiverService=&interface=SI_VGN_LEADS_CAMPAIGN_OUT&interfaceNamespace=http%3A%2F%2Fsap_vgn_advertisement_data_to_webpage.com',

     'postbulkleads_wsdl' => 'http://vgnpiqa.vgn.in:50000/dir/wsdl?p=ic/ce53e671c8e93e198deea698531f675c',
     'postbulkleads_endpoint' => 'http://vgnpiqa.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=VGN_AD&receiverParty=&receiverService=&interface=SI_VGN_LEAD_EXHIBITION_OUT&interfaceNamespace=http%3A%2F%2Fsap_vgn_advertisement_data_to_webpage.com',
    
];
?>