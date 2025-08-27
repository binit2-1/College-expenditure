<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UtilisationCertificate;
use App\Models\Expenditure;

class UtilisationCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certificates = UtilisationCertificate::with('expenditures')->latest()->get();
        return view('uc.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expenditures = Expenditure::all();
        return view('uc.create', compact('expenditures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'expenditures' => 'required|array|min:1',
            'expenditures.*' => 'exists:expenditures,id'
        ]);

        $certificate = UtilisationCertificate::create([
            'title' => $validated['title'],
            'description' => $validated['description']
        ]);

        $certificate->expenditures()->attach($validated['expenditures']);

        return redirect()->route('uc.index')
            ->with('success', 'UC generated successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(UtilisationCertificate $uc)
    {
        $uc->load('expenditures');
        return view('uc.show', compact('uc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UtilisationCertificate $uc)
    {
        $expenditures = Expenditure::all();
        $uc->load('expenditures');
        return view('uc.edit', compact('uc', 'expenditures'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UtilisationCertificate $uc)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'expenditures' => 'required|array|min:1',
            'expenditures.*' => 'exists:expenditures,id'
        ]);

        $uc->update([
            'title' => $validated['title'],
            'description' => $validated['description']
        ]);

        $uc->expenditures()->sync($validated['expenditures']);

        return redirect()->route('uc.index')
            ->with('success', 'UC updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UtilisationCertificate $uc)
    {
        $uc->delete();

        return redirect()->route('uc.index')
            ->with('success', 'UC deleted successfully!');
    }
}
