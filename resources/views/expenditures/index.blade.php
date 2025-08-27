@extends('layouts.app')

@section('title', 'Expenditures')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Expenditures</h2>
        <p class="text-gray-600">
            @if(auth()->user()->isAdmin())
                Review expenditures approved by HoDs for final approval
            @elseif(auth()->user()->isHoD())
                Review expenditures from your department for HoD approval
            @else
                Manage your submitted expenditures
            @endif
        </p>
    </div>
    @if(auth()->user()->canCreateExpenses())
        <a href="{{ route('expenditures.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            Add Expenditure
        </a>
    @endif
</div>

@if($expenditures->count() > 0)
    <!-- Summary Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg shadow-sm border">
            <p class="text-sm text-gray-600">Total Items</p>
            <p class="text-xl font-bold">{{ $expenditures->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border">
            <p class="text-sm text-gray-600">Total Amount</p>
            <p class="text-xl font-bold">₹{{ number_format($expenditures->sum('amount'), 2) }}</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg shadow-sm border border-yellow-200">
            <p class="text-sm text-yellow-700">Pending</p>
            <p class="text-xl font-bold text-yellow-800">{{ $expenditures->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-blue-50 p-4 rounded-lg shadow-sm border border-blue-200">
            <p class="text-sm text-blue-700">HoD Approved</p>
            <p class="text-xl font-bold text-blue-800">{{ $expenditures->where('status', 'hod_approved')->count() }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg shadow-sm border border-green-200">
            <p class="text-sm text-green-700">Final Approved</p>
            <p class="text-xl font-bold text-green-800">{{ $expenditures->where('status', 'final_approved')->count() }}</p>
        </div>
        <div class="bg-red-50 p-4 rounded-lg shadow-sm border border-red-200">
            <p class="text-sm text-red-700">Rejected</p>
            <p class="text-xl font-bold text-red-800">{{ $expenditures->whereIn('status', ['hod_rejected', 'admin_rejected'])->count() }}</p>
        </div>
    </div>

    <!-- Expenditures Table -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        @if(auth()->user()->isAdmin())
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted By</th>
                        @endif
                        @if(auth()->user()->isAdmin() || auth()->user()->isHoD())
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approval Progress</th>
                        @endif
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($expenditures as $expenditure)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $expenditure->item_name }}</div>
                            @if($expenditure->description)
                                <div class="text-sm text-gray-500">{{ Str::limit($expenditure->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-semibold text-gray-900">₹{{ number_format($expenditure->amount, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                            {{ $expenditure->date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $colors = [
                                    'academic' => 'bg-blue-100 text-blue-800',
                                    'infrastructure' => 'bg-yellow-100 text-yellow-800',
                                    'administrative' => 'bg-purple-100 text-purple-800',
                                    'events' => 'bg-pink-100 text-pink-800',
                                    'technology' => 'bg-indigo-100 text-indigo-800',
                                    'other' => 'bg-gray-100 text-gray-800'
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $colors[$expenditure->category] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($expenditure->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'hod_approved' => 'bg-blue-100 text-blue-800',
                                    'hod_rejected' => 'bg-red-100 text-red-800',
                                    'admin_approved' => 'bg-green-100 text-green-800',
                                    'admin_rejected' => 'bg-red-100 text-red-800',
                                    'final_approved' => 'bg-green-100 text-green-800'
                                ];
                                
                                $statusLabels = [
                                    'pending' => 'Pending HoD',
                                    'hod_approved' => 'HoD Approved',
                                    'hod_rejected' => 'HoD Rejected',
                                    'admin_approved' => 'Admin Approved',
                                    'admin_rejected' => 'Admin Rejected',
                                    'final_approved' => 'Final Approved'
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$expenditure->status] }}">
                                {{ $statusLabels[$expenditure->status] ?? ucfirst($expenditure->status) }}
                            </span>
                        </td>
                        @if(auth()->user()->isAdmin())
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $expenditure->submittedBy->name ?? 'Unknown' }}
                            </td>
                        @endif
                        @if(auth()->user()->isAdmin() || auth()->user()->isHoD())
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div class="space-y-1">
                                    @if($expenditure->hodApprovedBy)
                                        <div class="text-blue-600">
                                            ✓ HoD: {{ $expenditure->hodApprovedBy->name }}
                                            <div class="text-xs text-gray-500">{{ $expenditure->hod_approved_at?->format('M d, Y') }}</div>
                                        </div>
                                    @endif
                                    @if($expenditure->adminApprovedBy)
                                        <div class="text-green-600">
                                            ✓ Admin: {{ $expenditure->adminApprovedBy->name }}
                                            <div class="text-xs text-gray-500">{{ $expenditure->admin_approved_at?->format('M d, Y') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('expenditures.show', $expenditure) }}" 
                                   class="text-blue-600 hover:text-blue-700 text-sm">View</a>
                                
                                {{-- HoD Approval Actions --}}
                                @if(auth()->user()->isHoD() && $expenditure->status === 'pending')
                                    <button onclick="showApprovalModal({{ $expenditure->id }}, 'approve')" 
                                            class="text-green-600 hover:text-green-700 text-sm">Approve</button>
                                    <button onclick="showApprovalModal({{ $expenditure->id }}, 'reject')" 
                                            class="text-red-600 hover:text-red-700 text-sm">Reject</button>
                                @endif
                                
                                {{-- Admin Final Approval Actions --}}
                                @if(auth()->user()->isAdmin() && $expenditure->status === 'hod_approved')
                                    <button onclick="showApprovalModal({{ $expenditure->id }}, 'approve')" 
                                            class="text-green-600 hover:text-green-700 text-sm">Final Approve</button>
                                    <button onclick="showApprovalModal({{ $expenditure->id }}, 'reject')" 
                                            class="text-red-600 hover:text-red-700 text-sm">Reject</button>
                                @endif
                                
                                @if(($expenditure->submitted_by === auth()->id() && $expenditure->status === 'pending') || auth()->user()->isAdmin())
                                    <button onclick="confirmDelete({{ $expenditure->id }})" 
                                            class="text-red-600 hover:text-red-700 text-sm">Delete</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <!-- Empty State -->
    <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No expenditures found</h3>
        <p class="text-gray-600 mb-6">
            @if(auth()->user()->canCreateExpenses())
                Get started by adding your first expenditure.
            @else
                No expenditures to review at this time.
            @endif
        </p>
        @if(auth()->user()->canCreateExpenses())
            <a href="{{ route('expenditures.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                Add Your First Expenditure
            </a>
        @endif
    </div>
@endif

<!-- Approval Modal -->
<div id="approvalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900 mb-4"></h3>
                <form id="approvalForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="approval_notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea id="approval_notes" name="approval_notes" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Add approval notes..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" 
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" id="submitBtn"
                                class="px-4 py-2 rounded-md text-white">
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showApprovalModal(expenditureId, action) {
    const modal = document.getElementById('approvalModal');
    const form = document.getElementById('approvalForm');
    const title = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');
    const notesField = document.getElementById('approval_notes');
    
    if (action === 'approve') {
        if (window.location.pathname.includes('expenditures')) {
            // Check if user is HoD or Admin based on context
            @if(auth()->user()->isHoD())
                title.textContent = 'HoD Approval';
                submitBtn.textContent = 'Approve (HoD Level)';
            @elseif(auth()->user()->isAdmin())
                title.textContent = 'Final Admin Approval';
                submitBtn.textContent = 'Give Final Approval';
            @endif
        }
        submitBtn.className = 'px-4 py-2 rounded-md text-white bg-green-600 hover:bg-green-700';
        notesField.placeholder = 'Add approval notes (optional)...';
        notesField.required = false;
        form.action = `/expenditures/${expenditureId}/approve`;
    } else {
        if (window.location.pathname.includes('expenditures')) {
            @if(auth()->user()->isHoD())
                title.textContent = 'HoD Rejection';
                submitBtn.textContent = 'Reject (HoD Level)';
            @elseif(auth()->user()->isAdmin())
                title.textContent = 'Admin Rejection';
                submitBtn.textContent = 'Reject (Admin Level)';
            @endif
        }
        submitBtn.className = 'px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-700';
        notesField.placeholder = 'Reason for rejection (required)...';
        notesField.required = true;
        form.action = `/expenditures/${expenditureId}/reject`;
    }
    
    notesField.value = '';
    modal.classList.remove('hidden');
}

function closeModal() {
    document.getElementById('approvalModal').classList.add('hidden');
}

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this expenditure?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/expenditures/' + id;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Close modal when clicking outside
document.getElementById('approvalModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection
