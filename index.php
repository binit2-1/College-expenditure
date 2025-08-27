<?php
// index.php - Main entry point for the application
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Expenditure Monitoring & UC Generator</title>
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
        <section id="dashboard">
            <h2>Dashboard</h2>
            <div class="dashboard-stats">
                <div class="stat-card">
                    <h3>Total Expenditure</h3>
                    <p>₹<?php echo number_format(getTotalExpenditure(), 2); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Pending UCs</h3>
                    <p><?php echo getPendingUCs(); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Completed UCs</h3>
                    <p><?php echo getCompletedUCs(); ?></p>
                </div>
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
// Placeholder functions - to be implemented in includes/functions.php
function getTotalExpenditure() {
    // This would fetch from database in real implementation
    return 0;
}

function getPendingUCs() {
    // This would fetch from database in real implementation
    return 0;
}

function getCompletedUCs() {
    // This would fetch from database in real implementation
    return 0;
}
?>