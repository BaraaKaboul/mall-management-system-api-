<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Traits\Images;
use App\Traits\responseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    use responseJson;
    use Images;
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
            Manager::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'photo' => $request->photo,
            ]);

            return response()->json(['success' => 'Data stored successfully'], 200);

        }
        catch (\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
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
