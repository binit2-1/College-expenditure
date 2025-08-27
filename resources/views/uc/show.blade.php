@extends('layouts.app')

@section('title', 'View UC')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Utilisation Certificate</h2>
        <div>
            <a href="{{ route('uc.edit', $uc) }}" style="background: #f39c12; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; margin-right: 1rem;">Edit</a>
            <a href="{{ route('uc.index') }}" style="background: #95a5a6; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px;">Back to List</a>
        </div>
    </div>

    <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
        <h3>{{ $uc->title }}</h3>
        <p style="margin: 1rem 0; color: #666;">Created on: {{ $uc->created_at->format('d F Y') }}</p>
        <p><strong>Description:</strong></p>
        <p style="margin-top: 0.5rem;">{{ $uc->description }}</p>
    </div>

    <h4>Associated Expenditures</h4>
    @if($uc->expenditures->count() > 0)
        <table style="margin-top: 1rem;">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Amount (₹)</th>
                    <th>Date</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                @foreach($uc->expenditures as $expenditure)
                <tr>
                    <td>{{ $expenditure->item_name }}</td>
                    <td>₹{{ number_format($expenditure->amount, 2) }}</td>
                    <td>{{ $expenditure->date->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($expenditure->category) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background: #34495e; color: white; font-weight: bold;">
                    <td colspan="3">Total Amount</td>
                    <td>₹{{ number_format($uc->expenditures->sum('amount'), 2) }}</td>
                </tr>
            </tfoot>
        </table>
    @else
        <p>No expenditures associated with this UC.</p>
    @endif

    <div style="margin-top: 2rem;">
        <button onclick="window.print()" style="background: #2ecc71;">Print UC</button>
    </div>
</div>
@endsection
