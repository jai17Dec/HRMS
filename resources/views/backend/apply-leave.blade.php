@extends('layouts.backend')

@section('styles')	
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">

<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Apply Leave</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
			<li class="breadcrumb-item active">Apply Leave</li>
		</ul>
	</div>
	<!-- <div class="col-auto float-right ml-auto">
		<a href="javascript:void(0)" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
	</div> -->
</div>
@endsection


@section('content')
	
	
	

<!-- Add Leave Modal -->
<div id="add_leave" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Leave</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('employee-leave')}}">
					@csrf

					<div class="form-group">
						<label>Employee</label>
						<select name="employee" class="select">
							@foreach ($employees as $employee)
								<option value="{{$employee->id}}">{{$employee->firstname}} {{$employee->lastname}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label>Leave Type <span class="text-danger">*</span></label>
						<select name="leave_type" class="select">
							@foreach ($leave_types as $leave_type)
								<option value="{{$leave_type->id}}">{{$leave_type->type}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>From <span class="text-danger">*</span></label>
						<div class="cal-icon">
							<input name="from" class="form-control datetimepicker" type="text">
						</div>
					</div>
					<div class="form-group">
						<label>To <span class="text-danger">*</span></label>
						<div class="cal-icon">
							<input name="to" class="form-control datetimepicker" type="text">
						</div>
					</div>
					
					<div class="form-group">
						<label>Leave Reason <span class="text-danger">*</span></label>
						<textarea name="reason" rows="4" class="form-control"></textarea>
					</div>

					<div class="form-group">
                        <label>Status </label>
                        <select name="status" class="select">
                            <option value="null" disabled selected>Select Status</option>
                            <option>Approved</option>
                            <option>Pending</option>
                            <option>Declined</option>
                        </select>
                    </div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Add Leave Modal -->

<!-- Edit Leave Modal -->
<div id="edit_leave">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="color: #0dcaf0;">Apply Leave</h5>
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button> -->
			</div>
			<div class="modal-body">
				<form action="{{route('employee-leave')}}" method="post">
					@csrf
					@method("PUT")
					<input type="hidden" name="id" id="edit_id">
					<div class="form-group">
						<label>Employee<span class="text-danger">*</span></label>
						<select name="employee" class="select2" id="edit_employee">
							@foreach ($employees as $employee)
								<option value="{{$employee->id}}">{{$employee->firstname.' '.$employee->lastname}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label>Leave Type <span class="text-danger">*</span></label>
						<select name="leave_type" class="select2" id="edit_leave_type">
							@foreach ($leave_types as $leave_type)
								<option value="{{$leave_type->id}}">{{$leave_type->type}}</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
						<label>From <span class="text-danger">*</span></label>
						<div class="icon">
                           <input type="datetime-local" value="2017-06-01T00:00" class="form-control"/>
                        </div>
                    </div>

					<div class="form-group">
						<label>To <span class="text-danger">*</span></label>
						<div class="icon">
						    <input type="datetime-local" value="2017-06-01T00:00" class="form-control"/>
						</div>
					</div>
					
					<div class="form-group">
						<label>Leave Reason <span class="text-danger">*</span></label>
						<textarea name="reason" rows="4 " class="form-control" id="edit_reason"></textarea>
					</div>
					<div class="form-group">
                        <label>Status </label>
                        <select name="status" class="select2 form-control" id="edit_status">
                            <option value="null">Select Status</option>
                            <option>Approved</option>
                            <option>Pending</option>
                            <option>Declined</option>
                        </select>
                    </div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>

<!-- /Edit Leave Modal -->
@endsection

@section('scripts')
<!-- Select2 JS -->
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
	$(document).ready(function(){
		$('.editbtn').click(function(){
			var id = $(this).data('id');
			var employee = $(this).data('employee');
			var leave_type = $(this).data('leave_type');
			var status = $(this).data('status');
			var from  = $(this).data('from');
			var to  = $(this).data('to');
			var reason = $(this).data('reason')
			$('#edit_leave').modal('show');
			$('#edit_id').val(id);
			$('#edit_employee').val(employee).trigger('change');
			$('#edit_leave_type').val(leave_type).trigger('change');
			$('#edit_status').val(status).trigger('change');
			$('#edit_from').val(from);
			$('#edit_to').val(to)
			$('#edit_reason').append(reason);
			// check employee select
			$("#edit_employee option").each(function()
			{
				if($(this).val() == employee){
					$(this).attr('selected','selected');
				}
			});
			// check leave type select
			$("#edit_type option").each(function()
			{
				if($(this).val() == leave_type){
					$(this).attr('selected','selected');
				}
			});
			// check status select
			$("#edit_status option").each(function()
			{
				if($(this).val() == status){
					$(this).attr('selected','selected');
				}
			});
		});
	});
</script>
@endsection
