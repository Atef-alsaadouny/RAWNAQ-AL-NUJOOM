<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\AuthorizesBusiness;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    use AuthorizesBusiness;

    public function index()
    {
        $businessId = Auth::user()->business_id;
        $customers = User::where('business_id', $businessId)
            ->where('role', 'customer')
            ->withCount('appointments')
            ->orderBy('created_at', 'desc')
            ->paginate(20)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $this->authorizeBusiness($customer);
        $customer->load(['appointments' => function ($q) {
            $q->latest()->take(50);
        }]);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
        $this->authorizeBusiness($customer);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        $this->authorizeBusiness($customer);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{Arabic}a-zA-Z0-9\s\-]+$/u'],
            'email' => 'nullable|email|unique:users,email,' . $customer->id,
            'password' => 'nullable|string|min:8',
        ]);

        $customer->update($request->only(['name', 'email']));

        if ($request->filled('password')) {
            $customer->password = Hash::make($request->password);
            $customer->save();
        }

        return redirect()->route('admin.customers.index')
            ->with('success', __('Customer updated successfully.'));
    }

    public function destroy(User $customer)
    {
        $this->authorizeBusiness($customer);
        $customer->delete();
        return redirect()->route('admin.customers.index')
            ->with('success', __('Customer deleted successfully.'));
    }
}
