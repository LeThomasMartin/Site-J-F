// ============================================
// Escalier Monte au Bois - Custom JavaScript
// ============================================
// Note: Menu functionality is handled by NicePage.js
// with u-menu and u-nav classes.
// This file is reserved for future custom functionality.

document.addEventListener('DOMContentLoaded', () => {
    addFooter();
});


function addFooter() {
    fetch("footer.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("footer").innerHTML = data;
        })
        .catch(error => console.error('Error loading footer:', error));
}