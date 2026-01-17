<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::orderBy('name')->paginate(10);

        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('admin.organizations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
        ]);

        Organization::create($request->only('name','type'));

        return redirect()
            ->route('admin.organizations.index')
            ->with('success', 'Organisasi berhasil ditambahkan.');
    }

    public function edit(Organization $organization)
    {
        return view('admin.organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
        ]);

        $organization->update($request->only('name','type'));

        return redirect()
            ->route('admin.organizations.index')
            ->with('success', 'Organisasi berhasil diperbarui.');
    }

    public function destroy(Organization $organization)
    {
        if ($organization->users()->count() > 0) {
            return back()->withErrors('Organisasi masih memiliki user.');
        }

        $organization->delete();

        return redirect()
            ->route('admin.organizations.index')
            ->with('success', 'Organisasi berhasil dihapus.');
    }
}
