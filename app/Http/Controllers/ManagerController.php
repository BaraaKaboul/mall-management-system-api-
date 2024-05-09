<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Traits\ImagesTrait;
use App\Traits\responseJsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    use responseJsonTrait;
    use ImagesTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'hello its me you looking for';
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
            $manager_file = ''; // مشان اقدر اخزن الصورة لازم اعرف المتغير بالاول هون بهالشكل
            if ($request->hasFile('photo'))
            {
                $manager_file = $this->uploadFile($request->photo, 'manager');
            }
            Manager::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'photo' => $manager_file,
            ]);

            return $this->success('data has been submitted sucssessfully', 200);

        }
        catch (\Exception $e){
            return $this->fail($e->getMessage(), 501);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
