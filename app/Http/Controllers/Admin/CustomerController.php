<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $customers = User::query()
            ->where('role', User::ROLE_CUSTOMER)
            ->withCount('orders')
            ->withSum('orders', 'total_price')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.customers.index', [
            'customers' => $customers,
        ]);
    }

    public function update(UpdateCustomerRequest $request, User $customer): RedirectResponse
    {
        abort_if($customer->role !== User::ROLE_CUSTOMER, 403);

        $customer->update($request->validated());

        return back()->with('status', 'Customer updated successfully.');
    }

    public function destroy(User $customer): RedirectResponse
    {
        abort_if($customer->role !== User::ROLE_CUSTOMER, 403);

        $customer->delete();

        return back()->with('status', 'Customer deleted successfully.');
    }
}
