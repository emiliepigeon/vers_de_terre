// public/script/modalshop.js

document.addEventListener('DOMContentLoaded', function() {
    // Vérifiez si les éléments existent avant de créer les modals
    var shopModalElement = document.getElementById('shopModal');
    var newsletterModalElement = document.getElementById('newsletterModal');
    
    var shopModal, newsletterModal;

    if (shopModalElement) {
        shopModal = new bootstrap.Modal(shopModalElement, {
            keyboard: false
        });
    }
    
    if (newsletterModalElement) {
        newsletterModal = new bootstrap.Modal(newsletterModalElement, {
            keyboard: false
        });
    }
    
    var modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');
    modalTriggers.forEach(function(trigger) {
        trigger.addEventListener('click', function(event) {
            event.preventDefault();
            var targetModal = this.getAttribute('data-bs-target');
            if (targetModal === '#shopModal' && shopModal) {
                shopModal.show();
            } else if (targetModal === '#newsletterModal' && newsletterModal) {
                newsletterModal.show();
            }
        });
    });
});
