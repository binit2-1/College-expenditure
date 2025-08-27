@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-sm border p-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">How to Use College Expenditure System</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">A comprehensive guide to managing college expenditures and generating utilisation certificates</p>
        </div>

        <!-- Quick Start -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <span class="text-3xl mr-3">🚀</span>
                <h2 class="text-2xl font-bold text-gray-900">Quick Start</h2>
            </div>
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-6 rounded-r-lg mb-6">
                <p class="text-blue-900 text-lg"><strong>Welcome!</strong> This system helps you track college expenditures and generate utilisation certificates for financial reporting.</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-6">
                <ol class="list-decimal list-inside space-y-3 text-gray-700">
                    <li class="text-lg">Start by adding your first expenditure using the "Add New Expenditure" button</li>
                    <li class="text-lg">Fill in all required details including amount, category, and description</li>
                    <li class="text-lg">Generate utilisation certificates when needed for reporting</li>
                    <li class="text-lg">Use the reports section to analyze spending patterns</li>
                </ol>
            </div>
        </div>

        <!-- Dashboard -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <span class="text-3xl mr-3">📊</span>
                <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-xl border">
                    <h3 class="font-bold text-gray-900 text-lg mb-4">Overview Cards</h3>
                    <ul class="text-gray-700 space-y-2">
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">•</span>
                            <span><strong>Total Expenditures:</strong> Shows count of all recorded expenses</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">•</span>
                            <span><strong>Total Amount:</strong> Sum of all expenditure amounts</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">•</span>
                            <span><strong>This Month:</strong> Current month's spending</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">•</span>
                            <span><strong>Pending UCs:</strong> Certificates awaiting generation</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 p-6 rounded-xl border">
                    <h3 class="font-bold text-gray-900 text-lg mb-4">Recent Activity</h3>
                    <ul class="text-gray-700 space-y-2">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">•</span>
                            <span>View latest 5 expenditures</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">•</span>
                            <span>Quick access to recent transactions</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">•</span>
                            <span>Status indicators for each entry</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Expenditures -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <span class="text-3xl mr-3">💰</span>
                <h2 class="text-2xl font-bold text-gray-900">Managing Expenditures</h2>
            </div>
            
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Adding New Expenditure</h3>
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-xl border-l-4 border-purple-500 mb-6">
                    <ol class="list-decimal list-inside space-y-3 text-gray-800">
                        <li class="text-lg">Click "Add New Expenditure" button</li>
                        <li class="text-lg">Fill in the required fields:
                            <ul class="list-disc list-inside ml-6 mt-3 space-y-2 text-base">
                                <li><strong>Title:</strong> Brief description of the expense</li>
                                <li><strong>Amount:</strong> Cost in rupees (numbers only)</li>
                                <li><strong>Category:</strong> Select from predefined categories</li>
                                <li><strong>Date:</strong> When the expense occurred</li>
                                <li><strong>Description:</strong> Detailed explanation (optional)</li>
                                <li><strong>Receipt:</strong> Upload supporting documents</li>
                            </ul>
                        </li>
                        <li class="text-lg">Click "Save Expenditure" to record</li>
                    </ol>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Expenditure Categories</h3>
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h4 class="font-bold text-blue-900 text-lg">Academic</h4>
                        <p class="text-blue-700 mt-1">Books, supplies, lab equipment</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <h4 class="font-bold text-green-900 text-lg">Infrastructure</h4>
                        <p class="text-green-700 mt-1">Building, maintenance, utilities</p>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                        <h4 class="font-bold text-yellow-900 text-lg">Administrative</h4>
                        <p class="text-yellow-700 mt-1">Office supplies, staff expenses</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                        <h4 class="font-bold text-purple-900 text-lg">Events</h4>
                        <p class="text-purple-700 mt-1">Conferences, seminars, workshops</p>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-200">
                        <h4 class="font-bold text-indigo-900 text-lg">Technology</h4>
                        <p class="text-indigo-700 mt-1">Software, hardware, IT services</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="font-bold text-gray-900 text-lg">Other</h4>
                        <p class="text-gray-700 mt-1">Miscellaneous expenses</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-xl">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Managing Records</h3>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    <li><strong>View:</strong> Click on any expenditure to see full details</li>
                    <li><strong>Edit:</strong> Use the edit button to modify existing records</li>
                    <li><strong>Delete:</strong> Remove incorrect or duplicate entries</li>
                    <li><strong>Search:</strong> Use filters to find specific expenditures</li>
                </ul>
            </div>
        </div>

        <!-- UC Generator -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <span class="text-3xl mr-3">📋</span>
                <h2 class="text-2xl font-bold text-gray-900">Utilisation Certificate (UC) Generator</h2>
            </div>
            
            <div class="bg-gradient-to-r from-orange-50 to-red-50 border-l-4 border-orange-500 p-6 rounded-r-lg mb-8">
                <p class="text-orange-900 text-lg"><strong>What is a UC?</strong> A Utilisation Certificate is an official document that certifies how funds were used, required for financial audits and grant reporting.</p>
            </div>

            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Creating a UC</h3>
                <div class="bg-orange-50 p-6 rounded-xl">
                    <ol class="list-decimal list-inside space-y-3 text-gray-800">
                        <li class="text-lg">Go to "UC Generator" tab</li>
                        <li class="text-lg">Click "Generate New UC"</li>
                        <li class="text-lg">Fill in UC details:
                            <ul class="list-disc list-inside ml-6 mt-3 space-y-2 text-base">
                                <li><strong>Certificate Number:</strong> Unique identifier</li>
                                <li><strong>Grant Details:</strong> Source of funding</li>
                                <li><strong>Period:</strong> Start and end dates</li>
                                <li><strong>Purpose:</strong> Reason for expenditure</li>
                            </ul>
                        </li>
                        <li class="text-lg">Select expenditures to include</li>
                        <li class="text-lg">Generate and download PDF</li>
                    </ol>
                </div>
            </div>

            <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-200">
                <h3 class="text-xl font-bold text-yellow-900 mb-4">UC Best Practices</h3>
                <ul class="list-disc list-inside space-y-2 text-yellow-800">
                    <li>Include only relevant expenditures for each grant/fund</li>
                    <li>Ensure all amounts are accurate and documented</li>
                    <li>Keep supporting receipts and documents ready</li>
                    <li>Generate UCs promptly after expenditure periods</li>
                    <li>Review all details before finalizing</li>
                </ul>
            </div>
        </div>

        <!-- Reports -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <span class="text-3xl mr-3">📈</span>
                <h2 class="text-2xl font-bold text-gray-900">Reports & Analytics</h2>
            </div>
            
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Available Reports</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-gradient-to-br from-red-50 to-pink-50 p-6 rounded-xl border border-red-200">
                        <h4 class="font-bold text-red-900 text-lg mb-4">Expenditure Summary</h4>
                        <ul class="text-red-800 space-y-2">
                            <li class="flex items-start">
                                <span class="text-red-500 mr-2">•</span>
                                <span>Total spending by category</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-red-500 mr-2">•</span>
                                <span>Monthly breakdown</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-red-500 mr-2">•</span>
                                <span>Trend analysis</span>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-200">
                        <h4 class="font-bold text-blue-900 text-lg mb-4">UC Status Report</h4>
                        <ul class="text-blue-800 space-y-2">
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <span>Generated certificates</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <span>Pending certifications</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <span>Compliance tracking</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-xl">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Using Filters</h3>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    <li><strong>Date Range:</strong> Filter by specific periods</li>
                    <li><strong>Category:</strong> View spending by type</li>
                    <li><strong>Amount Range:</strong> Focus on high/low value items</li>
                    <li><strong>Status:</strong> Filter by UC generation status</li>
                </ul>
            </div>
        </div>

        <!-- Tips & Best Practices -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <span class="text-3xl mr-3">💡</span>
                <h2 class="text-2xl font-bold text-gray-900">Tips & Best Practices</h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-200">
                    <h3 class="text-xl font-bold text-indigo-900 mb-4">Data Entry Tips</h3>
                    <ul class="list-disc list-inside space-y-3 text-indigo-800">
                        <li>Enter expenditures immediately after purchase</li>
                        <li>Use consistent naming conventions</li>
                        <li>Always upload receipts as proof</li>
                        <li>Double-check amounts before saving</li>
                        <li>Use descriptive titles and categories</li>
                    </ul>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200">
                    <h3 class="text-xl font-bold text-green-900 mb-4">Financial Management</h3>
                    <ul class="list-disc list-inside space-y-3 text-green-800">
                        <li>Review spending patterns monthly</li>
                        <li>Generate UCs before deadlines</li>
                        <li>Keep digital backups of all documents</li>
                        <li>Monitor budget limits by category</li>
                        <li>Prepare reports for stakeholders</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Troubleshooting -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <span class="text-3xl mr-3">🔧</span>
                <h2 class="text-2xl font-bold text-gray-900">Troubleshooting</h2>
            </div>
            
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-xl border border-yellow-300">
                <h3 class="text-xl font-bold text-yellow-900 mb-4">Common Issues</h3>
                <div class="space-y-6">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <p class="font-bold text-gray-900 mb-2">Can't upload receipt files</p>
                        <p class="text-gray-700">• Check file size (max 2MB)<br>• Use supported formats (PDF, JPG, PNG)</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <p class="font-bold text-gray-900 mb-2">UC generation fails</p>
                        <p class="text-gray-700">• Ensure all required fields are filled<br>• Check if expenditures are selected</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <p class="font-bold text-gray-900 mb-2">Data not saving</p>
                        <p class="text-gray-700">• Check internet connection<br>• Verify all required fields<br>• Try refreshing the page</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support -->
        <div class="bg-gradient-to-r from-gray-100 to-gray-200 p-8 rounded-xl border-2 border-gray-300">
            <div class="flex items-center mb-4">
                <span class="text-3xl mr-3">📞</span>
                <h2 class="text-2xl font-bold text-gray-900">Need Help?</h2>
            </div>
            <p class="text-gray-800 text-lg mb-4">If you need additional assistance:</p>
            <ul class="list-disc list-inside space-y-2 text-gray-700">
                <li>Check this guide for step-by-step instructions</li>
                <li>Contact your system administrator</li>
                <li>Keep your data backed up regularly</li>
            </ul>
        </div>
    </div>
</div>
@endsection
