@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| My Reporting Structure Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
<!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/css/jquery.orgchart.min.css">
<style>
.orgchart { background: #fff; }
    .orgchart td.left, .orgchart td.right, .orgchart td.top { border-color: #aaa; }
    .orgchart td>.down { background-color: #aaa; }
    .orgchart .middle-level .title { background-color: #006699; }
    .orgchart .middle-level .content { border-color: #006699; }
    .orgchart .product-dept .title { background-color: #009933; }
    .orgchart .product-dept .content { border-color: #009933; }
    .orgchart .rd-dept .title { background-color: #993366; }
    .orgchart .rd-dept .content { border-color: #993366; }
    .orgchart .pipeline1 .title { background-color: #996633; }
    .orgchart .pipeline1 .content { border-color: #996633; }
    .orgchart .frontend1 .title { background-color: #cc0066; }
    .orgchart .frontend1 .content { border-color: #cc0066; }
    
    #chart-container {
  position: relative;
  display: inline-block;
  top: 10px;
  left: 10px;
  height: auto;
  
  /*width: 100%;*/
  border: 2px dashed #aaa;
  border-radius: 5px;
  overflow: auto;
  text-align: center;
}
   #chart-container .content {
    min-height: 0;
    padding: 0;
    margin-right: 0;
    margin-left: 0;
    padding-left: 0;
    padding-right: 0;
}
    
    
    /*==================================================
=            Bootstrap 3 Media Queries             =
==================================================*/

    /*==========  Mobile First Method  ==========*/

    /* Custom, iPhone Retina */ 
    @media only screen and (min-width : 320px) {
        #chart-container {
            width: calc(100% - 100px);
        }
    }

    /* Extra Small Devices, Phones */ 
    @media only screen and (min-width : 480px) {
        #chart-container {
            width: calc(100% - 100px);
        }
    }

    /* Small Devices, Tablets */
    @media only screen and (min-width : 768px) {
        #chart-container {
            width: calc(100% - 100px);
        }
    }

    /* Medium Devices, Desktops */
    @media only screen and (min-width : 992px) {
        #chart-container {
            width: calc(100% - 100px);
        }
    }

    /* Large Devices, Wide Screens */
    @media only screen and (min-width : 1200px) {
        #chart-container {
            width: calc(100% - 100px);
        }
    }

    /*==========  Non-Mobile First Method  ==========*/

    /* Large Devices, Wide Screens */
    @media only screen and (max-width : 1200px) {
        #chart-container {
            width: calc(100% - 100px);
        }
    }

    /* Medium Devices, Desktops */
    @media only screen and (max-width : 992px) {
        #chart-container {
            width: calc(100% - 100px);
        }
    }

    /* Small Devices, Tablets */
    @media only screen and (max-width : 768px) {
#chart-container {
            width: calc(100% - 15px);
        }
    }

    /* Extra Small Devices, Phones */ 
    @media only screen and (max-width : 480px) {
    #chart-container {
            width: calc(100% - 15px);
        }
    }

    /* Custom, iPhone Retina */ 
    @media only screen and (max-width : 320px) {
        #chart-container {
            width: calc(100% - 15px);
        }
    }

</style>

<script>
  function  reloadpage(){
    window.location.reload();
  }
</script>

@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getemployeedata as $employee)


 
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	



	<div class="row">
		
    <div class="col-md-12">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title" style="color: #fff;"><i class="fa fa-tree margin-r-5"></i> Reporting Structure </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="boxbody">
              
               <div class="col-sm-6 col-sm-offset-3">
				 @if(session()->has('error_msg'))
				        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {{Session::get('error_msg')}}
              </div>
				        <br>
				 @endif
                 @if(session()->has('suc_msg'))
				        
				        <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                {{Session::get('suc_msg')}}
              </div>
				        <br>
				 @endif
              </div>
                
                <br>
  <br>
  
                <div id="edit-panel" class="view-state">
    <input type="text" id="selected-node" placeholder="please select node" readonly="true" style="display:none;">
    <button type="button" id="btn-report-path" style="display: none;">Click node to draw other employee reporting path</button>
    <button type="button" onclick="reloadpage()">Reset to My Employee Node</button>
    
    <button type="button" id="btn-reset">Overall Organization chart</button>
  </div>
       <br>
  <br>         
  
              
                  <div id="chart-container" class="col-md-12"></div>
              
  
                
                 
                
              

              
            </div>
            <!-- /.box-body -->
          </div>

    </div>


		

		
	</div>
@endforeach
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  

  

</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newemployeezone.js.commonjs')

 <!-- the following reference is specific for IE -->
  <script type="text/javascript" src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/es6-promise.auto.min.js"></script>
  <script type="text/javascript" src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/html2canvas.min.js"></script>
  <script type="text/javascript" src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/jspdf.min.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/jquery.orgchart.min.js"></script>
<script type="text/javascript">
    $(function() {
        
        var datascource = <?php echo json_encode($test); ?>;         

        var nodeTemplate = function(data) {
      return `
        <span class="office">${data.Plant}</span>
        <div class="title">${data.empno}</div>
        <div class="content"><span>${data.name}</span><br><span>${data.title}</span><br><span>${data.Department}</span></div>
      `;
    };
        
        
   var oc = $('#chart-container').orgchart({
      'data' : datascource,
        'pan' :true,
       'zoom' : false,
      'nodeTemplate': nodeTemplate,
        'exportButton': true,
      'exportFilename': "{{$employeeid}}_reporting_structure",
       'exportFileextension': "pdf"
       
    });
        
        //var a = $('#selected-node').val("100212");
        
        var check = $('.title:contains("{{$employeeid}}")');
        check.closest('div.node').addClass('focused');
        var a = $('#selected-node').val("{{$employeeid}}");
          setTimeout(function() {
        $( "#btn-report-path" ).trigger( "click" );
              },10);
        oc.$chart.find('.node').on('click', function() {
      var a = $('#selected-node').val($(this).children('.title').text());
             //console.log($(this).children('.title').text());
             
    });
        $('#btn-report-mypath').on('click', function() {
            $( "#btn-reset" ).trigger( "click" );
            var newcheck = $('.title:contains("{{$employeeid}}")');
        newcheck.closest('div.node').addClass('focused');
        var newa = $('#selected-node').val("{{$employeeid}}");
          setTimeout(function() {
        
        $( "#btn-report-path" ).trigger( "click" );
              },20);
       
            
        });
        
        
         /*oc.$chart.find('.node').on('click', function() {
      var a = $('#selected-node').val("100212");
             console.log($(this).children('.title').text());
             
    });*/
        
        $('#btn-report-path').on('click', function() {
            console.log('clicked');
      var $selected = $('#chart-container').find('.node.focused');
      if ($selected.length) {
        $selected.parents('.nodes').children(':has(.focused)').find('.node:first').each(function(index, superior) {
          if (!$(superior).find('.horizontalEdge:first').closest('table').parent().siblings().is('.hidden')) {
            $(superior).find('.horizontalEdge:first').trigger('click');
          }
        });
        //$(this).prop('disabled', true);
      } else {
        alert('please select the node firstly');
      }
    });
        
        $('#btn-reset').on('click', function() {
      $('#chart-container').find('.hidden').removeClass('hidden')
        .end().find('.slide-up, .slide-right, .slide-left, .focused').removeClass('slide-up slide-right slide-left focused');
      $('#btn-report-path').prop('disabled', false);
      $('#selected-node').val('');
    });

  });
  </script>
@endsection
