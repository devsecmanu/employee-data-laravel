<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use DataTables;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

	    	$data = Employee::orderBy('username', 'ASC');

            if(!empty($request->gender)){
                $data = $data->where('gender','=', $request->gender);
                \Log::info($request->gender);
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $id = encrypt($row->employee_id);

                    $trash_bin = '';
                    if($row->deleted_at == null){

                        $trash_bin = "<a href='javascript:void(0);' class='btn btn-sm btn-dark btn-text-primary btn-icon empDelete' data-toggle='tooltip' data-placement='top' title='Delete' data-id='$row->employee_id'><i class='fas fa-trash'></i></a>";
                        
                    }
                   
                    $btn ="<div class='demo-inline-spacing'>
                    <a href='employees/edit/$id' class='btn btn-sm btn-dark btn-text-primary btn-icon' data-toggle='tooltip' data-placement='top' title='Edit'><i class='fas fa-edit'></i></a>
                    $trash_bin
                    </div>";      
                        
                    return $btn;                         
                })
                
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('employees.index');
    }

    public function add()
    {
        return view('employees.add');
    }

    public function save(Request $request)
    {
        try {
            $input = $request->all();
            $checkEmail = Employee::where('email',$input['email'])->get();
            
            if($checkEmail->isEmpty()) {
                $insert = Employee::create($input);
                if (isset($insert)) {
                    toastr()->success('Employee created successfully');
                    return redirect('/');
                }
            }else{
                toastr()->error('Email already in use.');           
                return redirect('employees/add')->withInput($request->input());
            }
        }catch(\Exception $e){
            toastr()->error('Something went wrong.');
            return redirect('employees/add')->withInput($request->input());
        }
    }

    public function edit($id)
    {
        try {
            $id = decrypt($id);
        }catch (\Exception $e){
            toastr()->error('Something went wrong.');
            return redirect('/');
        }  

        $employee = Employee::where('employee_id', $id)->first();
        if(!$employee){
            toastr()->error('Employee does not exist');
            return redirect('/');
        }
        return view('employees.edit',compact('employee'));
    }

    public function update(Request $request)
    {
        try{
            $input =  $request->except('_token');
            $input = array_filter($input);

            $search['employee_id'] = $input['employee_id'];

            $checkExist = Employee::where([['email','=',$input['email']],['employee_id','!=',$input['employee_id']]])->get();

            if( $checkExist->isNotEmpty() ) {
                toastr()->error('Email already exists.');
                return redirect()->back()->withInput($request->input());
            }

            
            $user = Employee::updateOrCreate($search,$input);
            toastr()->success('Employee was successfully updated.');
            return redirect('/');
                
        }catch(\Exception $e){
            toastr()->error('Something went wrong');
            return redirect()->back();
        }
        
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;

            if($id){
                $employee = Employee::where('employee_id', $id)->first();
                
                if($employee){
                    $employee->delete();
                    return ['title' => 'Success', 'message' => 'Record deleted successfully'];
                }
            }
            return ['title' => 'Error', 'message' => 'Something went wrong'];
        } catch (\Exception $e) {
            return ['title' => 'Error', 'message' => 'Something went wrong'];
        }
    }
}
