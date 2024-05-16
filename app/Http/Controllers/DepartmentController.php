<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Traits\responseJsonTrait;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class DepartmentController extends Controller
{
    use responseJsonTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $department_data = Department::all();
            if (!$department_data){
                return $this->fail('there is no data received',202);
            }
            return $this->fetchData('your data has been fetched',200,'data',$department_data);
        }
        catch (\Exception $e){
            return $this->fail($e->getMessage(),400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Department::create([
                'name' => $request->name,
                'mall_id' => $request->mall_id,
                'description' => $request->description,
                'note' => $request->note,
            ]);

            return $this->success('data has been submitted successfully', 201);

        }
        catch (\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $department_data = Department::with(['mall'=>function($q) //طريقة مشان اقدر احدد الحقول لبدي جيبها معي
            {
                $q->select('id','manager_id','name');
            }])->find($id);
            if (!isset($department_data))
            {
                return $this->fail('there is no data received',202);
            }
            return $this->fetchData('your data has been fetched for one user',200,'data',$department_data);
        }
        catch (\Exception $e){
            return $this->fail($e->getMessage(),400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $department_id)
    {
        try {
            Department::findOrFail($department_id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'note' => $request->note,
            ]);

            return $this->success('data has been updated successfully', 201);

        }
        catch (\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $department_id)
    {
        try {
            $department = Department::find($department_id);

            if (!$department)
            {
                return $this->fail('Department not found', 404);
            }
            $department->destroy($department_id);

            return $this->success('Department has been deleted successfully', 200);

        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }
}
