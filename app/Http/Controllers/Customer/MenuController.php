<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function __invoke(Request $request): View
    {
        $availableMenuItems = MenuItem::query()
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $categories = $availableMenuItems
            ->pluck('category')
            ->unique()
            ->prepend('All')
            ->values()
            ->all();

        $requestedCategory = $request->string('category')->toString();
        $selectedCategory = in_array($requestedCategory, $categories, true) ? $requestedCategory : 'All';

        $menuItems = $availableMenuItems
            ->when($selectedCategory !== 'All', fn ($items) => $items->where('category', $selectedCategory))
            ->values();

        $menus = $menuItems->map(fn (MenuItem $menuItem): array => [
            'name' => $menuItem->name,
            'category' => $menuItem->category,
            'price' => '&#8369;'.number_format((float) $menuItem->price, 2),
            'rating' => '4.8',
            'tag' => 'Available',
            'description' => $menuItem->description ?: 'Freshly prepared and ready for pickup or delivery.',
            'image' => $menuItem->image_url ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1200&auto=format&fit=crop',
        ]);

        return view('customer.menu', [
            'menus' => $menus,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}
