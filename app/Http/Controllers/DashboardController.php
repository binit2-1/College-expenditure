<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenditure;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get role-specific expenditure data
        if ($user->isAdmin()) {
            // Admin sees all expenditures
            $totalExpenditure = Expenditure::sum('amount');
            $totalExpenditures = Expenditure::count();
            $pendingApprovals = Expenditure::whereIn('status', ['pending', 'hod_approved'])->count();
            $finalApproved = Expenditure::where('status', 'final_approved')->count();
        } elseif ($user->isHoD()) {
            // HoD sees expenditures from their department
            $totalExpenditure = Expenditure::whereHas('submittedBy', function($query) use ($user) {
                $query->where('department', $user->department);
            })->sum('amount');
            $totalExpenditures = Expenditure::whereHas('submittedBy', function($query) use ($user) {
                $query->where('department', $user->department);
            })->count();
            $pendingApprovals = Expenditure::whereHas('submittedBy', function($query) use ($user) {
                $query->where('department', $user->department);
            })->where('status', 'pending')->count();
            $finalApproved = Expenditure::whereHas('submittedBy', function($query) use ($user) {
                $query->where('department', $user->department);
            })->where('status', 'final_approved')->count();
        } else {
            // Faculty sees only their own expenditures
            $totalExpenditure = Expenditure::where('submitted_by', $user->id)->sum('amount');
            $totalExpenditures = Expenditure::where('submitted_by', $user->id)->count();
            $pendingApprovals = Expenditure::where('submitted_by', $user->id)->where('status', 'pending')->count();
            $finalApproved = Expenditure::where('submitted_by', $user->id)->where('status', 'final_approved')->count();
        }
        
        // Statistics for different approval stages
        $approvalStats = [
            'pending' => Expenditure::where('status', 'pending')->count(),
            'hod_approved' => Expenditure::where('status', 'hod_approved')->count(),
            'final_approved' => Expenditure::where('status', 'final_approved')->count(),
            'rejected' => Expenditure::whereIn('status', ['hod_rejected', 'admin_rejected'])->count(),
        ];
        
        return view('dashboard', compact(
            'totalExpenditure', 
            'totalExpenditures', 
            'pendingApprovals', 
            'finalApproved',
            'approvalStats'
        ));
    }
}
