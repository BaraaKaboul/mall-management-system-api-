<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\ImagesTrait;
use App\Traits\responseJsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use ImagesTrait;
    use responseJsonTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $product_data = Product::with('vendor')->get();
            if (!$product_data){
                return $this->fail('there is no data received',202);
            }
            return $this->fetchData('your data has been fetched',200,'data',$product_data);
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
                $image = $this->uploadFile($request, 'products');
            }
            if (isset($image)){
                Product::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'manufacture_company' => $request->manufacture_company,
                    'photo' => $image,
                ]);
            }
            else
                Product::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'manufacture_company' => $request->manufacture_company,
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
    public function show(string $product_id)
    {
        try {

            $product_data = Product::find($product_id);

            if (!$product_data){
                return $this->fail('there is no data received',202);
            }
            return $this->fetchData('your data has been fetched',200,'data',$product_data);
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
    public function update(Request $request, string $product_id)
    {
        try {
            $product = Product::find($product_id);
            if (!$product) {
                return $this->fail('Product not found', 404);
            }

            if ($request->hasFile('photo')) {
                $imagePath = $product->photo;
                if ($imagePath) {
                    Storage::delete($imagePath);
                }
                $image = $this->uploadFile($request, 'products');
                $product->photo = $image;
            }

            $product->name = $request->name;
            $product->description = $request->description;
            $product->manufacture_company = $request->manufacture_company;

            $product->save();

            return $this->success('Product updated successfully', 200);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product_id)
    {
        try {
            $product = Product::find($product_id);
            if (!$product)
            {
                return $this->fail('there is no data received',202);
            }
            $product->delete();

            return $this->success('Product has been deleted successfully', 200);

        }
        catch (\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }
}
