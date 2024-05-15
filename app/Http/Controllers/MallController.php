<?php

namespace App\Http\Controllers;

use App\Models\Mall;
use App\Models\Manager;
use App\Traits\ImagesTrait;
use App\Traits\responseJsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MallController extends Controller
{
    use responseJsonTrait;
    use ImagesTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $mall_data = Mall::all();
            if (!$mall_data){
                return $this->fail('there is no data received',202);
            }
            return $this->fetchData('your data has been fetched',200,'data',$mall_data);
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
            if ($request->hasFile('photo'))
            {
                $image = $this->uploadFile($request, 'malls');
            }
            if (isset($image)){
                Mall::create([
                    'manager_id' => $request->manager_id,
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'space' => $request->space,
                    'note' => $request->note,
                    'photo' => $image,
                ]);
            }
            else
                Mall::create([
                    'manager_id' => $request->name,
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'space' => $request->space,
                    'note' => $request->note,
                    'photo' => null,
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
    public function show(string $mall_id)
    {
        try {

            $mall = Mall::with('manager')->find($mall_id);

            if ($mall) {

                $manager_data = Mall::with('manager')->find($mall);

                if ($manager_data->isNotEmpty()) {
                    return $this->fetchData('your data has been fetched', 200, 'data', $manager_data);

                } else {
                    return $this->fail('there is no data received', 202);
                }

            } else {
                return $this->fail('Mall not found', 404);
            }

        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
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
    public function update(Request $request, string $mall_id)
    {
        try {
            $mall = Mall::find($mall_id);
            if (!$mall) {
                return $this->fail('Mall not found', 404);
            }

            if ($request->hasFile('photo')) {
                $imagePath = $mall->photo;
                if ($imagePath) {
                    Storage::delete($imagePath);
                }
                $image = $this->uploadFile($request, 'manager');
                $mall->photo = $image;
            }

            $mall->name = $request->name;
            $mall->space = $request->space;
            $mall->phone = $request->phone;
            $mall->address = $request->address;
            $mall->note = $request->note;

            $mall->save();

            return $this->success('Mall updated successfully', 200);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $mall_id)
    {
        try {
            $mall = Mall::find($mall_id);
            if (!$mall)
            {
                return $this->fail('Mall not found', 404);
            }
            $mall->destroy($mall_id);

            return $this->success('Mall has been deleted successfully', 200);

        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }
}
