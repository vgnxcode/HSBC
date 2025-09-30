<!-- jQuery 3 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script> -->
<!-- Bootstrap 3.3.7 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/demo.js"></script>


<script src="{{ config('app.AWS_URL')}}/assets/js/jquery.ccpicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/assets/css/jquery.ccpicker.css">

<script>
	
	$(document).ready(function() {
	//jquery
	  

    var url = $(location).attr('href');
        
    parts = url.split("/"),
    last_part = parts[parts.length-1];
	// to show it in an alert window
        //console.log(last_part);
        if (last_part.indexOf('#') == -1) {
   $("#"+last_part).addClass('active');
}else{
    $("#"+last_part.slice(0, -1)).addClass('active');
}
        
        

            

});

</script>