<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateMenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function index(): View
    {
        $query = MenuItem::query();

        if (request('search')) {
            $search = request('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        if (request('category')) {
            $query->where('category', request('category'));
        }

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

        return view('manager.menu-items.index', [
            'menuItems'  => $menuItems,
            'categories' => $categories,
        ]);
    }

    public function edit(MenuItem $menuItem): View
    {
        return view('manager.menu-items.edit', [
            'menuItem'   => $menuItem,
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

        return redirect()->route('manager.menu-items.index')->with('status', 'Menu item updated successfully.');
    }
}
