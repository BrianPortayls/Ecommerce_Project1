<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function index(): View
    {
        return view('admin.menu-items.index', [
            'menuItems' => MenuItem::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
            'categories' => MenuItem::query()
                ->select('category')
                ->distinct()
                ->orderBy('category')
                ->pluck('category'),
        ]);
    }

    public function store(StoreMenuItemRequest $request): RedirectResponse
    {
        MenuItem::create($request->validated());

        return back()->with('status', 'Menu item added successfully.');
    }
}
