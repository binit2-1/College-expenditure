@extends('layouts.app')

@section('title', 'Add New Expenditure')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Add New Expenditure</h2>
            <p class="text-gray-600">Submit an expenditure for approval</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('expenditures.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="item_name" class="block text-sm font-medium text-gray-700 mb-2">Item Name *</label>
                    <input type="text" id="item_name" name="item_name" value="{{ old('item_name') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Amount (₹) *</label>
                    <input type="number" id="amount" name="amount" step="0.01" value="{{ old('amount') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                    <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select id="category" name="category" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Category</option>
                        <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>Academic</option>
                        <option value="infrastructure" {{ old('category') == 'infrastructure' ? 'selected' : '' }}>Infrastructure</option>
                        <option value="administrative" {{ old('category') == 'administrative' ? 'selected' : '' }}>Administrative</option>
                        <option value="events" {{ old('category') == 'events' ? 'selected' : '' }}>Events</option>
                        <option value="technology" {{ old('category') == 'technology' ? 'selected' : '' }}>Technology</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Detailed description of the expenditure...">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="receipt" class="block text-sm font-medium text-gray-700 mb-2">Receipt/Document</label>
                <input type="file" id="receipt" name="receipt" accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <p class="text-sm text-gray-500 mt-1">Upload receipt or supporting document (PDF, JPG, PNG - Max: 2MB)</p>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('expenditures.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Submit for Approval
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
