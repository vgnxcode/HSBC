<?php
/**
 * Production System
 */
return [

    'sapusername' => "uday",
    //'sappassword' => "Vgn@321",
    'sappassword' => "Dev@12345",
    //'sapusername' => "vgnpiuser",
    //'sappassword' => "vgnd@1234",
	
    'showleaddetails_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/870a640d43933835b939e45e3e724541",
    'showleaddetails_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_AMEYO_SHOW_LEADDETAILS_OUT&interfaceNamespace=http://sap_customer_data_to_webpage.com",

    'showleaddetailsbyleadno_wsdl' => "http://vgnsap.vgn.in:50000/dir/wsdl?p=ic/0eeb16560b6b33b9842e37c0c2735d02",
    'showleaddetailsbyleadno_endpoint' => "http://vgnsap.vgn.in:50000/XISOAPAdapter/MessageServlet?senderParty=&senderService=BS_WEB&receiverParty=&receiverService=&interface=SI_AMEYO_DETAILS_BY_LEAD_NO_OUT&interfaceNamespace=http://sap_customer_data_to_webpage.com",

    'customer_detailsbycustid_wsdl' => "",
    'customer_detailsbycustid_endpoint' => "",

    'postleaddetails_wsdl' => '',
    'postleaddetails_endpoint' => '',

    'customer_paymentdetails_wsdl' => '',
    'customer_paymentdetails_endpoint' => '',

    'crm_execshow_wsdl' => '',
    'crm_execshow_endpoint' => '',

    'get_crm_email_wsdl' => '',
    'get_crm_email_endpoint' => '',

    'postleaddetailsnew_wsdl' => '',
    'postleaddetailsnew_endpoint' => '',

    'getactivecampaign_wsdl' => '',
    'getactivecampaign_endpoint' => '',

];

?>
