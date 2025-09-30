<?php
/**
 * Production System
 */
return [

    'sapusername' => "vgnpip",
    //'sappassword' => "Vgn@321",
	'sappassword' => "piprd@1234",
	
    'getcustomer_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/539dfbb7beaf36b0b0ebf5d01a54ec89",
    'getcustomer_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_Customer_Out&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'savecomplaint_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/19a1da02f5e63241833bec5eaae7efcd",
    'savecomplaint_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_COMP_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'closecomplaint_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/421561161dc633219a431ccbc8ad5cd5",
    'closecomplaint_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_COMP_CLOSE_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'insert_inspection_snag_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/ce21880b6c0d3b088dedd6706efc0686",
    'insert_inspection_snag_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_INSPECTIONSNAG_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'get_inspection_snag_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/2e98cefaf15c3d7197eb87cc839dc0ac",
    'get_inspection_snag_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_INSPECTIONSNAG_DISPLAY_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'getUnsold_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/63aa8e2d64263776b68796311987768e",
    'getUnsold_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_Unsold_Out&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'sappostreferFriend_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/cc7ee7a169c83ebbbcbdeceeb4d653e9",
    'sappostreferFriend_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_REFER_FRND_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'saveUserDetails_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/a66fa166bc9831e5a8342f458cbb921f",
    'saveUserDetails_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_INFO_EDIT_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'updatebankinfo_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/8eebf4cb49f13f1e99127c0df973d84d",
    'updatebankinfo_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_BANK_DETAILS_UPDATE_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'customer_satisfaction_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/5b2f3ab25671359c96911c9aa9518692",
    'customer_satisfaction_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_SATISFACTION_SURVEY_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",
	
	'getbulksmstosendsap_wsdl' =>'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/9008cba0dcf33b15b86890bae85a9286',
    'getbulksmstosendsap_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_LEADS_BULK_SMS_EMAIL_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_employee_zone.com',

     'getcustomerprojectnetbalance_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/57f47664db5c307e825e9340b1ca09bc',
     'getcustomerprojectnetbalance_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_PAYMENT_BILLDESK_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'send_billdesktosap_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/b73dd28fd81d35108f24ebc6a7058b43',
     'send_billdesktosap_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_PAYMENT_TRANSACTION_BILLDESK_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'getregbank_details_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/97e07bff7c973e67b9f8fc85613d4864',
     'getregbank_details_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_SA_LISTOF_BANK_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'postregbank_detailsto_sap_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/9406b937b0fc3993b2494324aca04316',
     'postregbank_detailsto_sap_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_SA_REGISTRATION_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'get_posted_regbank_detailsfrom_sap_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/683c903b86f03956b6a84204b9c0209b',
     'get_posted_regbank_detailsfrom_sap_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_SHOW_REGISTERED_SALEAGREEMENT_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'check_saleagreement_taken_sap_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/1de58ef6b8c536d3973219e4bea6647f',
     'check_saleagreement_taken_sap_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_SALEAGREEMENT_STATUS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

 'salesitefeedback_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/773223f074733020b5af2910f8b29b58',
     'postsalesitefeedback_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_SITEVISIT_FEEDBACK_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

'checkcustomerlogin_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/6617668c6d3e33e8b2f3e764a34650d8',
'checkcustomerlogin_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_LOGIN_VALIDATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

'getbhkwsdl_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/232703bcfc703f898f13343928bd0568',
     'getbhkwsdl_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_HOUSEHOLD_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

'postinteriors_interest_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/1fff1c4ffb933647bf8ef3140af889f9',
     'postinteriors_interest_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_INTERIOR_INTEREST_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

'posthomebuilding_interest_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/9a9d1e1a6df33461a611d1b7d451678b',
     'posthomebuilding_interest_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_HOMEBUILDING_INTEREST_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

'getcustdisatreason_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/bc3c809b294434a1949eba2710f383c0',
     'getcustdisatreason_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_DISSATISFIED_REASONLIST_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'postdissat_reason_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/8edb8660c2b33ca4b341ddb68f2acf76',
     'postdissat_reason_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_DISSATISFIED_REASONDETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

'occupantdetails_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/36fb96f9a3cb394c81ab14d7bb62368b",
     'occupantdetails_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_SECONDOWNER_DETAILS_UPDATE_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

'customerbasicinfo_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/23b5d9532cc8341ea3f6d2b24715a078",
     'customerbasicinfo_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUSTOMER_PROJECT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

'customer_paymenthistory_job_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/76e9feba053f36838ea99ee33db4581d',
     'customer_paymenthistory_job_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUSTOMER_PAYMENT_HISTORY_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'customer_complaints_job_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/039c1b6b6ee330fb8321246521808f8a',
     'customer_complaints_job_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUSTOMER_COMPLAINT_DETAILSS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'Natureofcomplaints_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/b64f39f1adf331c8948865311679a735',
     'Natureofcomplaints_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUSTOMER_NATURE_OF_COMP_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'cust_communication_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/f62dc02836713dcf956676bebaaee85d',
     'cust_communication_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUSTOMER_COMMUNICATION_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'cust_rentsellpost_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/8ae32e480d99333f9db107468c836bf1',
     'cust_rentsellpost_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_GET_RENT_SELL_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

'postplotcare_interest_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/8ea6533c354b3ce8a083cbc3fb5c7067',
     'postplotcare_interest_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_PLOT_CARE_INTEREST_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

'checkgenpayment_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/3a65076f5ff93ab09908e53995c19bd5',
     'checkgenpayment_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_BILLDESK_CREATE_SHORTLINK_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

     'postcheck_gen_paymentlinkdata_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/a0e38d6ee515332c8d714c21a7c559ef',
     'postcheck_gen_paymentlinkdata_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_BILLDESK_SENDING_SHORTLINK_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com'

];

?>
