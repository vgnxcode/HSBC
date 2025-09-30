<?php
/**
 * Production System
 */
return [

    'sapusername' => "uday",
    'sappassword' => "Dev@12345",
    
    'getcustomer_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/33feca864c563e5b8df5e3933691e397",
    'getcustomer_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_Customer_Out&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'savecomplaint_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/7e700e62b0cd3fda86390c44dcaba31a",
    'savecomplaint_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_COMP_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'closecomplaint_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/1bbebfbd2a3431c0b0d28e94e757b640",
    'closecomplaint_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_COMP_CLOSE_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'insert_inspection_snag_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/917c29a7f4a73d389c22862960b9a1a9",
    'insert_inspection_snag_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_INSPECTIONSNAG_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'get_inspection_snag_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/28c674ac92ff3a59a36a45d0ca45b8c6",
    'get_inspection_snag_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_INSPECTIONSNAG_DISPLAY_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'getUnsold_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/00f3f3ebd6a836598f53213193a86eb3",
    'getUnsold_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_Unsold_Out&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'sappostreferFriend_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/504acc5306f432c3b6c8394763767cdb",
    'sappostreferFriend_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_REFER_FRND_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'saveUserDetails_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/30e05287d6fe323c9b00a82024b32b73",
    'saveUserDetails_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_INFO_EDIT_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'updatebankinfo_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/b7c683b9777e335d874f1bd6be65f480",
    'updatebankinfo_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_BANK_DETAILS_UPDATE_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'customer_satisfaction_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/9603b649e5e23c0bb27b95820b89e1c4',
    'customer_satisfaction_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_SATISFACTION_SURVEY_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'getbulksmstosendsap_wsdl' =>'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/48b50537e6503d44a2afb654c3253516',
     'getbulksmstosendsap_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_BULK_SMS_EMAIL_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

     'getbulksmsstatus_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/cec613a93e3831d290678774b10fe104',
     'getbulksmsstatus_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_BULK_SMS_EMAIL_STATUS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

     'getcustomerprojectnetbalance_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/fa77c7e6349b3dcabaa7717e27f72796',
     'getcustomerprojectnetbalance_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_PAYMENT_BILLDESK_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'send_billdesktosap_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/92f284a3895236c2b850779564d8291b',
     'send_billdesktosap_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_PAYMENT_TRANSACTION_BILLDESK_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'getregbank_details_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/17a3e79969cf31dab70e31c27cb7e8b1',
     'getregbank_details_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_SA_LISTOF_BANK_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'postregbank_detailsto_sap_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/827b404388d935b2ab3a5c3138be9839',
     'postregbank_detailsto_sap_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_SA_REGISTRATION_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'get_posted_regbank_detailsfrom_sap_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/74bf3d693357360682261261a1d616a4',
     'get_posted_regbank_detailsfrom_sap_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_SHOW_REGISTERED_SALEAGREEMENT_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'check_saleagreement_taken_sap_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/7d78a88925b6316fa1aa026abdac7ce2',
     'check_saleagreement_taken_sap_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_SALEAGREEMENT_STATUS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'postsalesprocess_feedback_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/8b7cd6b5331b35e5b8d6f2ed40507d72',
     'postsalesprocess_feedback_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_SALEPROCESS_FEEDBACK_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'leadsurvey_feedback_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/1e1b3a34dd1a3e6393f470a57912ff4a',
     'leadsurvey_feedback_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_LEADS_CUST_FEEDBACK_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

     'salesitefeedback_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/a68f1de8cba93cdc8c04aff2c77a90f3',
     'postsalesitefeedback_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_SITEVISIT_FEEDBACK_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'checkcustomerlogin_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/352d2c54d80d314d9d09fea8b100086e',
     'checkcustomerlogin_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_LOGIN_VALIDATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'getbhkwsdl_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/e22047f9a8f53fe2905449d195ea187c',
     'getbhkwsdl_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_HOUSEHOLD_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'postinteriors_interest_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/126d17a76a79302eba253a95c50211b9',
     'postinteriors_interest_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_INTERIOR_INTEREST_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'posthomebuilding_interest_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/09c6b4c5445b3268aea3ddaa16f8acb8',
     'posthomebuilding_interest_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_HOMEBUILDING_INTEREST_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'getcustdisatreason_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/4706e54fd17a32148d4fff1f4c748d72',
     'getcustdisatreason_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_DISSATISFIED_REASONLIST_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'postdissat_reason_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/dc7166e4ab3c381caa240bf1f8507faa',
     'postdissat_reason_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_DISSATISFIED_REASONDETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'occupantdetails_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/0bee3579d6963fe28f9a9188fe15c7f6",
     'occupantdetails_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_SECONDOWNER_DETAILS_UPDATE_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

     'customerbasicinfo_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/5002427e865532db8f3165b015e3a400",
     'customerbasicinfo_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUSTOMER_PROJECT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

     'customer_paymenthistory_job_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/f18e068acda6369690d02b0c37984a07',
     'customer_paymenthistory_job_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUSTOMER_PAYMENT_HISTORY_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'customer_complaints_job_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/af056145a2603a7f81d2085470413523',
     'customer_complaints_job_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUSTOMER_COMPLAINT_DETAILSS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'Natureofcomplaints_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/071b93de5f0c36719281ec9267cf3f34',
     'Natureofcomplaints_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUSTOMER_NATURE_OF_COMP_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'cust_communication_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/22bc19837a19346fb99f85fd5ba2b0b1',
     'cust_communication_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUSTOMER_COMMUNICATION_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'cust_rentsellpost_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/2d159c6beb5b35f0af8426f5f33fb412',
     'cust_rentsellpost_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_GET_RENT_SELL_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'postplotcare_interest_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/fe9c50ca4e33379b81aad88518e23a78',
     'postplotcare_interest_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_PLOT_CARE_INTEREST_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'checkgenpayment_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/3a65076f5ff93ab09908e53995c19bd5',
     'checkgenpayment_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_BILLDESK_CREATE_SHORTLINK_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'postcheck_gen_paymentlinkdata_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/a0e38d6ee515332c8d714c21a7c559ef',
     'postcheck_gen_paymentlinkdata_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_BILLDESK_SENDING_SHORTLINK_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com'


];

?>