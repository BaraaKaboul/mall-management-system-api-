<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Traits\ImagesTrait;
use App\Traits\responseJsonTrait;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    use responseJsonTrait;
    use ImagesTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $vendor_data = Vendor::with(['department'=>function($q){
                $q->select('id','mall_id','name','description','note');
            }])->get();
            if (!$vendor_data)
            {
                return $this->fail('there is no data received',202);
            }
            return $this->fetchData('your data has been fetched',200,'data',$vendor_data);
        }
        catch (\Exception $e){
            return $this->fail($e->getMessage(), 400);
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

            Vendor::create([
                'name' => $request->name,
                'department_id' => $request->department_id,
                'phone' => $request->phone,
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
    public function show(string $vendor_id)
    {
        try {
            $vendor_data = Vendor::with(['department'=>function ($q){
                $q->select('id','mall_id','name','description','note');
            }])->find($vendor_id);

            if (!$vendor_data)
            {
                return $this->fail('there is no data received',202);
            }

            return $this->fetchData('your data has been fetched',200,'data',$vendor_data);

        }
        catch (\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $vendor_id)
    {
        try {

            $vendor = Vendor::find($vendor_id);
            if (!$vendor)
            {
                return $this->fail('there is no data received',202);
            }

            Vendor::find($vendor_id)->update([
                'name' => $request->name,
                'department_id' => $request->department_id,
                'phone' => $request->phone,
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
    public function destroy(string $vendor_id)
    {
        try {
            $vendor = Vendor::find($vendor_id);
            if (!$vendor)
            {
                return $this->fail('there is no data received',202);
            }
            $vendor->delete();

            return $this->success('Vendor has been deleted successfully', 200);

        }
        catch (\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }

    }
}
