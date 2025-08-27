<?php
// expenditure.php - Expenditure monitoring page
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenditure Monitoring - College Expenditure Monitoring & UC Generator</title>
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
        <section id="expenditure">
            <h2>Expenditure Monitoring</h2>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message <?php echo $_SESSION['message_type']; ?>">
                    <?php echo $_SESSION['message']; ?>
                    <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
                </div>
            <?php endif; ?>
            
            <form id="expenditure-form" method="POST" action="process-expenditure.php">
                <label for="item-name">Item Name:</label>
                <input type="text" id="item-name" name="item_name" required>
                
                <label for="amount">Amount (₹):</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
                
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
                
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="stationery">Stationery</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="events">Events</option>
                    <option value="salary">Salary</option>
                    <option value="other">Other</option>
                </select>
                
                <button type="submit" name="add_expenditure">Add Expenditure</button>
            </form>
            
            <table id="expenditure-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Amount (₹)</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // This would fetch from database in real implementation
                    $expenditures = getExpenditures();
                    foreach ($expenditures as $exp): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($exp['item_name']); ?></td>
                        <td>₹<?php echo number_format($exp['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($exp['date']); ?></td>
                        <td><?php echo htmlspecialchars($exp['category']); ?></td>
                        <td>
                            <a href="process-expenditure.php?action=edit&id=<?php echo $exp['id']; ?>">Edit</a>
                            <a href="process-expenditure.php?action=delete&id=<?php echo $exp['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2023 College Expenditure Monitoring & UC Generator</p>
    </footer>
    
    <script src="js/script.js"></script>
</body>
</html>

<?php
// Placeholder function - to be implemented in includes/functions.php
function getExpenditures() {
    // This would fetch from database in real implementation
    // Returning sample data for now
    return [
        [
            'id' => 1,
            'item_name' => 'Sample Item',
            'amount' => 1000.00,
            'date' => '2023-01-01',
            'category' => 'stationery'
        ]
    ];
}
?>