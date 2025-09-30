<?php

/**
 * Development System
 */
return [

    'sapusername' => "uday",
    'sappassword' => "Dev@12345",   


    'poststep1hsbcprocess_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/6c6a7fed44d13bfa9b1b5d8fcff2d482',
    'poststep1hsbcprocess_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_HSBC_ACCOUNT_CREATE_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com',

    'poststep2hsbcprocess_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/5085a0ae4b83323abcc402a3243f87c0',
    'poststep2hsbcprocess_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_HSBC_TRANSACTION_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com',
    
    'poststep3hsbcprocess_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/fc0181b0a9fa3423904492d02a42696a',
    'poststep3hsbcprocess_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_HSBC_PAYMENT2BANK_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com',

    'poststep4hsbcprocess_wsdl' => 'http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/1db5528b04a73410822745ad1bcb95a7',
    'poststep4hsbcprocess_endpoint' => 'http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_HSBC_PAYMENT_REFERENCENUMBER_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com',


    // 'poststep1hsbcprocess_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/320b7deb25d73e32938ccc608e47e8cf',
    //  'poststep1hsbcprocess_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_HSBC_ACCOUNT_CREATE_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com',

    //  'poststep2hsbcprocess_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/b3416ea341703d7684930dfeedec608e',
    //  'poststep2hsbcprocess_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_HSBC_TRANSACTION_DETAILS_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com',
     
    //  'poststep3hsbcprocess_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/a783e7ab5602325abd01fb1f78828b3e',
    //  'poststep3hsbcprocess_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_HSBC_PAYMENT2BANK_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com',

    //  'poststep4hsbcprocess_wsdl' => 'http://vgnpiprd.vgn.in:50000/dir/wsdl?p=ic/8681a61886553ab3874bed30877dd0fd',
    //  'poststep4hsbcprocess_endpoint' => 'http://vgnpiprd.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BC_WEB_PRD&receiverParty=&receiverService=&interface=SI_HSBC_PAYMENT_REFERENCENUMBER_OUT&interfaceNamespace=http%3A%2F%2Fsap_banking_process.com',
 
];
?>