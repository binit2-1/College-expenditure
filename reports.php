<?php
// reports.php - Reports page
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - College Expenditure Monitoring & UC Generator</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>College Expenditure Monitoring & UC Generator</h1>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="expenditure.php">Expenditure Monitoring</a></li>
                <li><a href="uc-generator.php">UC Generator</a></li>
                <li><a href="reports.php">Reports</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <section id="reports">
            <h2>Reports</h2>
            
            <div class="report-filters">
                <form method="GET" action="reports.php">
                    <label for="start-date">Start Date:</label>
                    <input type="date" id="start-date" name="start_date">
                    
                    <label for="end-date">End Date:</label>
                    <input type="date" id="end-date" name="end_date">
                    
                    <label for="category-filter">Category:</label>
                    <select id="category-filter" name="category">
                        <option value="">All Categories</option>
                        <option value="stationery">Stationery</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="events">Events</option>
                        <option value="salary">Salary</option>
                        <option value="other">Other</option>
                    </select>
                    
                    <button type="submit">Filter</button>
                </form>
            </div>
            
            <div class="report-summary">
                <h3>Expenditure Summary</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Total Amount (₹)</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // This would calculate from database in real implementation
                        $summary = getExpenditureSummary();
                        foreach ($summary as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['category']); ?></td>
                            <td>₹<?php echo number_format($item['total'], 2); ?></td>
                            <td><?php echo $item['percentage']; ?>%</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="export-options">
                <h3>Export Reports</h3>
                <button onclick="exportReport('pdf')">Export as PDF</button>
                <button onclick="exportReport('excel')">Export as Excel</button>
            </div>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2023 College Expenditure Monitoring & UC Generator</p>
    </footer>
    
    <script src="js/script.js"></script>
    <script>
        function exportReport(format) {
            // In a real implementation, this would generate and download the report
            alert('Exporting report as ' + format.toUpperCase());
        }
    </script>
</body>
</html>

<?php
// Placeholder function - to be implemented in includes/functions.php
function getExpenditureSummary() {
    // This would calculate from database in real implementation
    // Returning sample data for now
    return [
        [
            'category' => 'Stationery',
            'total' => 5000.00,
            'percentage' => 25
        ],
        [
            'category' => 'Maintenance',
            'total' => 10000.00,
            'percentage' => 50
        ],
        [
            'category' => 'Events',
            'total' => 5000.00,
            'percentage' => 25
        ]
    ];
}
?>