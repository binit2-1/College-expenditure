@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container">
    <h2>Reports</h2>
    
    <div class="report-filters" style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1rem;">Filter Reports</h3>
        <form method="GET" action="{{ route('reports.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}">
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">
            </div>
            
            <div class="form-group" style="margin-bottom: 0;">
                <label for="category">Category:</label>
                <select id="category" name="category">
                    <option value="">All Categories</option>
                    <option value="stationery" {{ request('category') == 'stationery' ? 'selected' : '' }}>Stationery</option>
                    <option value="maintenance" {{ request('category') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="events" {{ request('category') == 'events' ? 'selected' : '' }}>Events</option>
                    <option value="salary" {{ request('category') == 'salary' ? 'selected' : '' }}>Salary</option>
                    <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            
            <div>
                <button type="submit">Filter</button>
                @if(request()->hasAny(['start_date', 'end_date', 'category']))
                    <a href="{{ route('reports.index') }}" style="background: #95a5a6; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; margin-left: 0.5rem;">Clear</a>
                @endif
            </div>
        </form>
    </div>
    
    <div class="report-summary" style="margin-bottom: 2rem;">
        <h3>Expenditure Summary by Category</h3>
        @if($summary->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Total Amount (₹)</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($summary as $item)
                    <tr>
                        <td>{{ $item['category'] }}</td>
                        <td>₹{{ number_format($item['total'], 2) }}</td>
                        <td>{{ $item['percentage'] }}%</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #34495e; color: white; font-weight: bold;">
                        <td>Total</td>
                        <td>₹{{ number_format($summary->sum('total'), 2) }}</td>
                        <td>100%</td>
                    </tr>
                </tfoot>
            </table>
        @else
            <p>No expenditure data available.</p>
        @endif
    </div>
    
    <div class="detailed-report">
        <h3>Detailed Expenditure Report</h3>
        @if($expenditures->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Amount (₹)</th>
                        <th>Date</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenditures as $expenditure)
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
                        <td colspan="3">Total ({{ $expenditures->count() }} items)</td>
                        <td>₹{{ number_format($expenditures->sum('amount'), 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        @else
            <p>No expenditures found for the selected criteria.</p>
        @endif
    </div>
    
    <div class="export-options" style="margin-top: 2rem; padding: 1.5rem; background: #f8f9fa; border-radius: 8px;">
        <h3>Export Reports</h3>
        <p style="margin-bottom: 1rem;">Export functionality can be implemented with additional packages.</p>
        <button onclick="window.print()" style="background: #27ae60;">Print Report</button>
        <button onclick="alert('CSV export functionality can be added with Laravel Excel package')" style="background: #2ecc71; margin-left: 1rem;">Export as CSV</button>
        <button onclick="alert('PDF export functionality can be added with DomPDF package')" style="background: #3498db; margin-left: 1rem;">Export as PDF</button>
    </div>
</div>

<style>
    @media print {
        .export-options, .report-filters, nav, header, footer {
            display: none !important;
        }
        
        .container {
            max-width: none;
            margin: 0;
            padding: 0;
        }
        
        table {
            width: 100%;
            font-size: 12px;
        }
        
        th, td {
            padding: 0.5rem;
        }
    }
</style>
@endsection
