<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the user's products.
     */
    public function index()
    {
        $products = Product::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'category' => ['required', 'in:cleanser,toner,serum,moisturizer,sunscreen,treatment,other'],
            'time_of_use' => ['required', 'in:pagi,malam,keduanya'],
            'purchase_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:purchase_date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['user_id'] = Auth::id();

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $this->authorizeProduct($product);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'category' => ['required', 'in:cleanser,toner,serum,moisturizer,sunscreen,treatment,other'],
            'time_of_use' => ['required', 'in:pagi,malam,keduanya'],
            'purchase_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:purchase_date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Make sure the logged-in user owns this product.
     */
    private function authorizeProduct(Product $product): void
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke produk ini.');
        }
    }
}
