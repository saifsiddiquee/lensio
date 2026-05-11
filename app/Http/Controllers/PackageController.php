<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageRequest;
use App\Models\AuditLog;
use App\Models\Package;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display a listing of packages.
     */
    public function index(): View
    {
        $packages = Package::latest()->paginate(15);

        return view('packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new package.
     */
    public function create(): View
    {
        return view('packages.create');
    }

    /**
     * Store a newly created package.
     */
    public function store(PackageRequest $request): RedirectResponse
    {
        $package = Package::create($request->validated());

        AuditLog::log(auth()->id(), 'created', 'packages', $package->id);

        return redirect()->route('packages.index')
            ->with('success', 'Package created successfully.');
    }

    /**
     * Display the specified package.
     */
    public function show(Package $package): View
    {
        return view('packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified package.
     */
    public function edit(Package $package): View
    {
        return view('packages.edit', compact('package'));
    }

    /**
     * Update the specified package.
     */
    public function update(PackageRequest $request, Package $package): RedirectResponse
    {
        $package->update($request->validated());

        AuditLog::log(auth()->id(), 'updated', 'packages', $package->id);

        return redirect()->route('packages.index')
            ->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified package.
     */
    public function destroy(Package $package): RedirectResponse
    {
        try {
            $packageId = $package->id;
            $package->delete();
            AuditLog::log(auth()->id(), 'deleted', 'packages', $packageId);

            return redirect()->route('packages.index')
                ->with('success', 'Package deleted successfully.');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('packages.index')
                    ->with('error', 'This package cannot be deleted because it is referenced by existing quotations. Remove those quotations first.');
            }

            return redirect()->route('packages.index')
                ->with('error', 'An unexpected error occurred while deleting the package.');
        }
    }
}
