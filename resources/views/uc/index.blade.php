@extends('layouts.app')

@section('title', 'UC Generator')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Utilisation Certificates</h2>
        <a href="{{ route('uc.create') }}" style="background: #27ae60; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px;">Generate New UC</a>
    </div>

    @if($certificates->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Expenditures Count</th>
                    <th>Total Amount</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($certificates as $certificate)
                <tr>
                    <td>{{ $certificate->title }}</td>
                    <td>{{ Str::limit($certificate->description, 100) }}</td>
                    <td>{{ $certificate->expenditures->count() }}</td>
                    <td>₹{{ number_format($certificate->expenditures->sum('amount'), 2) }}</td>
                    <td>{{ $certificate->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('uc.show', $certificate) }}" style="color: #3498db; text-decoration: none; margin-right: 1rem;">View</a>
                        <a href="{{ route('uc.edit', $certificate) }}" style="color: #f39c12; text-decoration: none; margin-right: 1rem;">Edit</a>
                        <form action="{{ route('uc.destroy', $certificate) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this UC?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 3px; cursor: pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No utilisation certificates found. <a href="{{ route('uc.create') }}">Generate your first UC</a>.</p>
    @endif
</div>
@endsection
