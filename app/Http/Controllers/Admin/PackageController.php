<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\AuthorizesBusiness;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    use AuthorizesBusiness;
    public function index()
    {
        $businessId = Auth::user()->business_id;
        $packages = Package::where('business_id', $businessId)
            ->with('services')
            ->orderBy('sort_order')
            ->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $businessId = Auth::user()->business_id;
        $services = Service::where('business_id', $businessId)->where('is_active', true)->get();
        return view('admin.packages.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer',
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id',
        ]);

        $package = Package::create([
            'business_id' => Auth::user()->business_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        $package->services()->sync($request->service_ids);

        return redirect()->route('admin.packages.index')
            ->with('success', __('Package created successfully.'));
    }

    public function show(Package $package)
    {
        $this->authorizeBusiness($package);
        return redirect()->route('admin.packages.edit', $package);
    }

    public function edit(Package $package)
    {
        $this->authorizeBusiness($package);
        $businessId = Auth::user()->business_id;
        $services = Service::where('business_id', $businessId)->where('is_active', true)->get();
        $package->load('services');
        return view('admin.packages.edit', compact('package', 'services'));
    }

    public function update(Request $request, Package $package)
    {
        $this->authorizeBusiness($package);

        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
            'service_ids' => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id',
        ]);

        $package->update($request->only([
            'name_ar', 'name_en', 'description_ar', 'description_en',
            'price', 'original_price', 'is_active', 'sort_order',
        ]));
        $package->services()->sync($request->service_ids);

        return redirect()->route('admin.packages.index')
            ->with('success', __('Package updated successfully.'));
    }

    public function destroy(Package $package)
    {
        $this->authorizeBusiness($package);
        $package->services()->detach();
        $package->delete();
        return redirect()->route('admin.packages.index')
            ->with('success', __('Package deleted successfully.'));
    }

}
