<div class="box box-widget widget-user-2" id="contenttop">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-red">
              <div class="widget-user-image">
                <img class="img-circle" src="{{ $profilepic }}" alt="User Avatar">
              </div>
              
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">{{ $vendor->Name }}</h3>
              <h5 class="widget-user-desc">{{ $vendor->id }}</h5>
              <a href="{{ url('/vendorzone/editphoto')}}" class="btn btn-warning btn-xs"><i class="fa fa-edit r-margin-5"></i>Edit Photo</a>
            </div>
    
            <div class="box-footer no-padding">
            <div class="row">
            	<div class="col-md-6">
            		<ul class="nav nav-stacked">
                <li><a href="#"><span style="font-weight: bold;">Vendor No</span> <span class="pull-right">{{ $vendor->id }}</span></a></li>
                
                
                
              </ul>
            	</div>
            	<div class="col-md-6">
            		<ul class="nav nav-stacked">
                <li><a href="#"><span style="font-weight: bold;">Name</span> <span class="pull-right">{{ $vendor->Name }}</span></a></li>
                 </ul>
            	</div>
            </div>
              
            </div>
          </div>