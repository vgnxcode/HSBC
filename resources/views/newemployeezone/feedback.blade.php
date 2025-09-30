@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Employee TRAINING SCHEDULE Page @endsection @section('description')
<meta name="description" content=""> @endsection @section('keyword') @endsection @section('style') @include('newemployeezone.styles.commoncss')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">
<style>
  .carousel-inner>.item>img {
    min-height: 280px;
  }

  #changedetailsForm label.col-sm-2 {
    font-weight: normal;
  }

  .modal-header {
    background-color: #EF5350;
    color: #fff;
    font-weight: bold;
  }

  .marg_left {
    margin-left: 10px;
  }
</style> @endsection @section('bodycontent') <body class="hold-transition skin-red fixed sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper"> @foreach($getemployeedata as $employee) @include('newemployeezone.header.index') @include('newemployeezone.aside.index')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-10 col-md-offset-1"> @include('newemployeezone.contenttop') </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">
                  <i class="fa fa-file-text margin-r-5"></i> Feedback
                </h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body" style="padding:30px; padding-top:10px;">
                
              <form id="" method="POST" action="{{ url('/employeezone/feedback') }}" class="">
                  {{ csrf_field() }}
                    <h5 class="text-red">
                        <i class="fa fa-info-circle margin-r-5"></i>This Survey aims to gather information on employee satisfaction and how you think and feel about the company. We request all to give honest and open feedback. Feedback collected will be constructively used to make the organisation a better place to work.
                    </h5>
                    <h6 style="margin-bottom:30px"><b>Disclaimer:</b> Any opinions given here will not be used for any performance appraisal purposes and all of you have complete authority to state whatever you want to. Most importantly there are no correct or wrong answers. State clearly whatever you want to say</h6>
                  <!-- <div class="row" style="margin-left:3px;">
                    <div class="col-md-12"> -->
                        <div class="form-group">
                            <label for="question1" class="form-label">1. Overall, what are the aspects which give you Job satisfaction in our company?</label>
                            <textarea class="form-control" id="question1" name="question1" maxlength="200" rows="2" cols="20"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="question2" class="form-label">2. Overall, what are the aspects which do not give you Job satisfaction at workplace?</label>
                            <textarea class="form-control" id="question2" name="question2" maxlength="200" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="question3" class="form-label">3. Certain points that the Organization can do to give you better job satisfaction and make it a better place to work?</label>
                            <textarea class="form-control" id="question3" name="question3" maxlength="200" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="question4" class="form-label">4. Certain points that you as an employee can do to make the organisation better?</label>
                            <textarea class="form-control" id="question4" name="question4" maxlength="200" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="question5" class="form-label">5. Are you comfortable at the new HQ at Anna Nagar environment? YES / NO</label>
                            <h5 style="margin:0px;">If No (Kindly mention the Feedback and steps to improve):</h5>
                            <!-- <textarea class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea> -->
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="question_yes" id="question_yes" value="option1">
                            <label class="form-check-label" for="question_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="question_no" id="question_no" value="option2">
                            <label class="form-check-label" for="question_no">No</label>
                        </div>
                        <div class="form-group">
                            <!-- <label for="exampleFormControlTextarea1" class="form-label">5. Are you comfortable at the new HQ at Anna Nagar environment? YES / No</label>
                            <p>IF No (Kindly mention the Feedback and steps to improve):</p> -->
                            <textarea class="form-control" id="question5" name="question5" maxlength="200" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                          <input class="submitbtn btn btn-danger" type="submit" value="Submit" id="submit" />
                          <!-- <a href="{{ url('/employeezone/') }}" class="btn btn-warning">Cancel</a> -->
                        </div>
                      <!-- <h4 class="text-red">
                        <i class="fa fa-info-circle margin-r-5"></i> Edit Account Information
                      </h4> -->
                      <!-- <div class="form-group">
                        <label for="bank_act_no" class="col-sm-2 ">Bank Account No*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="{{ old('bank_account_no') }}" name="bank_account_no" id="bank_act_no" required> {!! $errors->first('bank_account_no', ' <span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="retype_bank_account_no" class="col-sm-2 ">Retype Bank Account No*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="{{ old('confirm_bank_account_no') }}" name="retype_bank_account_no" id="confirm_bank_account_no" required> {!! $errors->first('retype_bank_account_no', ' <span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="bank_name" class="col-sm-2 ">Bank Name*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="{{ old('bank_name') }}" name="bank_name" id="bank_name" required> {!! $errors->first('bank_name', ' <span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="ifsc_code" class="col-sm-2">IFSC Code*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="{{ old('ifsc_code') }}" name="ifsc_code" id="ifsc_code" required> {!! $errors->first('ifsc_code', ' <span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="branch_name" class="col-sm-2">Branch Name*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" value="{{ old('branch_name') }}" name="branch_name" id="branch_name" required> {!! $errors->first('branch_name', ' <span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <br />
                      <br />
                      <div class="form-group">
                        <div class="col-sm-7">
                          <input class="submitbtn btn btn-danger" type="submit" value="Update" id="submit" />
                          <a href="{{ url('/employeezone/') }}" class="btn btn-warning">Cancel</a>
                        </div>
                      </div> -->
                    <!-- </div>
                  </div> -->
                </form>
                <h5><b>Thank you very much for participating in employee job satisfaction survey. We appreciate your feedback.</b></h5>
              </div>
              <!-- /.box-body -->
              
            </div>
          </div>
        </div>
        <!-- Modal -->
        <!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"></h4>
              </div>
              <div class="modal-body"> ... </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div> -->
        </div> @endforeach
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
      </div>
      <strong>Copyright &copy; 2019 <a href="http://www.vgn.in">VGN Property Developers Pvt. Ltd</a>. </strong> All rights reserved.
    </footer>
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper --> @endsection @section('script') @include('newemployeezone.js.commonjs') <script>
    function stripslashes(str) {
      str = str.replace(/\\'/g, '\'');
      str = str.replace(/\\"/g, '"');
      str = str.replace(/\\0/g, '\0');
      str = str.replace(/\\\\/g, '\\');
      return str;
    }
  </script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
  <script>
    $(document).ready(function() {
      var table = $('#example').DataTable({
        "order": [
          [1, "desc"]
        ],
        rowReorder: false,
        responsive: true
      });
    });
  </script> @endsection