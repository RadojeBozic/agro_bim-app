<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Prikaz svih proizvoda (ili po kategoriji ako postoji query parametar)
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Ako postoji parametar ?category=ID
        if ($request->has('category')) {
            $categoryId = $request->input('category');

            if (!is_numeric($categoryId)) {
                // Ako ID nije broj – loguj i vrati grešku
                Log::error('Greška: nevalidna kategorija', ['category' => $categoryId]);
                return response()->json(['error' => 'Nevalidna kategorija.'], 400);
            }

            try {
                $query->where('category_id', $categoryId);
            } catch (\Throwable $e) {
                // Loguj sve nepredviđene greške
                Log::error('Greška pri filtriranju proizvoda po kategoriji', [
                    'exception' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'category' => $categoryId
                ]);
                return response()->json(['error' => 'Došlo je do greške.'], 500);
            }
        }

        // Vraćamo listu proizvoda
        return $query->latest()->get();
    }

    /**
     * Prikaz jednog proizvoda
     */
    public function show($id)
    {
        return Product::findOrFail($id);
    }

    /**
     * Čuvanje novog proizvoda
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'category_id' => 'required|exists:product_categories,id',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        return response()->json([
            'message' => 'Proizvod dodat.',
            'product' => $product
        ], 201);
    }

    /**
     * Isticanje proizvoda
     */
    public function feature($id)
    {
        $product = Product::findOrFail($id);
        $product->is_featured = !$product->is_featured;
        $product->save();

        return response()->json([
            'message' => $product->is_featured ? 'Proizvod je istaknut.' : 'Proizvod više nije istaknut.',
            'product' => $product,
        ]);
    }

    /**
     * Ažuriranje proizvoda
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'category_id' => 'required|exists:product_categories,id',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        $product->save();

        return response()->json([
            'message' => 'Proizvod je ažuriran.',
            'product' => $product
        ]);
    }
}
