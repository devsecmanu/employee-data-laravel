@extends('shared/layout')

@section('title','Employee List')

@section('vendor-styles')
<link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
@endsection

@section('page-styles')

@endsection

@section('content')

    <section class="index-page-section m-4">
    
        <div class="card p-2">
            <div class="row mb-2 mt-2">
                <div class="col-8">
                 <h3 class="mt-2"><strong>Employees List</strong></h3>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ url('/employees/add') }}" class="btn btn-primary">Add Employee</a>
                </div>
             </div>
             <div class="row mb-2">
                <div class="col-md-2">
                    <label>Gender</label>
                    <select id="gender" class="form-control gender_filter" style="">
                        <option value=""> Select Gender </option>
                        <option value="male" selected> Male </option>
                        <option value="female"> Female </option>
                    </select>
                </div>  
            </div>
            <div class="card-body">
                <div class="">
                    <table class="table" id="employee-table_table">
                        <thead class="">
                            <tr> 
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('vendor-scripts')
    {{-- vendor files --}}
    <script src="{{ asset('vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
@endsection

@section('page-scripts')
    {{-- Page js files --}}
    <script>

        $(document).ready(function () {


            var table = $('#employee-table_table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: {
                    url : "{{ url('/') }}",
                    data: function ( data ) {
                        data.gender = jQuery('#gender').val();
                    }
                },
                "columns": [
                    {data: 'username', searchable: true},
                    {data: 'email', searchable: true},
                    {data: 'phone', searchable: true},
                    {data: 'gender', searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                
    
            });
    

            $(document).on('click', '.empDelete', function(e) {
                var employee_id = jQuery.trim(jQuery(this).attr('data-id'));
                var mssg = "Are you sure you want to delete this record?";
                var base_url = "{{ url('') }}";
                var token = "{{ csrf_token() }}"
                bootbox.confirm({
                    message: mssg,
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-primary'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function(result) {
                        if (result == true) {
                            var token = jQuery("input[name='_token']").val();
                            $.ajax({
                                url: base_url + "/employees/delete",
                                type: 'POST',
                                data: {
                                    '_token': token,
                                    'id': employee_id
                                },
                                dataType: "JSON",
                                success: function(response) {
                                    if (response.title == 'Error') {
                                        toastr.error(response.message, response
                                            .title);
                                    } else {
                                        toastr.success(response.message, response
                                            .title);
                                        table.draw();
                                    }
                                }
                            });
                        }
                    }
                });
            });

            $('#gender').on('change', function() {
                table.draw();
            });
    
        });

        

        
    </script>
@endsection