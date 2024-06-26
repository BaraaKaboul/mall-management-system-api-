<?php

namespace App\Http\Controllers;

use App\Models\Mall;
use App\Models\Manager;
use App\Traits\ImagesTrait;
use App\Traits\responseJsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    use responseJsonTrait;
    use ImagesTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $manager_data = Manager::all();
            if (!$manager_data){
                return $this->fail('there is no data received',202);
            }
            return $this->fetchData('your data has been fetched',200,'data',$manager_data);
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
                $image = $this->uploadFile($request, 'manager');
            }
            if (isset($image)){
                Manager::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'photo' => $image,
                ]);
            }
            else
                Manager::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone,
                    'address' => $request->address,
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
    public function show(string $id)
    {
        try {
            $manager_data = Manager::with('mall')->find($id);
            if (!isset($manager_data))
            {
                return $this->fail('there is no data received',202);
            }
            return $this->fetchData('your data has been fetched for one user',200,'data',$manager_data);
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
    public function update(Request $request, string $id)
    {
        try {
            $manager = Manager::find($id);
            if (!$manager) {
                return $this->fail('Manager not found', 404);
            }

            if ($request->hasFile('photo')) {
                $imagePath = $manager->photo;
                if ($imagePath) {
                    Storage::delete($imagePath);
                }
                $image = $this->uploadFile($request, 'manager');
                $manager->photo = $image;
            }

            $manager->name = $request->name;
            $manager->email = $request->email;
            $manager->phone = $request->phone;
            $manager->address = $request->address;

            if ($request->has('password')) {
                $manager->password = Hash::make($request->password);
            }

            $manager->save();

            return $this->success('Manager updated successfully', 200);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $manager = Manager::find($id);
            if (Mall::where('manager_id','=',$id)->exists())
            {
                return $this->fail("Can't delete Manager because it's related with another table, please delete related data first", 202);
            }
            if (!$manager)
            {
                return $this->fail('Manager not found', 404);
            }
            $manager->destroy($id);

            return $this->success('Manager has been deleted successfully', 200);

        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }

    }
}
