// script.js - Client-side JavaScript for the application

// Function to confirm deletion
function confirmDelete(message) {
    return confirm(message || 'Are you sure you want to delete this item?');
}

// Function to export reports (placeholder)
function exportReport(format) {
    alert('In a full implementation, this would export the report as ' + format.toUpperCase());
}

// Function to download UC (placeholder)
function downloadUC() {
    alert('In a full implementation, this would download the UC as a PDF');
}

// Add event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add confirmation to delete links
    const deleteLinks = document.querySelectorAll('a[href*="action=delete"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirmDelete('Are you sure you want to delete this expenditure?')) {
                e.preventDefault();
            }
        });
    });
    
    // Add functionality to download UC button
    const downloadBtn = document.getElementById('download-uc');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', downloadUC);
    }
    
    // Add date picker enhancements if needed
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        // Set default value to today if empty
        if (!input.value) {
            const today = new Date().toISOString().split('T')[0];
            input.value = today;
        }
    });
});