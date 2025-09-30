<?php
/**
 * Production System
 */
return [

    'sapusername' => "vgnpip",
    'sappassword' => "piprd@1234",
	
    'showprojectlist_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/de9fa5141d4b340eb4176a56d24fbf20",
    'showprojectlist_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_PAYTM_PROJECT_LIST_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com",

    'getunitlist_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/68f822b411c133da80bf16c15d59c878",
    'getunitlist_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_PAYTM_PROJECT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com",

    'customervalidation_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/d259de5f758a35b9b9516ecc3a399b73",
    'customervalidation_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_PAYTM_CUST_VALIDATION_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com",

    'billfetch_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/7c00d48ec2893fc5a44614ed3425a5d5",
    'billfetch_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_PAYTM_PAYABLE_AMOUNT_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com",

    'paytmpaymentpost_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/9dd4773b32e83fa8831373defbbf4904",
    'paytmpaymentpost_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_PAYTM_UPDATE_PAYMENT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com",

    'paytstatuscheck_wsdl' => "http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/500bf09cb0ce3060b662451b6a29234e",
    'paytstatuscheck_endpoint' => "http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_PAYTM_PAYMENT_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com",
];

?>
