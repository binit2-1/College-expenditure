<?php
// process-uc.php - Process UC form submissions
session_start();
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_uc'])) {
    // Generate new UC
    $uc_title = trim($_POST['uc_title']);
    $uc_description = trim($_POST['uc_description']);
    $expenditures = $_POST['expenditures'] ?? [];
    
    if (!empty($uc_title) && !empty($uc_description) && !empty($expenditures)) {
        $uc_id = createUC($uc_title, $uc_description, $expenditures);
        
        if ($uc_id) {
            $_SESSION['message'] = 'UC generated successfully!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Failed to generate UC. Please try again.';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Please fill in all required fields and select at least one expenditure.';
        $_SESSION['message_type'] = 'error';
    }
    
    header('Location: uc-generator.php');
    exit;
}

// If not a valid POST request, redirect to UC generator page
header('Location: uc-generator.php');
exit;
?>