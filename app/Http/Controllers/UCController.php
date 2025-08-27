<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UCController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin'); // Only admins can generate UC
    }

    /**
     * Display UC generation form
     */
    public function index()
    {
        // Get all final approved expenditures
        $finalApprovedExpenditures = Expenditure::with(['submittedBy', 'hodApprovedBy', 'adminApprovedBy'])
            ->where('status', 'final_approved')
            ->latest()
            ->get();

        $totalAmount = $finalApprovedExpenditures->sum('amount');
        $totalItems = $finalApprovedExpenditures->count();

        return view('uc.index', compact('finalApprovedExpenditures', 'totalAmount', 'totalItems'));
    }

    /**
     * Show the form for creating a new UC
     */
    public function create()
    {
        // Get all final approved expenditures
        $expenditures = Expenditure::with(['submittedBy', 'hodApprovedBy', 'adminApprovedBy'])
            ->where('status', 'final_approved')
            ->latest()
            ->get();

        return view('uc.create', compact('expenditures'));
    }

    /**
     * Generate UC for selected expenditures
     */
    public function generate(Request $request)
    {
        $request->validate([
            'expenditure_ids' => 'required|array|min:1',
            'expenditure_ids.*' => 'exists:expenditures,id',
            'uc_period_from' => 'required|date',
            'uc_period_to' => 'required|date|after_or_equal:uc_period_from',
            'grant_details' => 'required|string|max:500',
            'purpose' => 'required|string|max:1000'
        ]);

        // Get selected expenditures (ensure they are final approved)
        $expenditures = Expenditure::with(['submittedBy', 'hodApprovedBy', 'adminApprovedBy'])
            ->whereIn('id', $request->expenditure_ids)
            ->where('status', 'final_approved')
            ->get();

        if ($expenditures->isEmpty()) {
            return redirect()->back()->with('error', 'No valid expenditures selected for UC generation.');
        }

        $ucData = [
            'expenditures' => $expenditures,
            'total_amount' => $expenditures->sum('amount'),
            'uc_period_from' => Carbon::parse($request->uc_period_from),
            'uc_period_to' => Carbon::parse($request->uc_period_to),
            'grant_details' => $request->grant_details,
            'purpose' => $request->purpose,
            'generated_by' => auth()->user(),
            'generated_at' => now(),
            'uc_number' => 'UC-' . now()->format('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT)
        ];

        return view('uc.certificate', $ucData);
    }

    /**
     * Download UC as PDF (placeholder for future implementation)
     */
    public function downloadPdf(Request $request)
    {
        // This would implement PDF generation using libraries like DomPDF or wkhtmltopdf
        // For now, return a message
        return redirect()->back()->with('info', 'PDF download feature will be implemented soon.');
    }
}
