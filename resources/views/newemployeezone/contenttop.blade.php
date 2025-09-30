<div class="box box-widget widget-user-2" id="contenttop">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-red">
              <div class="widget-user-image">
                <img class="img-circle" src="{{ $profilepic }}" alt="User Avatar">
              </div>
              
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">{{ $employee->name }}</h3>
              <h5 class="widget-user-desc">{{ $employee->id }}</h5>
              <a href="{{ url('/employeezone/editphoto')}}" class="btn btn-warning btn-xs"><i class="fa fa-edit r-margin-5"></i>Edit Photo</a>
            </div>
    
            <div class="box-footer no-padding">
            <div class="row">
            	<div class="col-md-4">
            		<ul class="nav nav-stacked">
                <li><a href="#"><span style="font-weight: bold;">Employee Name</span> <span class="pull-right">{{ $employee->name }}</span></a></li>
                <li><a href="#"><span style="font-weight: bold;">Plant Name</span> <span class="pull-right">{{ $employee->plant_name }}</span></a></li>
                <li><a href="#"><span style="font-weight: bold;">Reporting Manager</span> <span class="pull-right">{{ $employee->reporting_manager }}</span></a></li>
                
                
                
              </ul>
            	</div>
            	<div class="col-md-4">
            		<ul class="nav nav-stacked">
                <li><a href="#"><span style="font-weight: bold;">Employee Id</span> <span class="pull-right">{{ $employee->id }}</span></a></li>
                <li><a href="#"><span style="font-weight: bold;">Plant Code</span> <span class="pull-right">{{ $employee->plantid }}</span></a></li>
                <li><a href="#"><span style="font-weight: bold;">SAP Id</span> <span class="pull-right">{{ $employee->sap_id }}</span></a></li>
                 </ul>
            	</div>
            	<div class="col-md-4">
            		<ul class="nav nav-stacked">
                <li><a href="#"><span style="font-weight: bold;">Department</span> <span class="pull-right">{{ $employee->department }}</span></a></li>
                <li><a href="#"><span style="font-weight: bold;">Position</span> <span class="pull-right">{{ $employee->position }}</span></a></li>
                <li><a href="#"><span style="font-weight: bold;">Role</span> <span class="pull-right">{{ $employee->role_name }}</span></a></li>
                 </ul>
            	</div>
            </div>
              
            </div>
          </div>