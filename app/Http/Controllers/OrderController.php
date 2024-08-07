<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data=Order::query()->with(['customer','products'])->latest('id')->get();
        // dd($data-> toArray());
        return view('products.index',compact('data'));
    
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("products.create");


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $images = [];

        try {
            DB::transaction(function () use ($request, &$images) {
                $customer = Customer::create($request->customer);
                $supplier = Supplier::create($request->supplier);

                $orderDetails = [];
                $totalAmount = 0;
                foreach ($request->products as $key => $product) {
                    $product['supplier_id'] = $supplier->id;

                    if ($request->hasFile("products.$key.image")) {
                        $images[] = $product['image'] = Storage::put('products', $request->file("products.$key.image"));
                    }

                    $tmp = Product::query()->create($product);

                    $orderDetails[$tmp->id] = [
                        'quantity' => $request->order_details[$key]['quantity'],
                        'price' => $tmp->price
                    ];

                    $totalAmount += $request->order_details[$key]['quantity'] * $tmp->price;
                }

                $order = Order::query()->create([
                    'customer_id' => $customer->id,
                    'total_amount' => $totalAmount,
                ]);

                $order->details()->attach($orderDetails);
            }, 3);

            return redirect()
                ->route('orders.index')
                ->with('success', 'Thao tác thành công!');
        } catch (Exception $exception) {

            foreach ($images as $image) {
                if (Storage::exists($image)) {
                    Storage::delete($image);
                }
            }

            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'products']);

        return view('products.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load(['customer', 'products']);

        return view('products.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
       
        try {
            DB::transaction(function () use ($order, $request) {

                
                $order->details()->sync($request->order_details);

                $orderDetail = array_map(function($item) {
                    return $item['price'] * $item['quantity'];
                }, $request->order_details);

                $totalAmount = array_sum($orderDetail);

                $order->update([
                    'total_amount' => $totalAmount
                ]);
            }, 3);

            return back()->with('success', 'Thao tác thành công!');
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            DB::transaction(function () use ($order) {
                $order->products()->sync([]);

                $order->delete();
            }, 3);

            return back()->with('success', 'Thao tác thành công!');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}

