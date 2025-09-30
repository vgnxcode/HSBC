<?php

/**
 * Production System
 */
return [

    'sapusername' => "vgnpip",
    //'sappassword' => "Vgn@321",
	'sappassword' => "piprd@1234",
	
    'getemployee_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/93f2ab5d11313930839d4638e9efc976",
    'getemployee_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'checkLogin_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/c83fb0ac89e03758b6da5ff8ed14a8fa",
    'checkLogin_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_LOGIN_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'dashboard_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/0cd567631fc73bcd8a66b6a6ca3e2733",
    'dashboard_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_DASHBOARD_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'updateemployeedetails_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/0af0f46608e63562836aa0c624d05a16",
    'updateemployeedetails_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_DETAILS_EDIT_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'changesappassword_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/e75e292bc1363485a66abc7e0f49b21b",
    'changesappassword_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_PWD_CHANGE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'forgotsappassword_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/4c3e2e91ce833e099d9d042a5a8922a3",
    'forgotsappassword_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_LOGIN_FORGET_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getnoticeboard_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/caf166bf5e243389b37ca2c6aeaee3d2",
    'getnoticeboard_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_NOTICE_BOARD_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'attendance_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/0913c36a508f34b3924bb3af91351b8f",
    'attendance_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_ATTEND_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'holiday_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/55e95cdf5607336f9d393513f476f1c7",
    'holiday_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MEMO_CAL_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'empreferafriend_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/f6921c39450830069a740fe6e87e3e99",
    'empreferafriend_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=ST_VGN_CAREERS_OUT&interfaceNamespace=http%3A%2F%2Fsap_careers_data_to_webpage.com",

    'applyjob_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/aef6551152243106a806fe2ace3ecc43",
    'applyjob_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=ST_CAREERS_JOBAPPLY_OUT&interfaceNamespace=http%3A%2F%2Fsap_careers_data_to_webpage.com",

    'reportStructure_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/4f3221d925883205956e6f7be60233ac",
    'reportStructure_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_REPORTING_STRUCT_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getmemos_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/55e95cdf5607336f9d393513f476f1c7",
    'getmemos_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MEMO_CAL_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'gethrpolicy_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/9508af8bef3b315c9a583c4f97e67b51",
    'gethrpolicy_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_HR_POLICY_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'eligibilty_update_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/9cac94d610fb3bef9a9a8420b641f103",
    'eligibilty_update_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_ELIGIBILITY_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getstock_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/8016006c4dc93be6959c4b823a0e7c53",
    'getstock_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_STOCK_LOAN_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getpayslip_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/95845ba29c3a39899c69923bd0736a66",
    'getpayslip_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_PAYSLIP_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'ShowRequest_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/c04ca61cc2ee358cb1254ffdcad7bae4",
    'ShowRequest_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_REQUEST_ALL_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'CloseRequest_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/9dc66dc6f693369dbff9dbe157e3a7df",
    'CloseRequest_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_REQUEST_CLOSE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'raiserequest_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/2c3cedd3c7343489a6225d308ccd96fc",
    'raiserequest_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_MY_REQUEST_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'mynewtraining_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/7890d1f597723896befe987740374218",
    'mynewtraining_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_TRAINING_SCH_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'searchlead_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/c67736dbd4553f13a197eb67c5e4a45a",
    'searchlead_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_LEADSEARCH_HELP_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'customerleadmove_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/c79650f38219391c94da4c4fe247b87e",
    'customerleadmove_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUSTOMER_DETAILS_SALES_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'customerleadcreate_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/7f4f3dd788933cfa94ded3425fc22ee6",
    'customerleadcreate_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUSTOMER_CREATION_SALES_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'getsaleorderunits_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/908e7e07fb51323fa7b9a80c1aab49eb",
    'getsaleorderunits_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUSTOMER_PROJECT_SEARCH_HELP_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'getsaleorderpaymentterms_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/f8e82cf6715835b9a0c58b114f4cd6a3",
    'getsaleorderpaymentterms_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUSTOMER_PAYMENTTERMS_SEARCH_HELP_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'viewquotetrait_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/0e79e731bf97395a8d1993396856deb1",
    'viewquotetrait_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUSTOMER_VIEWQUOTES_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'convertsaleorder_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/4f65ac55ab29361295c6ecb1eb88765e",
    'convertsaleorder_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUSTOMER_SALES_ORDERCREATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'getleadsfollowup_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/27a10300940033018cb7136fa708bd00",
    'getleadsfollowup_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'expected_booking_date_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/93cd5992a4c23258be5819b8238842e6',
    'expected_booking_date_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_EXPECTED_DATE_BOOK_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

    'requestforcoldapproval_data_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/f136d7826c4f3a49978d08e8f331cd31',
    'requestforcoldapproval_data_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_ZSD_MANAGER_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

    'forupdatemngr_coldapproval_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/9a593596e46c334dbdc8b0ac84be33ab',
    'forupdatemngr_coldapproval_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_MANAGER_APPROVAL_STATUS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

    'leadsfollowupinsert_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/ed839c41134c3e0498c9d43867d84b2a",
    'leadsfollowupinsert_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_OVERALL_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getcoldreason_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/06bd8d53b5a2302e8caa5cd4967c2c27",
    'getcoldreason_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_COLD_HELP_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'sendsmsleads_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/c2ecdcef4fc932709019f05a0841d589",
    'sendsmsleads_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_SMS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getediary_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/e5bd96ee8b1d3a048368b43df69a6d2e",
    'getediary_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_SALES_EDAIRY_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getleadsfollowupdata_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/e542a269001d3903890c3376b446066d",
    'getleadsfollowupdata_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_STATUS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getleadscript_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/baa3b01ba3c53a16b8a754e2dd5de3a0",
    'getleadscript_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_SCRIPT_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getleadtypeview_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/4fdf89ea690339de9f41e2713f8d26ea",
    'getleadtypeview_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_FOLLOWUP_SITE_VISIT_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'savecomplaint_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/1aebd9e0960b3ca78b3ff41c29611710",
    'savecomplaint_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_COMP_RAISE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'closecomplaint_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/476e7e33771138d98dd05200de95d1bf",
    'closecomplaint_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_COMP_CLOSE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",
    
    'getUnsold_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/63aa8e2d64263776b68796311987768e",
    'getUnsold_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_Unsold_Out&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'empgetpunches_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/fde7dd3030ff33cabf08148f733869f4",
    'empgetpunches_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LMS_SORTED_PUNCHES_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'shiftdetails_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/79912af46e0b38f98feb3082680b5964",
    'shiftdetails_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LMS_EXISTING_SHIFT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'shiftdetailschangesreq_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/f750fcab3d0c3319a531f3195d573883",
    'shiftdetailschangesreq_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LMS_SHIFT_CHANGES_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'activeemployees_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/11eea01c8978328985e17e287dc7a0ac",
    'activeemployees_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LMS_ACTIVE_EMP_LIST_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",

    'getshift_details_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/765f9e51ba323f8ba9580c6c35750d00",
    'getshift_details_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LMS_EMP_SHIFT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com",
     
     'update_apprv_rej_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/67e97a837cc03b828b6f799552123d23',
     'update_apprv_rej_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LMS_UPDATE_LEAVE_BALANCE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

     'update_leave_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/bb74abbf325c37f7bb89bfb89751cbcf',
     'update_leave_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LMS_DEDUCT_LEAVE_BALANCE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',
	
	'delete_leave_applied_wsdl'=> 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/4492b0c6aaa23021b30932a684c12b61',
     'delete_leave_applied_endpoint'=> 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LMS_CANCEL_APPLIED_LEAVE_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

     'getactivecampaigns_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/b37de8cb2ab53f33addc6d33299d9f65',
     'getactivecampaigns_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VGN_LEADS_CAMPAIGN_OUT&interfaceNamespace=http%3A%2F%2Fsap_vgn_advertisement_data_to_webpage.com',

     'postbulkleads_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/6c7df9a6a4f434a8829986a84bff697c',
     'postbulkleads_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VGN_LEAD_EXHIBITION_OUT&interfaceNamespace=http%3A%2F%2Fsap_vgn_advertisement_data_to_webpage.com',

'today_followup_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/156730fce5923812a2587405bb7046dd',
     'today_followup_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_TODAY_FOLLOWUP_LIST_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

'emp_bulklead_plantout_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/83fa6841fe3431c0b3988fa951d70876',
    'emp_bulklead_plantout_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VGN_EMPLOYEE_PLANTLIST_OUT&interfaceNamespace=http%3A%2F%2Fsap_vgn_advertisement_data_to_webpage.com',

'checkemployeelogin_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/11aa4261dfb7328f93a2fb0a89b1e8eb',
     'checkemployeelogin_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_LOGIN_VALIDATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

     'employeebasicinfo_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/831781e55b6c3151bfc0ce61cf2a14c5',
     'employeebasicinfo_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_EMPLOYEE_BASIC_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

'hrapplication_crosscheck_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/ff03caf943f1336da52086298b6b81c4',
     'hrapplication_crosscheck_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=ST_APPLICANT_STATUS_OUT&interfaceNamespace=http%3A%2F%2Fsap_careers_data_to_webpage.com',

     'updatebankinfo_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/7bdba51f83373eb09e3d42b44673e22f",
    'updatebankinfo_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_BANK_DETAILS_UPDATE_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'requestedip_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/67e8cf8b37d2330bb35ee60383657f63',
    'requestedip_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VENDOR_GET_IP_ADDRESS_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

];
?>
