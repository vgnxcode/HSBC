<div class="box box-widget widget-user-2" id="contenttop">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-red">
              <div class="widget-user-image">
                <img class="img-circle" src="{{$profilepic}}" alt="User Avatar">
              </div>
              
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">{{ $customer->name }}</h3>
              <h5 class="widget-user-desc">{{ $customer->id }}</h5>
              <a href="{{ url('/customerzone/editphoto')}}" class="btn btn-warning btn-xs"><i class="fa fa-edit r-margin-5"></i>Edit Photo</a>
            </div>
    
            <div class="box-footer no-padding">
            <div class="row">
            	<div class="col-md-6">
            		<ul class="nav nav-stacked">
                <li><a href="#"><span style="font-weight: bold;">Customer No</span> <span class="pull-right">{{ $customer->id }}</span></a></li>
                <li><a href="#"><span style="font-weight: bold;">Name</span> <span class="pull-right ">{{ $customer->name }}</span></a></li>
                
                
              </ul>
            	</div>
            	<div class="col-md-6">
            		<ul class="nav nav-stacked">
                <li><a href="#"><span style="font-weight: bold;">Customer Care Executive</span> <span class="pull-right">{{ $customer->customer_executive }}</span></a></li>
                <li><a href="#"><span style="font-weight: bold;">Customer Care Manager</span><span class="pull-right">{{ $customer->customer_manager }}</span></a></li>
              </ul>
            	</div>
            </div>
@if(count($getblockdates) > 0)

<!--- start-->

<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-stacked">
    <li style="padding: 10px;">
      <table class="table table-bordered" style="box-shadow: 2px 2px 4px #ccc;">
<thead style="background: #dd4b39;color: #fff;">
<tr >
<th scope="col" style="text-align: center;">S.No</th>
<th scope="col" style="text-align: center;">Project Name</th>
<th scope="col" style="text-align: center;">Unit Name</th>
<th scope="col" style="text-align: center;">Block Name</th>
<th scope="col" style="text-align: center;">Block Handover Date</th>
</tr>
</thead>
<tbody>
<?php $k = 1; ?>
@foreach($getblockdates as $dlval)
<tr style="text-align: center;">
<td>{{$k}}</th>
<td>VGN {{$dlval->pname}}</td>
<td>{{$dlval->unit_nm}}</td>
<td>{{$dlval->Block_name}}</td>
<td>{{ \Carbon\Carbon::parse($dlval->exp_date_of_compl)->format('d/m/Y')}}</td>
</tr>
<?php $k++; ?>
@endforeach

</tbody>
</table>

</li>
    
    
  </ul>
  </div>
 
</div>
<!--- end-->
@endif
      </div>
          </div>