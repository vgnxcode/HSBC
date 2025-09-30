@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| View Lead script Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')

<!--<link rel="stylesheet" type="text/css" href="{{ asset('/newcustomerzoneassets/payslip/style.css') }}" />-->
        <link rel="shortcut icon" href="{{ config('app.AWS_URL')}}/images/vgnfavicon.png" >
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/font-awesome/css/font-awesome.min.css">



		<style>
            .titl h2 {
    font-size: 18px;
    text-align: center;
    line-height: 1.5;
                color: #fff;
}
            .logo img
{
	    background: #fff;
		padding: 5px;
		border-radius: 6px;
	}
            table.payslip {
    border: 2px solid #000;
	    
    background-repeat: no-repeat;
    background-size: cover;
	font-size: 12px;
	width:60%
}
			.titl p {
    font-size: 14px;
    text-align: center;
    line-height: 1;
    color: #fff;

    }

    .imptext {
    font-size: 14px;
    text-align: center;
    line-height: 1.5;
    color: #000;

    }
	
	table#csstable {
		border: 1px solid #000;
		margin: 10px 0px;
	}

	table#csstable caption {

		font-size: 16px;
		font-weight: bold;
		border-top: 1px solid #000;
		text-align: center;
    	padding: 5px;
    	background: #fd5c63;
        color: #fff;
	}
     table#csstable thead th {
     	border: 1px solid #000;
    	text-align: center;
    	padding: 5px;
    	background: #fd5c63;
         color: #fff;
    }

     table#csstable tbody tr td {
     	border: 1px solid #000;
    	text-align: center;
    	padding: 3px;
    	background: #fff;
    }
            .demo-icon {
    font-size: 22px;
    line-height: 40px;
    float: left;
    width: 40px;
    height: 40px;
    margin: 10px;
    text-align: center;
    color: #fff;
    border: 1px solid #fafafa;
    border-radius: 3px;
}
            .demo-icon:hover {
    color: #fff;
    cursor: pointer;
            }
		</style>

<script>
	function print() {
    printData();
}
function printData()
{
   var divToPrint=document.getElementById("printTable");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}
</script>
@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- Site wrapper -->


@foreach($getemployeedata as $employee)

<table align="center"  border="0" cellpadding="0" cellspacing="0" id="printTable" data-editable="text" class="payslip">
<tr>
	<td align="left"  valign="top" style="padding:8px 27px 10px 7px;;margin:0;background: #fd5c63;    border-bottom: 1px solid rgb(33, 33, 33)">
		<div class="head">
		<div class="logo col-md-1">
		<img src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/payslip/vgn-logo.png">
		</div>
		<div class="titl col-md-9">
		<p>Sales Executive: {{$empname}}</p>
		<p>Script For: <?php echo strtoupper($type); ?> Leads</p>
		<p>Project: {{$plant}}</p>
		</div>
		<div class="print col-md-1 pull-right">
		<div class="pull-right glyph-icon demo-icon tooltip-button icon-print hidden-print" title="Print" data-original-title=".icon-print" id="clickprint" style="border: 1px solid #ccc;"> <i class="fa fa-print"></i></div>
		
		<div class="visible-print pull-right"><?php echo "printed on" . date("d.m.y") ;?></div>
		</div>
		</div>
	</td>
</tr>
<tr>
	<td>
		
		<table  width="100%" cellpadding="0" cellspacing="0" data-editable="text" id="maintable">
		<th style="text-align: center;font-size: 18px;padding: 5px;border-bottom: 1px solid;">Script Content</th>
		</table>

	</td>
</tr>

<tr>
<td>
			<table width="100%" cellpadding="0" cellspacing="0" data-editable="text" id="csstable">
			<thead>
			<th align="center">Sl.No</th>
			<th>Description</th>
			</thead>
			<tbody>
			@if(count($result) > 0)
             <?php $count = 1; ?>
        @foreach($result as $res)
        

        <tr>
        <td>{{$count}}</td>
        <td>{{ $res['Script_Content'] }}</td>
        
        </tr>
        
        <?php $count += 1; ?>
        @endforeach
        @endif  
			</tbody>
			</table>
</td>

</tr>


</table>
 
 
@endforeach


@endsection

@section('script')
<!-- jQuery 3 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/printPreview.js"></script>

<script>
    
    var now = new Date();
var time = now.getTime();
time += 3600 * 1000;
now.setTime(time);

    document.cookie = 
'viewquote=viewquoteloaded; expires=' + now.toUTCString() + 
'; path=/';
   
</script>

<script type="text/javascript">
        $(function(){
            
           
            
            $("#clickprint").printPreview({
                obj2print:'#printTable',
                
                title:'View Lead Script',
                resizable : 'no'
                
                /*optional properties with default values*/
                //obj2print:'body',     /*if not provided full page will be printed*/
                //style:'',             /*if you want to override or add more css assign here e.g: "<style>#masterContent:background:red;</style>"*/
                //width: '670',         /*if width is not provided it will be 670 (default print paper width)*/
                //height:screen.height, /*if not provided its height will be equal to screen height*/
                //top:0,                /*if not provided its top position will be zero*/
                //left:'center',        /*if not provided it will be at center, you can provide any number e.g. 300,120,200*/
                //resizable : 'yes',    /*yes or no default is yes, * do not work in some browsers*/
                //scrollbars:'yes',     /*yes or no default is yes, * do not work in some browsers*/
                //status:'no',          /*yes or no default is yes, * do not work in some browsers*/
                //title:'Print Preview' /*title of print preview popup window*/
                
            });
              
        });
    </script>


@endsection
