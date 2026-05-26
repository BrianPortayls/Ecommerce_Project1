<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function __invoke(Request $request): View
    {
        $requestedCategory = $request->string('category')->toString();

        return view('customer.menu', [
            'selectedCategory' => $requestedCategory ?: 'All',
        ]);
    }
}
