@extends('layouts.app')

@section('title', 'Utilization Certificate')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- UC Header -->
    <div class="bg-white rounded-lg shadow-sm border p-8 mb-6">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">UTILIZATION CERTIFICATE</h1>
            <div class="text-lg text-gray-700">{{ $grant_details }}</div>
            <div class="text-sm text-gray-600 mt-2">UC Number: {{ $uc_number }}</div>
        </div>

        <!-- UC Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Period Details</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm">
                        <div><strong>From:</strong> {{ $uc_period_from->format('F d, Y') }}</div>
                        <div><strong>To:</strong> {{ $uc_period_to->format('F d, Y') }}</div>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Total Utilization</h3>
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-green-800">₹{{ number_format($total_amount, 2) }}</div>
                    <div class="text-sm text-green-600">{{ $expenditures->count() }} items</div>
                </div>
            </div>
        </div>

        <!-- Purpose -->
        <div class="mb-8">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Purpose of Expenditure</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-800">{{ $purpose }}</p>
            </div>
        </div>

        <!-- Expenditure Details -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Expenditure Details</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">S.No.</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item Description</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($expenditures as $index => $expenditure)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ $expenditure->item_name }}</div>
                                @if($expenditure->description)
                                    <div class="text-sm text-gray-500">{{ $expenditure->description }}</div>
                                @endif
                                <div class="text-xs text-gray-400">Submitted by: {{ $expenditure->submittedBy->name }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $expenditure->date->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($expenditure->category) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">{{ number_format($expenditure->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">Total Amount:</td>
                            <td class="px-4 py-3 text-sm font-bold text-gray-900 text-right">₹{{ number_format($total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Approval Trail -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Approval Trail</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $hodApprovers = $expenditures->groupBy('hod_approved_by')->keys();
                    $adminApprovers = $expenditures->groupBy('admin_approved_by')->keys();
                @endphp
                
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-medium text-blue-900 mb-2">HoD Approvals</h4>
                    @foreach($hodApprovers as $hodId)
                        @php $hod = $expenditures->where('hod_approved_by', $hodId)->first()->hodApprovedBy; @endphp
                        <div class="text-sm text-blue-700">
                            ✓ {{ $hod->name }} ({{ $hod->department }})
                        </div>
                    @endforeach
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <h4 class="font-medium text-green-900 mb-2">Admin Approvals</h4>
                    @foreach($adminApprovers as $adminId)
                        @php $admin = $expenditures->where('admin_approved_by', $adminId)->first()->adminApprovedBy; @endphp
                        <div class="text-sm text-green-700">
                            ✓ {{ $admin->name }} ({{ $admin->role }})
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Certification -->
        <div class="border-t pt-8">
            <div class="text-sm text-gray-700 mb-6">
                <p class="mb-4">
                    <strong>CERTIFIED</strong> that the amount of <strong>₹{{ number_format($total_amount, 2) }}</strong> 
                    (Rupees {{ ucwords(convertNumberToWords($total_amount)) }} only) has been utilized for the purpose 
                    for which it was sanctioned. The expenditure is in accordance with the terms and conditions of the grant.
                </p>
                <p class="mb-4">
                    All the expenditures have been duly approved through the multi-level approval system and are properly 
                    documented with supporting receipts and vouchers.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                <div>
                    <div class="border-t border-gray-300 pt-2">
                        <div class="text-sm font-medium text-gray-900">{{ $generated_by->name }}</div>
                        <div class="text-sm text-gray-600">{{ ucfirst($generated_by->role) }}</div>
                        <div class="text-sm text-gray-600">Date: {{ $generated_at->format('F d, Y') }}</div>
                    </div>
                </div>
                <div>
                    <div class="border-t border-gray-300 pt-2">
                        <div class="text-sm text-gray-600">Principal/Authorized Signatory</div>
                        <div class="text-sm text-gray-600">College Name</div>
                        <div class="text-sm text-gray-600">Official Seal</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between items-center mb-8">
        <a href="{{ route('uc.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
            ← Back to UC Generator
        </a>
        <div class="space-x-4">
            <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                Print UC
            </button>
            <a href="{{ route('uc.download-pdf') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                Download PDF
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .no-print { display: none !important; }
    body { font-size: 12px; }
    .bg-gray-50 { background-color: #f8f9fa !important; }
    .bg-blue-50 { background-color: #e3f2fd !important; }
    .bg-green-50 { background-color: #e8f5e8 !important; }
}
</style>
@endpush

@php
function convertNumberToWords($number) {
    $words = array(
        0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
        6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
        11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty',
        30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
        80 => 'Eighty', 90 => 'Ninety'
    );

    if ($number < 21) {
        return $words[$number];
    } elseif ($number < 100) {
        $tens = $words[10 * floor($number / 10)];
        $units = $words[$number % 10];
        return $tens . ($units ? ' ' . $units : '');
    } elseif ($number < 1000) {
        $hundreds = $words[floor($number / 100)] . ' Hundred';
        $remainder = $number % 100;
        return $hundreds . ($remainder ? ' ' . convertNumberToWords($remainder) : '');
    } elseif ($number < 100000) {
        $thousands = convertNumberToWords(floor($number / 1000)) . ' Thousand';
        $remainder = $number % 1000;
        return $thousands . ($remainder ? ' ' . convertNumberToWords($remainder) : '');
    } else {
        $lakhs = convertNumberToWords(floor($number / 100000)) . ' Lakh';
        $remainder = $number % 100000;
        return $lakhs . ($remainder ? ' ' . convertNumberToWords($remainder) : '');
    }
}
@endphp
@endsection
