document.querySelectorAll('.delete-link').forEach(function(link) {
    link.addEventListener('click', function(e) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cette infraction ?')) {
            e.preventDefault();
        }
    });
});