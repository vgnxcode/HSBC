<?php
/**
 * Production System
 */
return [

    'sapusername' => "vgnpip",
    //'sappassword' => "Vgn@321",
	'sappassword' => "piprd@1234",
	
    'showleaddetails_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/54d2c84efd5f38ccbd034251dcc4c9e4",
    'showleaddetails_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_AMEYO_SHOW_LEADDETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

'showleaddetailsbyleadno_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/a63c6bbf2aeb3730aff5a3e6d562e081",
    'showleaddetailsbyleadno_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_AMEYO_DETAILS_BY_LEAD_NO_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

'customer_detailsbycustid_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/899d1555a05c3591a7e08c719d5c90d3",
    'customer_detailsbycustid_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_AMEYO_DETAILS_By_CUST_ID_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com",

    'postleaddetails_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/bdba637ce0f43e3ea5c96094e0331e9c',
    'postleaddetails_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_AMEYO_CREATE_FRESH_LEAD_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

    'customer_paymentdetails_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/437553d30fa135c1a941532b4fe33897',
    'customer_paymentdetails_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_AMEYO_CUST_PAYMENT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

    'crm_execshow_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/8e92fc72100231da8ce1b694b48e76b2',
    'crm_execshow_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_AMEYO_FIND_EXECUTIVE_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

    'get_crm_email_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/19f3310d6bb8313988b2b4ebee1df536',
    'get_crm_email_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_AMEYO_FIND_EXECUTIVE_EMAIL_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

'postleaddetailsnew_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/b679a9ca4b453371930e9ac44cc71427',
    'postleaddetailsnew_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_AMEYO_CREATE_FRESH_LEAD_1_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

    'getactivecampaign_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/63d72298779f3266b82d5fdb13924ce2',
    'getactivecampaign_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_AMEYO_CAMPAIGN_CODE_LIST_OUT&interfaceNamespace=http%3A%2F%2Fsap_customer_data_to_webpage.com',

];

?>
