<?php
// functions.php - Application functions
require_once 'db.php';

// Expenditure functions
function addExpenditure($item_name, $amount, $date, $category) {
    $db = new Database();
    $db->query("INSERT INTO expenditures (item_name, amount, date, category) VALUES (:item_name, :amount, :date, :category)");
    $db->bind(':item_name', $item_name);
    $db->bind(':amount', $amount);
    $db->bind(':date', $date);
    $db->bind(':category', $category);
    
    return $db->execute();
}

function getExpenditures() {
    $db = new Database();
    $db->query("SELECT * FROM expenditures ORDER BY date DESC");
    return $db->resultSet();
}

function getExpenditureById($id) {
    $db = new Database();
    $db->query("SELECT * FROM expenditures WHERE id = :id");
    $db->bind(':id', $id);
    return $db->single();
}

function updateExpenditure($id, $item_name, $amount, $date, $category) {
    $db = new Database();
    $db->query("UPDATE expenditures SET item_name = :item_name, amount = :amount, date = :date, category = :category WHERE id = :id");
    $db->bind(':id', $id);
    $db->bind(':item_name', $item_name);
    $db->bind(':amount', $amount);
    $db->bind(':date', $date);
    $db->bind(':category', $category);
    
    return $db->execute();
}

function deleteExpenditure($id) {
    $db = new Database();
    $db->query("DELETE FROM expenditures WHERE id = :id");
    $db->bind(':id', $id);
    
    return $db->execute();
}

// UC functions
function createUC($title, $description, $expenditure_ids) {
    $db = new Database();
    $db->query("INSERT INTO utilisation_certificates (title, description, created_at) VALUES (:title, :description, NOW())");
    $db->bind(':title', $title);
    $db->bind(':description', $description);
    
    if ($db->execute()) {
        $uc_id = $db->dbh->lastInsertId();
        
        // Link expenditures to UC
        foreach ($expenditure_ids as $exp_id) {
            $db->query("INSERT INTO uc_expenditures (uc_id, expenditure_id) VALUES (:uc_id, :expenditure_id)");
            $db->bind(':uc_id', $uc_id);
            $db->bind(':expenditure_id', $exp_id);
            $db->execute();
        }
        
        return $uc_id;
    }
    
    return false;
}

function getUCs() {
    $db = new Database();
    $db->query("SELECT * FROM utilisation_certificates ORDER BY created_at DESC");
    return $db->resultSet();
}

function getUCById($id) {
    $db = new Database();
    $db->query("SELECT * FROM utilisation_certificates WHERE id = :id");
    $db->bind(':id', $id);
    return $db->single();
}

// Dashboard functions
function getTotalExpenditure() {
    $db = new Database();
    $db->query("SELECT SUM(amount) as total FROM expenditures");
    $result = $db->single();
    return $result['total'] ?? 0;
}

function getPendingUCs() {
    // In a real implementation, this would count UCs that are not yet approved
    return 0;
}

function getCompletedUCs() {
    $db = new Database();
    $db->query("SELECT COUNT(*) as count FROM utilisation_certificates");
    $result = $db->single();
    return $result['count'] ?? 0;
}

function getExpenditureSummary() {
    $db = new Database();
    $db->query("SELECT category, SUM(amount) as total FROM expenditures GROUP BY category");
    $results = $db->resultSet();
    
    $total = getTotalExpenditure();
    $summary = [];
    
    foreach ($results as $result) {
        $percentage = $total > 0 ? round(($result['total'] / $total) * 100, 2) : 0;
        $summary[] = [
            'category' => $result['category'],
            'total' => $result['total'],
            'percentage' => $percentage
        ];
    }
    
    return $summary;
}
?>