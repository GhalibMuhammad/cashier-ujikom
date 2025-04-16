<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\DetailSales;
use App\Models\Products;
use App\Models\Saless;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $saless = Saless::with('customer', 'user', 'detailSales')->orderBy('id','desc')->get();
        return view('pembelian.sales-list', compact('saless'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Products::all();
        return view('pembelian.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->has('shop')) {
            return back()->with('error', 'Pilih produk terlebih dahulu!');
        }

        // Hapus data sebelumnya agar tidak terjadi duplikasi
        session()->forget('shop');

        $selectedProducts = $request->shop;

        // Pastikan data dikirim dalam bentuk array
        if (!is_array($selectedProducts)) {
            return back()->with('error', 'Format data tidak valid!');
        }

        // Simpan hanya produk yang memiliki jumlah lebih dari 0, hapus duplikasi
        $filteredProducts = collect($selectedProducts)
            ->mapWithKeys(function ($item) {
                $parts = explode(';', $item);
                if (count($parts) > 3) {
                    $id = $parts[0];
                    return [$id => $item]; // Pastikan hanya 1 produk per ID
                }
                return [];
            })
            ->values()
            ->toArray();

        // Simpan ke sesi
        session(['shop' => $filteredProducts]);

        return redirect()->route('sales.post');
    }


    public function post()
    {
        $shop = session('shop', []);
        return view('pembelian.detail', compact('shop'));
    }

    public function createsales(Request $request)
    {
        $request->validate([
            'total_pay' => 'required',
        ], [
            'total_pay.required' => 'Berapa jumlah uang yang dibayarkan?',
        ]);

        $newPrice = (int) preg_replace('/\D/', '', $request->total_price);
        $newPay = (int) preg_replace('/\D/', '', $request->total_pay);
        $newreturn = $newPay - $newPrice;

        if ($request->member === 'Member') {
            // Mengecek apakah customer sudah pernah melakukan pembelian sebelumnya
            $existCustomer = Customers::where('no_hp', $request->no_hp)->first();
            // Akumulasi Point
            $point = floor($newPrice / 100);
            if ($existCustomer) {
                // Jika customer sebelumnya sudah ada, maka update point
                $existCustomer->update([
                    'point' => $existCustomer->point + $point,
                ]);
                // Ambil ID customer
                $customer_id = $existCustomer->id;
            } else {
                // Jika customer baru, maka create customer baru
                $existCustomer = Customers::create([
                    'name' => "",
                    'no_hp' => $request->no_hp,
                    'point' => $point,
                ]);
                // Ambil ID customer baru
                $customer_id = $existCustomer->id;
            }
            // Membuat data penjualan
            $sales = Saless::create([
                'sale_date' => Carbon::now()->format('Y-m-d'),
                'total_price' => $newPrice,
                'total_pay' => $newPay,
                'total_return' => $newreturn,
                'customer_id' => $customer_id,
                'user_id' => Auth::id(),
                'point' => floor($newPrice / 100),
                'total_point' => 0,
            ]);
            $detailSalesData = [];

            foreach ($request->shop as $shopItem) {
                $item = explode(';', $shopItem);
                $productId = (int) $item[0];
                $amount = (int) $item[3];
                $subtotal = (int) $item[4];

                $detailSalesData[] = [
                    'sale_id' => $sales->id,
                    'product_id' => $productId,
                    'amount' => $amount,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                // //menyebabkan duplikasi data
                // DetailSales::insert($detailSalesData);

                // Update stok produk di database
                $product = Products::find($productId);
                if ($product) {
                    $newStock = $product->stock - $amount;
                    if ($newStock < 0) {
                        return redirect()->back()->withErrors(['error' => 'Stok tidak mencukupi untuk produk ' . $product->name]);
                    }
                    $product->update(['stock' => $newStock]);
                }
            }
            DetailSales::insert($detailSalesData);
            return redirect()->route('sales.create.member', ['id' => Saless::latest()->first()->id])
                ->with('message', 'Silahkan daftar sebagai member');
        } else {
            $sales = Saless::create([
                'sale_date' => Carbon::now()->format('Y-m-d'),
                'total_price' => $newPrice,
                'total_pay' => $newPay,
                'total_return' => $newreturn,
                'customer_id' => $request->customer_id,
                'user_id' => Auth::id(),
                'point' => 0,
                'total_point' => 0,
            ]);

            $detailSalesData = [];

            foreach ($request->shop as $shopItem) {
                $item = explode(';', $shopItem);
                $productId = (int) $item[0];
                $amount = (int) $item[3];
                $subtotal = (int) $item[4];

                $detailSalesData[] = [
                    'sale_id' => $sales->id,
                    'product_id' => $productId,
                    'amount' => $amount,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];


                // Update stok produk di database
                $product = Products::find($productId);
                if ($product) {
                    $newStock = $product->stock - $amount;
                    if ($newStock < 0) {
                        return redirect()->back()->withErrors(['error' => 'Stok tidak mencukupi untuk produk ' . $product->name]);
                    }
                    $product->update(['stock' => $newStock]);
                }
            }
            DetailSales::insert($detailSalesData);
            return redirect()->route('sales.print.show', ['id' => $sales->id])->with('Silahkan Print');
        }

    }


    /**
     * Display the specified resource.
     */
    public function createmember($id)
    {
        $sale = Saless::with('DetailSales.product')->findOrFail($id);
        // Menentukan apakah customer sudah pernah melakukan pembelian sebelumnya
        $notFirst = Saless::where('customer_id', $sale->customer->id)->count() != 1 ? true : false;
        return view('pembelian.view-member', compact('sale','notFirst'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Saless $saless)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Saless $saless)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saless $saless)
    {
        //
    }
}
