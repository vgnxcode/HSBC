<?php
/**
 * Production System
 */
return [

    'sapusername' => "vgnpip",
    //'sappassword' => "Vgn@321",
	'sappassword' => "piprd@1234",
	
    'getvendor_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/07a37e6bf8633f7987339faea6df3b10",
    'getvendor_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_FULL_DETAI_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'getHelp_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/44cd3ea86670316581a765a4efac404b",
    'getHelp_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_SEARCH_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'regHelp_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/7cd7f9895ea33aaba18a398597ab8638",
    'regHelp_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_SERCH_HLP_OUT&interfaceNamespace=http://sap_vendor_data_to_webpage.com",

    'venRegDetails_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/6950113c7f28323bbef004e1285bd370",
    'venRegDetails_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_REGISTRATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'savecomplaint_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/741c4e22315d33d798c4720b385b0258",
    'savecomplaint_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_RAIS_COMP_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'closecomplaint_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/2362a9da814a302499e1e87d37e8b23c",
    'closecomplaint_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_CLOSE_COMP_OU&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'fetchbids_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/ecff3bd77afa311985f17b5edcfd418c",
    'fetchbids_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_COMPLETE_BID_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'savevendorremarks_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/092754c60f8535049eebeb29600449ff",
    'savevendorremarks_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_BID_VENDOR_REMARKS_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'bidUpdate_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/9e278791933b3ebfb5bb904d686d45dc",
    'bidUpdate_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_BID_RATE_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'myrecentbids_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/91690626a08d36b081badf78a4370996",
    'myrecentbids_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_BID_RECENT_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'getUnsold_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/63aa8e2d64263776b68796311987768e",
    'getUnsold_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_Unsold_Out&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'sappostreferFriend_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/cc7ee7a169c83ebbbcbdeceeb4d653e9",
    'sappostreferFriend_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_CUST_REFER_FRND_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'updatebankinfo_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/7bdba51f83373eb09e3d42b44673e22f",
    'updatebankinfo_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_BANK_DETAILS_UPDATE_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com",

    'channelpartner_get_campaign_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/3510a7486bef360e970cdf44d71bc665',
    'channelpartner_get_campaign_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_PLANTWISE_CAMPAIGN_CODE_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'negotiated_discount_rate_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/b0c061867e2f3372ad2a363281347646',
    'negotiated_discount_rate_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_BID_DATA_WEB_T0_ECC_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'show_negotiated_price_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/02d6d250c5913f0db8a4a4e597a49977',
    'show_negotiated_price_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_BID_DATA_ECC_T0_WEB_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'checkvendorlogin_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/ea0626028ceb373c897595b91615fae2',
    'checkvendorlogin_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_LOGIN_VALIDATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendorbasicinfo_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/45440969c3a93b38b40df505e973906f',
    'vendorbasicinfo_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VENDOR_LOGIN_SPEEDUP_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendor_paymenthistory_job_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/6dfd8f2fdb0d3ed0ad6acf48daa25901',
    'vendor_paymenthistory_job_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_PAYMENT_HISTORY_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendor_complaints_job_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/3f9b430c2b3732709d1f4164ed3d61c6',
    'vendor_complaints_job_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_COMPLAIANT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendor_pan_valid_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/6f99dae183c530708a1f3dd456420235',
    'vendor_pan_valid_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_PAN_VALIDATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendor_register_validation_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/e8c1692cde333eb78c4617f64cb7cf33',
    'vendor_register_validation_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_REGISTRATION_VALIDATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'detailsupdate_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/2298a60ae2ba3a03a25400be4ef2a22f',
    'detailsupdate_validation_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_CHANGE_MOBILE_AND_MAIL_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'requestedip_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/67e8cf8b37d2330bb35ee60383657f63',
    'requestedip_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VENDOR_GET_IP_ADDRESS_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'vendorregfiles_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/eeb9d70dad9a32e4bcb498db618ff250',
    'vendorregfiles_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VENDOR_LIST_OF_ATTACHMENTS_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'invoicestatus_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/da36fb21c890328789682de6967d358b',
    'invoicestatus_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_INVOICE_STATUS_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'invoiceattachment_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/8479daf2e4b4352986fd4589c631fd23',
    'invoiceattachment_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VEND_INVOICE_ATTACHMENT_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

    'projectlist_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/8dac2c01ec683615bc576dfb06b64c3e',
    'projectlist_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_VGN_PROJECT_LIST_OUT&interfaceNamespace=http%3A%2F%2Fsap_vendor_data_to_webpage.com',

];

?>
