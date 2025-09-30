@extends('newcustomerzone.layout')

@section('title')
VGN Property Developers |Customer Zone| Customer Satisfaction Survey
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/defines.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<style>
  .carousel-inner>.item>img
  {
    min-height: 280px;
  }
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }
    .grow { transition: all .2s ease-in-out; }
.grow:hover { transform: scale(1.1); }

.swal2-styled.swal2-confirm{
  background-color: #dd4b39;
}

.swal2-modal{
    width: 500px;
}
/* .swal2-content{
  font-size: 1.55em;
} */
</style>

@endsection

@section('bodycontent')
<body class="hold-transition fixed">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getcustomerdata as $customer)


 
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper1">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
  
  
  <div class="row" >
    
    <div class="col-md-10col-md-offset-1" >
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title" style="padding-top: 13px;"><i class="fa fa-line-chart margin-r-5"></i> VGN Projects Estates Customer Satisfaction Survey </h3>
                <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" alt="vgn logo" class="img-responsive pull-right">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form name="myform" id="myform">
                   <div class="row" style="text-align:center;">
                       <div class="col-md-12" style="margin-left:40px;">
                        <h3 class="text-bold">How satisfied are you, with your customer care executive?</h3>

                           <div class="col-md-2 col-sm-12 grow"  style="text-align:center;">
                           <div class="radio">
                            <label>
                           <img src="{{ config('app.AWS_URL')}}/images/emoji/smileys/extremely_satisfied.png" class="ex_sat" alt="extremley satisfied"><br>
                           <input type="radio" name="optradio" value="1" "@if($rating == 1) checked @endif" class="p3">Extremely Satisfied</label>
                            </div>

                           </div>

                           <div class="col-md-2 col-sm-12 grow"  style="text-align:center;">
                           <div class="radio">
                            <label>
                           <img src="{{ config('app.AWS_URL')}}/images/emoji/smileys/somewhat_satisfied.png" class="ex_sat" alt="satisfied"><br>
                           <input type="radio" name="optradio" value="2" "@if($rating == 2) checked @endif" class="p3">Somewhat Satisfied</label>
                            </div>
                           </div>

                           <div class="col-md-2 col-sm-12 grow"  >
                           <div class="radio" style="text-align:center;">
                            <label>
                           <img src="{{ config('app.AWS_URL')}}/images/emoji/smileys/neutral.png" alt="neutral"><br>
                           <input type="radio" name="optradio" value="3" "@if($rating == 3) checked @endif">Neutral</label>
                            </div>
                           </div>

                           <div class="col-md-2 col-sm-12 grow"  style="text-align:center;">
                           <div class="radio">
                            <label>
                           <img src="{{ config('app.AWS_URL')}}/images/emoji/smileys/somewhat_dissatisfied.png" alt="Somewhat Dissatisfied"><br>
                           <input type="radio" name="optradio" value="4" "@if($rating == 4) checked @endif">Somewhat Dissatisfied</label>
                            </div>
                           </div>

                            <div class="col-md-2 col-sm-12 grow"  style="text-align:center;">
                            <div class="radio">
                            <label>
                           <img src="{{ config('app.AWS_URL')}}/images/emoji/smileys/extremely_dissatisfied.png" alt="Extremely Dissatisfied"><br>
                           <input type="radio" name="optradio" value="5" "@if($rating == 5) checked @endif">Extremely Dissatisfied</label>
                            </div>
                           </div>

                

            
                       </div>
                   </div>
                         
                         <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                     <div class="alert text-justify" style="background-color: #fbc0c0;color: #020202;box-shadow: 4px 4px 8px #eee;">
         <h4 style="font-weight: normal;"><span style="line-height: 2.2em; font-weight: 600;">Dear {{ $customer->name }},</span><br> Greetings from VGN! With a view to enhancing customer delight and customer
    satisfaction. please rate your overall satisfaction level with your
    customer care executive.</h4>
      </div>
    </div>
                         </div>   

                         <div class="row" id="subfbackbtn">
                          <div class="col-md-8 col-md-offset-2 " style="margin-left: 30%;">
                           <button type="button" class="btn btn-danger btn-lg " id="sub_click"><i class="fa fa-send"></i> Submit Feedback</button>
                           </div>
                         </div>
                                
                </form>
              

              
            </div>
            <!-- /.box-body -->
          </div>

    </div>


    

    
  </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')


