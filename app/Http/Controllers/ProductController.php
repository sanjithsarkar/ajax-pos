<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\Product;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $posItems = Pos::all();

        // dd($products);
        return view('pos')->with('products', $products)->with('posItems', $posItems);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // 
    }

    public function deletePos($id){
        
        // // Find the product by ID
        $product = Pos::where('id', $id)->first();

        // Check if the product exists
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'product deleted Successfully!!']);

    }

    public function insertPos(Request $request)
    {

        $productId = $request->get('pro_id');
        $isExit = Pos::where('pro_id', $productId)->first();
        $product = Product::where('id', $productId)->first();

//        dd($product);
        if (!$isExit) {
            if ($product->quantity >= 1) {
                $productInsert = Pos::insert([
                    'pro_id' => $productId,
                    'name' => $request->name,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                    'sub_total' => $request->sub_total,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json(['success' => 'Inserted Successfully!!']);
            } else {
                return response()->json(['error' => 'The product is stock out!!']);
            }
        } elseif ($product->quantity > $isExit->quantity) {
            $increaseQuantity = Pos::where('pro_id', $productId)->increment('quantity');

            $posData = Pos::where('pro_id', $productId)->first();
            $sub_total = $posData->quantity * $posData->price;
            Pos::where('pro_id', $productId)->update(['sub_total' => $sub_total]);

            return response()->json(['success' => 'Increment This Product!!']);
        } else {
            return response()->json(['error' => 'The product is stock out!!']);
        }
    }


    public function increaseQuantity($id)
    {
        $product_increment = Pos::where('id', $id)->increment('quantity');

        $posData = Pos::where('id', $id)->first();
        $sub_total = $posData->quantity * $posData->price;
        Pos::where('id', $id)->update(['sub_total' => $sub_total]);
    }


    public function decreaseQuantity($id)
    {
        $product_decrement = Pos::where('id', $id)->decrement('quantity');

        $posData = Pos::where('id', $id)->first();
        $sub_total = $posData->quantity * $posData->price;
        Pos::Where('id', $id)->update(['sub_total' => $sub_total]);
    }

    public function getAllPos()
    {
        $posItems = Pos::all();

        return response()->json($posItems);
    }


    public function totalQuantity()
    {
        // Retrieve all POS items from the database
        $posItems = Pos::all();

        // Initialize the total quantity
        $totalQuantity = 0;

        // Loop through each POS item and add its quantity to the total
        foreach ($posItems as $posItem) {
            $totalQuantity += (float)$posItem->quantity;
        }

        return $totalQuantity;
    }

}
