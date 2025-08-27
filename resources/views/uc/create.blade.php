@extends('layouts.app')

@section('title', 'Generate New UC')

@section('content')
<div class="container">
    <h2>Generate New Utilisation Certificate</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('uc.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="title">UC Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="expenditures">Select Expenditures:</label>
            <select id="expenditures" name="expenditures[]" multiple style="height: 200px;" required>
                @foreach($expenditures as $expenditure)
                    <option value="{{ $expenditure->id }}" 
                        {{ in_array($expenditure->id, old('expenditures', [])) ? 'selected' : '' }}>
                        {{ $expenditure->item_name }} - ₹{{ number_format($expenditure->amount, 2) }} ({{ $expenditure->date->format('d/m/Y') }})
                    </option>
                @endforeach
            </select>
            <small style="color: #666;">Hold Ctrl (or Cmd on Mac) to select multiple expenditures</small>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit">Generate UC</button>
            <a href="{{ route('uc.index') }}" style="background: #95a5a6; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; margin-left: 1rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection
