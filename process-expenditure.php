<?php
// process-expenditure.php - Process expenditure form submissions
session_start();
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_expenditure'])) {
    // Add new expenditure
    $item_name = trim($_POST['item_name']);
    $amount = floatval($_POST['amount']);
    $date = $_POST['date'];
    $category = $_POST['category'];
    
    if (!empty($item_name) && $amount > 0 && !empty($date) && !empty($category)) {
        if (addExpenditure($item_name, $amount, $date, $category)) {
            $_SESSION['message'] = 'Expenditure added successfully!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Failed to add expenditure. Please try again.';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Please fill in all required fields correctly.';
        $_SESSION['message_type'] = 'error';
    }
    
    header('Location: expenditure.php');
    exit;
}

// Handle edit action
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $expenditure = getExpenditureById($id);
    
    if ($expenditure) {
        // In a real implementation, we would show an edit form
        // For now, we'll just redirect back
        $_SESSION['message'] = 'Edit functionality would be implemented here.';
        $_SESSION['message_type'] = 'info';
    } else {
        $_SESSION['message'] = 'Expenditure not found.';
        $_SESSION['message_type'] = 'error';
    }
    
    header('Location: expenditure.php');
    exit;
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    if (deleteExpenditure($id)) {
        $_SESSION['message'] = 'Expenditure deleted successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Failed to delete expenditure. Please try again.';
        $_SESSION['message_type'] = 'error';
    }
    
    header('Location: expenditure.php');
    exit;
}

// If no valid action, redirect to expenditure page
header('Location: expenditure.php');
exit;
?>