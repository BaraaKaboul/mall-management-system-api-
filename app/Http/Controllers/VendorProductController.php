<?php

namespace App\Http\Controllers;

use App\Traits\ImagesTrait;
use App\Traits\responseJsonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorProductController extends Controller
{
    use ImagesTrait;
    use responseJsonTrait;
    public function store(Request $request)
    {
        try {
            DB::table('vendors_products')->insert([
                'vendor_id'=>$request->vendor_id,
                'product_id'=>$request->product_id,
                'price'=>$request->price,
                'note'=>$request->note,
            ]);

            return $this->success('data has been submitted successfully', 201);

        }
        catch (\Exception $e){
            return $this->fail($e->getMessage(), 400);
        }
    }
}
