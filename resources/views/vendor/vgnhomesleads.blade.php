<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }




    </style>

   

<h3>Dear Team,<h3>
<p>Please find the below enquired lead details.</p>


<div class="w3-example" style="background-color: #f1f1f1;
    padding: 0.01em 16px;
    margin: 20px 0;
    box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;width:550px;" >
<h3>Lead Details</h3>
<div style="color: #000!important;
    background-color: #fff!important;padding: 8px 16px!important;">
<table class="table table-striped" style="display:table;border-color: grey;" cellpadding="10">

<tbody style="display: table-row-group;
    vertical-align: middle;
    border-color: inherit;">
<tr style="background-color: #f9f9f9;">
    <td>Project Name</td>
    <td>{{$data['maildata']->Project_name}}</td>
  </tr>
  

  <tr style="background-color: #f9f9f9;">
    <td>Enquired Source</td>
    <td>{{$data['maildata']->Source_type}}</td>
  </tr>
 
  <tr>
    <td>Name</td>
    <td>{{$data['maildata']->Name}}</td>
  </tr>
  <tr style="background-color: #f9f9f9;">
    <td>Email</td>
    <td>{{$data['maildata']->Email}}</td>
  </tr>
  <tr>
    <td>Mobile Number</td>
    <td>{{$data['maildata']->Mobile}}</td>
  </tr>
   <tr style="background-color: #f9f9f9;">
    <td>Lead Enquired Datetime</td>
    <td>{{$data['maildata']->lead_datetime}}</td>
  </tr>
 
  
</tbody>
</table>
</div>
</div>
<br>




<ol style="color:#968c7e; font-style:italic;" type="i">
<p style="font-style:italic;"><b>Note:<b></p>

<li>This is system generated mail. Please do not reply.</li>
</ol>





</body>
</html>
