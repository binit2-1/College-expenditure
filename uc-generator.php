<?php
// uc-generator.php - UC Generator page
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UC Generator - College Expenditure Monitoring & UC Generator</title>
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
        <section id="uc-generator">
            <h2>UC Generator</h2>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message <?php echo $_SESSION['message_type']; ?>">
                    <?php echo $_SESSION['message']; ?>
                    <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
                </div>
            <?php endif; ?>
            
            <form id="uc-form" method="POST" action="process-uc.php">
                <label for="uc-title">UC Title:</label>
                <input type="text" id="uc-title" name="uc_title" required>
                
                <label for="uc-description">Description:</label>
                <textarea id="uc-description" name="uc_description" rows="4" required></textarea>
                
                <label for="uc-expenditure">Select Expenditures:</label>
                <select id="uc-expenditure" name="expenditures[]" multiple>
                    <?php
                    // This would fetch from database in real implementation
                    $expenditures = getExpenditures();
                    foreach ($expenditures as $exp): ?>
                        <option value="<?php echo $exp['id']; ?>">
                            <?php echo htmlspecialchars($exp['item_name']) . ' - ₹' . number_format($exp['amount'], 2); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" name="generate_uc">Generate UC</button>
            </form>
            
            <div id="uc-preview">
                <h3>UC Preview</h3>
                <div id="uc-content">
                    <!-- UC content will be generated here -->
                </div>
                <button id="download-uc">Download UC</button>
            </div>
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