<script type="text/javascript">
  
  function triggerswal(valselected,customerid)   {
    var dissatlist = @json($dissatisfationlist);
    if($.isArray(dissatlist) == false){
      dissatlist = [dissatlist];
    }
    //console.log(dissatlist);
    var newlist = {};
    var ii = 1;
    $.each(dissatlist,function(k,v){
      //console.log(k);
      //console.log(v);
      if (v.Reasons != '') {
        newlist[v.Reasons] = ii+'. '+v.Reasons;
        ii++;
      }
    });
    //console.log(newlist);
    Swal.fire({
  title: 'Please let us know the reason for your dissatisfaction, so that we can impove your experience?',
  input: 'select',
  inputOptions: newlist,
  inputPlaceholder: 'Select Reasons',
  showCancelButton: true,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "Submit Feedback",
  inputValidator: function (value) {
    return new Promise(function (resolve, reject) {
      if (value !== '') {

        $.post("/csurvey/{{$customerid}}", {_token:'{{csrf_token()}}',customerid: customerid,selectedval:valselected,reason: value}, function(data){
                                if (data == 1) {
                                    if ((valselected == 4) || (valselected == 5)) {
                                      console.log(valselected);
                                     $.post("/checksurvey/triggerdissatisfactionsmsmail", {_token:'{{csrf_token()}}',customerid: customerid,selectedval:valselected}, function(data){
                                      console.log(data);
                                     });
                                   }
                                    resolve();
                                    //window.location.reload();
                                }
                                else{
                                    //resolve();
                                    alert('Sorry, not updated. Try again!');
                                    window.location.reload();
                                }
                            });
        
      } else {
        resolve('Kindly select the reason.');
      }
    });
  }
}).then(function (result) {
  if (result.value) {
    Swal.fire({
      type: 'success',
      html: 'Thanks for your valuble feedback!'
    });
                                    setTimeout(function(){
                                      window.location.reload();
                                    },5000);
  }
});
  }

        $(document).ready(function(){

                        $('input[name=optradio]').on('change', function() {
                          var customerid = <?php echo $customer->id; ?>; 
                          var valselected = $('input[name=optradio]:checked', '#myform').val();
                          if ((valselected == '4') || (valselected == '5')) {
                            
                            triggerswal(valselected,customerid);



                          }
                          else{

                          }
                        });
                       
                        $('#sub_click').on('click', function() {
                            var selectedval = $('input[name=optradio]:checked', '#myform').val();
                            var customerid = <?php echo $customer->id; ?>; 
                           // alert(selectedval);
                            if ((selectedval == 4) || (selectedval == 5)) {
                                      triggerswal(selectedval,customerid);
                                   }else{

                                   

                            $.post("/csurvey/{{$customerid}}", {_token:'{{csrf_token()}}',customerid: customerid,selectedval:selectedval,reason:''}, function(data){
                                if (data == 1) {

                                     Swal.fire({
      type: 'success',
      html: 'Thanks for your valuble feedback!'
    });
                                     setTimeout(function(){
                                      window.location.reload();
                                    },5000);
                                    
                                }
                                else{
                                   Swal.fire({
      type: 'danger',
      html: 'Sorry, not updated. Try again!'
    });
                                    //alert('Sorry, not updated. Try again!');
                                     setTimeout(function(){
                                      window.location.reload();
                                    },5000);
                                }
                            });

                          }
                        });
    
        });       
        </script>
            @endforeach
@endsection