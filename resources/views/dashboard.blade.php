@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
    <p class="text-gray-600">Overview of your expenditures and certificates</p>
    
    @if($totalExpenditure == 0)
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Welcome to College Expenditure System!</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>Get started by adding your first expenditure or check out the <a href="{{ route('guide') }}" class="font-medium underline text-blue-800 hover:text-blue-900">How to Use</a> guide.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Expenditure</p>
                <p class="text-2xl font-bold text-gray-900">₹{{ number_format($totalExpenditure, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Pending Approvals</p>
                <p class="text-2xl font-bold text-gray-900">{{ $pendingApprovals }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Final Approved</p>
                <p class="text-2xl font-bold text-gray-900">{{ $finalApproved }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white p-6 rounded-lg shadow-sm border mb-8">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
    <div class="flex flex-wrap gap-4">
        @if(auth()->user()->canCreateExpenses())
            <a href="{{ route('expenditures.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Add Expenditure
            </a>
        @endif
        @if(auth()->user()->isAdmin())
            <a href="{{ route('uc.index') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                Generate UC
            </a>
        @endif
        <a href="{{ route('reports.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            View Reports
        </a>
    </div>
</div>

<!-- Multi-Level Approval Workflow Status -->
<div class="bg-white p-6 rounded-lg shadow-sm border mb-8">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Approval Workflow Status</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="text-center p-4 bg-yellow-50 rounded-lg">
            <div class="text-2xl font-bold text-yellow-800">{{ $approvalStats['pending'] }}</div>
            <div class="text-sm text-yellow-600">Pending HoD</div>
        </div>
        <div class="text-center p-4 bg-blue-50 rounded-lg">
            <div class="text-2xl font-bold text-blue-800">{{ $approvalStats['hod_approved'] }}</div>
            <div class="text-sm text-blue-600">HoD Approved</div>
        </div>
        <div class="text-center p-4 bg-green-50 rounded-lg">
            <div class="text-2xl font-bold text-green-800">{{ $approvalStats['final_approved'] }}</div>
            <div class="text-sm text-green-600">Final Approved</div>
        </div>
        <div class="text-center p-4 bg-red-50 rounded-lg">
            <div class="text-2xl font-bold text-red-800">{{ $approvalStats['rejected'] }}</div>
            <div class="text-sm text-red-600">Rejected</div>
        </div>
    </div>
    
    <!-- Role-specific action prompts -->
    @if(auth()->user()->isHoD() && $approvalStats['pending'] > 0)
        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.084 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <span class="text-sm text-yellow-800">
                    You have {{ $approvalStats['pending'] }} expenditure(s) pending your HoD approval.
                    <a href="{{ route('expenditures.index') }}" class="font-medium underline">Review now →</a>
                </span>
            </div>
        </div>
    @elseif(auth()->user()->isAdmin() && $approvalStats['hod_approved'] > 0)
        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm text-blue-800">
                    {{ $approvalStats['hod_approved'] }} expenditure(s) are awaiting your final approval.
                    <a href="{{ route('expenditures.index') }}" class="font-medium underline">Review now →</a>
                </span>
            </div>
        </div>
    @endif
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Expenditures -->
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Expenditures</h3>
        @php
            $recentExpenditures = \App\Models\Expenditure::latest()->limit(5)->get();
        @endphp
        
        @if($recentExpenditures->count() > 0)
            <div class="space-y-3">
                @foreach($recentExpenditures as $expenditure)
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                        <div>
                            <p class="font-medium text-gray-900">{{ $expenditure->item_name }}</p>
                            <p class="text-sm text-gray-500">{{ $expenditure->date->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold">₹{{ number_format($expenditure->amount, 2) }}</p>
                            <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ ucfirst($expenditure->category) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                <a href="{{ route('expenditures.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View all →</a>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No expenditures yet</p>
            <div class="text-center">
                <a href="{{ route('expenditures.create') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Add your first expenditure</a>
            </div>
        @endif
    </div>

    <!-- Recent UCs -->
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent UCs</h3>
        @php
            $recentUCs = \App\Models\UtilisationCertificate::with('expenditures')->latest()->limit(5)->get();
        @endphp
        
        @if($recentUCs->count() > 0)
            <div class="space-y-3">
                @foreach($recentUCs as $uc)
                    <div class="py-2 border-b border-gray-100 last:border-b-0">
                        <p class="font-medium text-gray-900">{{ $uc->title }}</p>
                        <p class="text-sm text-gray-500 mb-2">{{ Str::limit($uc->description, 60) }}</p>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-500">{{ $uc->expenditures->count() }} items</span>
                            <span class="font-semibold">₹{{ number_format($uc->expenditures->sum('amount'), 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                <a href="{{ route('uc.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View all →</a>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No UCs generated yet</p>
            <div class="text-center">
                <a href="{{ route('uc.create') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Generate your first UC</a>
            </div>
        @endif
    </div>
</div>
@endsection
