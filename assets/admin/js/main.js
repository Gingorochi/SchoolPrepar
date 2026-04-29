// Main JavaScript pour l'admin SchoolPrepar

// Gestion de la sidebar mobile
document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar pour mobile
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('#miniSidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }
    
    // Fermer les alerts automatiquement
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 300);
        }, 5000);
    });
    
    // Confirmation pour les suppressions
    const deleteButtons = document.querySelectorAll('form[method="POST"] button[type="submit"]');
    deleteButtons.forEach(function(button) {
        if (button.textContent.includes('Supprimer') || button.textContent.includes('supprimer')) {
            button.addEventListener('click', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                    e.preventDefault();
                }
            });
        }
    });
    
    // Gestion des tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        tooltipTriggerEl.addEventListener('mouseenter', function() {
            this.style.cursor = 'help';
        });
    });
    
    // Animation des cards
    const cards = document.querySelectorAll('.card');
    cards.forEach(function(card) {
        card.classList.add('fade-in');
    });
    
    // Gestion des formulaires AJAX (optionnel)
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Chargement...';
                
                // Réactiver le bouton après 5 secondes au cas où
                setTimeout(function() {
                    submitButton.disabled = false;
                    submitButton.innerHTML = submitButton.getAttribute('data-original-text') || 'Enregistrer';
                }, 5000);
            }
        });
    });
    
    // Gestion des tables triables
    const tables = document.querySelectorAll('.table');
    tables.forEach(function(table) {
        const headers = table.querySelectorAll('th');
        headers.forEach(function(header, index) {
            if (header.textContent.includes('Actions') || header.textContent.includes('actions')) {
                return; // Ne pas trier la colonne actions
            }
            
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                sortTable(table, index);
            });
        });
    });
});

// Fonction pour trier les tables
function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort(function(a, b) {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        // Détection de type numérique
        const aNum = parseFloat(aText);
        const bNum = parseFloat(bText);
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return aNum - bNum;
        }
        
        // Comparaison de texte
        return aText.localeCompare(bText);
    });
    
    // Inversion du tri si déjà trié
    const isAsc = table.getAttribute('data-sort-order') === 'asc';
    if (isAsc) {
        rows.reverse();
        table.setAttribute('data-sort-order', 'desc');
    } else {
        table.setAttribute('data-sort-order', 'asc');
    }
    
    // Réinsertion des lignes triées
    rows.forEach(function(row) {
        tbody.appendChild(row);
    });
}

// Fonction pour afficher les notifications
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show`;
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    const container = document.querySelector('.main-content');
    if (container) {
        container.insertBefore(notification, container.firstChild);
        
        // Auto-suppression
        setTimeout(function() {
            notification.style.opacity = '0';
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 5000);
    }
}

// Fonction pour confirmer les actions
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Export des fonctions pour utilisation globale
window.adminUtils = {
    showNotification: showNotification,
    confirmAction: confirmAction,
    sortTable: sortTable
};
