<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMenuItemRequest;
use App\Http\Requests\Admin\UpdateMenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function index(): View
    {
        $query = MenuItem::query();

        // Search filter
        if (request('search')) {
            $search = request('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        // Category filter
        if (request('category')) {
            $query->where('category', request('category'));
        }

        // Availability filter
        if (request('availability') !== null && request('availability') !== '') {
            $query->where('is_available', request('availability'));
        }

        $menuItems = $query->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $categories = MenuItem::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin.menu-items.index', [
            'menuItems' => $menuItems,
            'categories' => $categories,
        ]);
    }

    public function store(StoreMenuItemRequest $request): RedirectResponse
    {
        MenuItem::create($request->validated());

        return back()->with('status', 'Menu item added successfully.');
    }

    public function edit(MenuItem $menuItem): View
    {
        return view('admin.menu-items.edit', [
            'menuItem' => $menuItem,
            'categories' => MenuItem::query()
                ->select('category')
                ->distinct()
                ->orderBy('category')
                ->pluck('category'),
        ]);
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem): RedirectResponse
    {
        $menuItem->update($request->validated());

        return redirect()->route('admin.menu-items.index')->with('status', 'Menu item updated successfully.');
    }

    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        $menuItem->delete();

        return redirect()->route('admin.menu-items.index')->with('status', 'Menu item deleted successfully.');
    }
}
