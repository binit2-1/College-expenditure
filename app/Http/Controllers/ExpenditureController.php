<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenditure;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            // Admin sees all HoD-approved expenditures for final approval
            $expenditures = Expenditure::with(['submittedBy', 'hodApprovedBy', 'adminApprovedBy'])
                ->whereIn('status', ['hod_approved', 'admin_approved', 'admin_rejected', 'final_approved'])
                ->latest()->get();
        } elseif ($user->isHoD()) {
            // HoD sees pending expenditures from their department for first-level approval
            $expenditures = Expenditure::with(['submittedBy', 'hodApprovedBy'])
                ->whereHas('submittedBy', function($query) use ($user) {
                    $query->where('department', $user->department);
                })
                ->whereIn('status', ['pending', 'hod_approved', 'hod_rejected'])
                ->latest()->get();
        } else {
            // Faculty sees only their own expenditures
            $expenditures = Expenditure::with(['hodApprovedBy', 'adminApprovedBy'])
                ->where('submitted_by', $user->id)
                ->latest()->get();
        }
        
        return view('expenditures.index', compact('expenditures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenditures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        // Handle file upload
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }

        Expenditure::create([
            'item_name' => $validated['item_name'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'receipt_path' => $receiptPath,
            'submitted_by' => auth()->id(),
            'status' => 'pending'
        ]);

        return redirect()->route('expenditures.index')
            ->with('success', 'Expenditure submitted for approval!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expenditure $expenditure)
    {
        return view('expenditures.show', compact('expenditure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expenditure $expenditure)
    {
        return view('expenditures.edit', compact('expenditure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expenditure $expenditure)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category' => 'required|string|max:100'
        ]);

        $expenditure->update($validated);

        return redirect()->route('expenditures.index')
            ->with('success', 'Expenditure updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenditure $expenditure)
    {
        // Only allow deletion of pending expenditures by the submitter or admin
        if ($expenditure->status !== 'pending' && !auth()->user()->isAdmin()) {
            return redirect()->route('expenditures.index')
                ->with('error', 'Cannot delete approved expenditures.');
        }

        if ($expenditure->submitted_by !== auth()->id() && !auth()->user()->isAdmin()) {
            return redirect()->route('expenditures.index')
                ->with('error', 'You can only delete your own expenditures.');
        }

        $expenditure->delete();

        return redirect()->route('expenditures.index')
            ->with('success', 'Expenditure deleted successfully!');
    }

    /**
     * Approve an expenditure (Multi-level approval)
     */
    public function approve(Request $request, Expenditure $expenditure)
    {
        $request->validate([
            'approval_notes' => 'nullable|string|max:1000'
        ]);

        $user = auth()->user();
        
        if ($user->isHoD() && $expenditure->isPending()) {
            // HoD first-level approval
            $expenditure->update([
                'status' => 'hod_approved',
                'hod_approved_by' => $user->id,
                'hod_approved_at' => now(),
                'hod_remarks' => $request->approval_notes
            ]);
            
            session()->flash('success', 'Expenditure approved at HoD level. Forwarded to Admin for final approval.');
        } 
        elseif ($user->isAdmin() && $expenditure->isHoDApproved()) {
            // Admin final approval
            $expenditure->update([
                'status' => 'final_approved',
                'admin_approved_by' => $user->id,
                'admin_approved_at' => now(),
                'admin_remarks' => $request->approval_notes
            ]);
            
            session()->flash('success', 'Expenditure given final approval. Ready for UC generation.');
        }
        else {
            session()->flash('error', 'You are not authorized to approve this expenditure at this stage.');
        }

        return redirect()->route('expenditures.index');
    }

    /**
     * Reject an expenditure (Multi-level approval)
     */
    public function reject(Request $request, Expenditure $expenditure)
    {
        $request->validate([
            'approval_notes' => 'required|string|max:1000'
        ]);

        $user = auth()->user();
        
        if ($user->isHoD() && $expenditure->isPending()) {
            // HoD rejection
            $expenditure->update([
                'status' => 'hod_rejected',
                'hod_approved_by' => $user->id,
                'hod_approved_at' => now(),
                'hod_remarks' => $request->approval_notes
            ]);
            
            session()->flash('warning', 'Expenditure rejected at HoD level.');
        } 
        elseif ($user->isAdmin() && $expenditure->isHoDApproved()) {
            // Admin rejection
            $expenditure->update([
                'status' => 'admin_rejected',
                'admin_approved_by' => $user->id,
                'admin_approved_at' => now(),
                'admin_remarks' => $request->approval_notes
            ]);
            
            session()->flash('warning', 'Expenditure rejected at Admin level.');
        }
        else {
            session()->flash('error', 'You are not authorized to reject this expenditure at this stage.');
        }

        return redirect()->route('expenditures.index');
    }
}
