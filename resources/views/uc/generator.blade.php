@extends('layouts.app')

@section('title', 'UC Generator')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Utilization Certificate Generator</h2>
        <p class="text-gray-600">Generate UC for final approved expenditures</p>
    </div>
</div>

@if($finalApprovedExpenditures->count() > 0)
    <!-- Summary Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-green-50 p-4 rounded-lg shadow-sm border border-green-200">
            <p class="text-sm text-green-700">Final Approved Items</p>
            <p class="text-xl font-bold text-green-800">{{ $totalItems }}</p>
        </div>
        <div class="bg-blue-50 p-4 rounded-lg shadow-sm border border-blue-200">
            <p class="text-sm text-blue-700">Total Amount</p>
            <p class="text-xl font-bold text-blue-800">₹{{ number_format($totalAmount, 2) }}</p>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg shadow-sm border border-purple-200">
            <p class="text-sm text-purple-700">Ready for UC</p>
            <p class="text-xl font-bold text-purple-800">{{ $totalItems }}</p>
        </div>
    </div>

    <!-- UC Generation Form -->
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Generate Utilization Certificate</h3>
        
        <form method="POST" action="{{ route('uc.generate') }}" id="ucForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="uc_period_from" class="block text-sm font-medium text-gray-700 mb-2">UC Period From</label>
                    <input type="date" id="uc_period_from" name="uc_period_from" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('uc_period_from', now()->startOfMonth()->format('Y-m-d')) }}" required>
                </div>
                <div>
                    <label for="uc_period_to" class="block text-sm font-medium text-gray-700 mb-2">UC Period To</label>
                    <input type="date" id="uc_period_to" name="uc_period_to" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('uc_period_to', now()->endOfMonth()->format('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="mb-6">
                <label for="grant_details" class="block text-sm font-medium text-gray-700 mb-2">Grant Details</label>
                <input type="text" id="grant_details" name="grant_details" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                       placeholder="e.g., UGC Grant 2024-25, RUSA Fund, etc." value="{{ old('grant_details') }}" required>
            </div>

            <div class="mb-6">
                <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">Purpose of Expenditure</label>
                <textarea id="purpose" name="purpose" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Describe the overall purpose of the expenditures..." required>{{ old('purpose') }}</textarea>
            </div>

            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-md font-medium text-gray-900">Select Expenditures for UC</h4>
                    <div class="space-x-2">
                        <button type="button" onclick="selectAll()" class="text-blue-600 hover:text-blue-700 text-sm">Select All</button>
                        <button type="button" onclick="selectNone()" class="text-blue-600 hover:text-blue-700 text-sm">Select None</button>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto max-h-96">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th class="px-4 py-3 text-left">
                                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleAll(this)" 
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted By</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($finalApprovedExpenditures as $expenditure)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <input type="checkbox" name="expenditure_ids[]" value="{{ $expenditure->id }}" 
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 expenditure-checkbox">
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900">{{ $expenditure->item_name }}</div>
                                        @if($expenditure->description)
                                            <div class="text-sm text-gray-500">{{ Str::limit($expenditure->description, 40) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-gray-900">₹{{ number_format($expenditure->amount, 2) }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $expenditure->date->format('M d, Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                            {{ ucfirst($expenditure->category) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $expenditure->submittedBy->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-4 text-sm text-gray-600">
                    <span id="selectedCount">0</span> of {{ $totalItems }} expenditures selected 
                    | Selected Amount: ₹<span id="selectedAmount">0.00</span>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Generate UC
                </button>
            </div>
        </form>
    </div>
@else
    <!-- Empty State -->
    <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No Final Approved Expenditures</h3>
        <p class="text-gray-600 mb-6">UC can only be generated for expenditures with final approval status.</p>
        <a href="{{ route('expenditures.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            View Expenditures
        </a>
    </div>
@endif

<script>
// Expenditure amounts for calculation
const expenditureAmounts = {
    @foreach($finalApprovedExpenditures as $expenditure)
        {{ $expenditure->id }}: {{ $expenditure->amount }},
    @endforeach
};

function selectAll() {
    const checkboxes = document.querySelectorAll('.expenditure-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    document.getElementById('selectAllCheckbox').checked = true;
    updateSelectedInfo();
}

function selectNone() {
    const checkboxes = document.querySelectorAll('.expenditure-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAllCheckbox').checked = false;
    updateSelectedInfo();
}

function toggleAll(masterCheckbox) {
    const checkboxes = document.querySelectorAll('.expenditure-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = masterCheckbox.checked;
    });
    updateSelectedInfo();
}

function updateSelectedInfo() {
    const checkboxes = document.querySelectorAll('.expenditure-checkbox:checked');
    const count = checkboxes.length;
    let totalAmount = 0;

    checkboxes.forEach(checkbox => {
        const expenditureId = parseInt(checkbox.value);
        totalAmount += expenditureAmounts[expenditureId] || 0;
    });

    document.getElementById('selectedCount').textContent = count;
    document.getElementById('selectedAmount').textContent = totalAmount.toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    // Update master checkbox state
    const masterCheckbox = document.getElementById('selectAllCheckbox');
    const allCheckboxes = document.querySelectorAll('.expenditure-checkbox');
    
    if (count === 0) {
        masterCheckbox.checked = false;
        masterCheckbox.indeterminate = false;
    } else if (count === allCheckboxes.length) {
        masterCheckbox.checked = true;
        masterCheckbox.indeterminate = false;
    } else {
        masterCheckbox.checked = false;
        masterCheckbox.indeterminate = true;
    }
}

// Add event listeners to individual checkboxes
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.expenditure-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedInfo);
    });
    
    // Form validation
    document.getElementById('ucForm').addEventListener('submit', function(e) {
        const selectedCheckboxes = document.querySelectorAll('.expenditure-checkbox:checked');
        if (selectedCheckboxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one expenditure for UC generation.');
        }
    });
});
</script>
@endsection
