<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function __invoke(): View
    {
        $menuItems = MenuItem::query()
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $menus = $menuItems->map(fn (MenuItem $menuItem): array => [
            'name' => $menuItem->name,
            'category' => $menuItem->category,
            'price' => '&#8369;'.number_format((float) $menuItem->price, 2),
            'rating' => '4.8',
            'tag' => 'Available',
            'description' => $menuItem->description ?: 'Freshly prepared and ready for pickup or delivery.',
            'image' => $menuItem->image_url ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1200&auto=format&fit=crop',
        ]);

        $categories = $menuItems
            ->pluck('category')
            ->unique()
            ->prepend('All')
            ->values()
            ->all();

        return view('customer.menu', [
            'menus' => $menus,
            'categories' => $categories,
        ]);
    }
}
