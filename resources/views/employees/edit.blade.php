@extends('shared/layout')

@section('title','Edit Employee')

@section('content')

    <section class="index-page-section m-4">
    
        <div class="card">
            <div class="card-body">
                <div class="">
                        <div class="row">
                            <div class="col-8">
                                <h3 class="">Edit Employee</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a class="btn btn-primary" href="{{ url('/') }}">Back</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                        <form id="jquery-val-form" method="post" action="{{url('employees/update')}}">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="employee_id" value="{{ !empty($employee->employee_id) ? $employee->employee_id : '' }}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="username">Employee UserName<span class="text-danger">*</span></label>
                                    <input type="text" maxlength="50" autofocus class="form-control" id="username" name="username" required placeholder="Employee UserName" value="{{ !empty($employee->username) ? $employee->username : '' }}" autocomplete="off" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="email">Email<span class="text-danger">*</span></label>
                                    <input type="text" maxlength="50" autofocus class="form-control" id="email" name="email" required placeholder="Email" value="{{ !empty($employee->email) ? $employee->email : '' }}" autocomplete="off" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="phone">Phone<span class="text-danger">*</span></label>
                                    <input type="text" maxlength="50" autofocus class="form-control" id="phone" name="phone" required placeholder="Phone" value="{{ !empty($employee->phone) ? $employee->phone : '' }}" autocomplete="off" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="gender">Gender<span class="text-danger">*</span></label>
                                    <select id="gender" name="gender" class="form-control" style="">
                                        <option value="male" {{ $employee->gender ?? '' == 'male' ? 'Selected' : '' }}> Male</option>
                                        <option value="female" {{ $employee->gender ?? '' == 'female' ? 'Selected' : '' }}> Female </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-1">
                                <div class="form-group align-right" >
                                    <a href="{{ url('/') }}"> <button type="button" class="btn btn-outline-secondary" >Cancel</button></a>
                                    <button type="submit" class="btn btn-primary  mr-1" >Submit</button>
                            </div>
                            </div>
                        </div>
                        </form>
            </div>
        </div>
    </section>

@endsection


@section('vendor-scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
@endsection

@section('page-scripts')

<script>
    $(function () {
        var jqForm = $('#jquery-val-form');
        if (jqForm.length) {
            jQuery.validator.addMethod("validate_email", function(value, element) {
                if (/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
                    return true;
                } else {
                    return false;
                }
            }, "Please enter valid email");
            jQuery.validator.addMethod("require_field", function(value, element) {
                if(value.trim() ==''){
                    return false;
                }
                return true;
            }, "This field is required.");
            jQuery.validator.addMethod("is_phone_no", function(value, element) {
                if (/^\d{10}$/.test(value)) {
                    return true;
                } else {
                    return false;
                }
            }, "Please enter valid 10 digit mobile number");
            jqForm.validate({
                rules: {
                    'username': {
                        required: true,
                        require_field: true
                    },
                    'email': {
                        required: true,
                        validate_email: true,
                        email:true
                    },

                    'phone': {
                        required: true,
                        is_phone_no : true,
                    },
                    'gender': {
                        required: true,
                    },

                },
                messages: {

                }
            });
        }
    });
</script>
@endsection