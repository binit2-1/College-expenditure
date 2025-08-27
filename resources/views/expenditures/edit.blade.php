@extends('layouts.app')

@section('title', 'Edit Expenditure')

@section('content')
<div class="container">
    <h2>Edit Expenditure</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('expenditures.update', $expenditure) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="item_name">Item Name:</label>
            <input type="text" id="item_name" name="item_name" value="{{ old('item_name', $expenditure->item_name) }}" required>
        </div>

        <div class="form-group">
            <label for="amount">Amount (₹):</label>
            <input type="number" id="amount" name="amount" step="0.01" value="{{ old('amount', $expenditure->amount) }}" required>
        </div>

        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="{{ old('date', $expenditure->date->format('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="stationery" {{ old('category', $expenditure->category) == 'stationery' ? 'selected' : '' }}>Stationery</option>
                <option value="maintenance" {{ old('category', $expenditure->category) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="events" {{ old('category', $expenditure->category) == 'events' ? 'selected' : '' }}>Events</option>
                <option value="salary" {{ old('category', $expenditure->category) == 'salary' ? 'selected' : '' }}>Salary</option>
                <option value="other" {{ old('category', $expenditure->category) == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit">Update Expenditure</button>
            <a href="{{ route('expenditures.index') }}" style="background: #95a5a6; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; margin-left: 1rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection
