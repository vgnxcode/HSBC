<?php
/**
 * Production System
 */
return [

    // 'sapusername' => "uday",
    //'sappassword' => "Vgn@321",
    // 'sappassword' => "Dev@12345",
    //'sapusername' => "vgnpiuser",
    //'sappassword' => "vgnd@1234","vgnd1234",

    'sapusername' => "vgnpiuser",
    'sappassword' => "vgnd1234",

    
    'getvendor_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/9e46b2e38dea386298e63121d252ee89",
    'getvendor_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_FULL_DETAI_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'getHelp_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/6509096f39eb3bbf90ee77e3fe9e1c0b",
    'getHelp_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_SEARCH_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'regHelp_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/a2361fd4d5ca3b209a989c15d1f1f890",
    'regHelp_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_SERCH_HLP_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'venRegDetails_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/3395ed2b30433f42931b0cf0f5fc7278",
    'venRegDetails_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_REGISTRATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'savecomplaint_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/f2fffa22e6fa3c6c8308b6c4a3848015",
    'savecomplaint_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_RAIS_COMP_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'closecomplaint_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/a0717a766c943baab69c9c856a013e13",
    'closecomplaint_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_CLOSE_COMP_OU&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'fetchbids_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/1855a847d28a3817990c12823cd184b5",
    'fetchbids_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_COMPLETE_BID_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'savevendorremarks_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/b7eca4bb07f73af889ff89ca645a4cf7",
    'savevendorremarks_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_BID_VENDOR_REMARKS_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'bidUpdate_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/518981794c703e739223579d01a58459",
    'bidUpdate_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_BID_RATE_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'myrecentbids_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/ed0e7828376b3d888b8dff9b39ada603",
    'myrecentbids_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_BID_RECENT_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'getUnsold_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/00f3f3ebd6a836598f53213193a86eb3",
    'getUnsold_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_Unsold_Out&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'sappostreferFriend_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/504acc5306f432c3b6c8394763767cdb",
    'sappostreferFriend_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_CUST_REFER_FRND_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'updatebankinfo_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/c8d83dea1a203ca8ad579846f08af52f",
    'updatebankinfo_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_BANK_DETAILS_UPDATE_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'channelpartner_get_campaign_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/1ba722523eab3fb79750ae9b1bdc90ee',
    'channelpartner_get_campaign_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_PLANTWISE_CAMPAIGN_CODE_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'negotiated_discount_rate_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/975026f60b5f3e36a8060b020122d972',
    'negotiated_discount_rate_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_BID_DATA_WEB_T0_ECC_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'show_negotiated_price_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/bd376436adb1368c8c7abfe9e4e51faa',
    'show_negotiated_price_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_BID_DATA_ECC_T0_WEB_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'checkvendorlogin_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/b71dcb97957632b1a90af85603b694f0',
    'checkvendorlogin_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_LOGIN_VALIDATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendorbasicinfo_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/2f163d1cd42337cabef08015559f3827',
    'vendorbasicinfo_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VENDOR_LOGIN_SPEEDUP_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendor_paymenthistory_job_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/9e861be250c13ab599cbaf5ec42919d5',
    'vendor_paymenthistory_job_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_PAYMENT_HISTORY_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendor_complaints_job_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/c2c71b80632b3ef6a53817ce87c8b4ea',
    'vendor_complaints_job_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_COMPLAIANT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendor_pan_valid_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/10d0569e3a2333c3ac923f19387f2db4',
    'vendor_pan_valid_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_PAN_VALIDATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendor_register_validation_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/bf07b33c88eb331bbf5468972e6b82e3',
    'vendor_register_validation_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_REGISTRATION_VALIDATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'detailsupdate_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/7b36057bf9783ee6b57bafbc03b9451a',
    'detailsupdate_validation_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_CHANGE_MOBILE_AND_MAIL_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'requestedip_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/fc0cfd1b798a31f88a8b38af35905f30',
    'requestedip_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VENDOR_GET_IP_ADDRESS_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendorregfiles_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/557afee1131f32db9ddfd01f5bcc2a9d',
    'vendorregfiles_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VENDOR_LIST_OF_ATTACHMENTS_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',


    'invoicestatus_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/050fafabbe8732518e9b8511c775a09c',
    'invoicestatus_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_INVOICE_STATUS_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'invoiceattachment_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/909e76df3b4f310f90ebad2007227f35',
    'invoiceattachment_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VEND_INVOICE_ATTACHMENT_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',
    
    'projectlist_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/4037c498bb4e3a42becb1109a2228101',
    'projectlist_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_VGN_PROJECT_LIST_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

];

?> 