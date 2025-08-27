<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenditure;
use App\Models\UtilisationCertificate;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Expenditure::query();
        
        // Apply filters if provided
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        $expenditures = $query->orderBy('date', 'desc')->get();
        
        // Calculate summary by category
        $summary = Expenditure::selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get()
            ->map(function ($item) {
                $totalExpenditure = Expenditure::sum('amount');
                $percentage = $totalExpenditure > 0 ? ($item->total / $totalExpenditure) * 100 : 0;
                return [
                    'category' => ucfirst($item->category),
                    'total' => $item->total,
                    'percentage' => round($percentage, 1)
                ];
            });
        
        return view('reports.index', compact('expenditures', 'summary'));
    }
}
