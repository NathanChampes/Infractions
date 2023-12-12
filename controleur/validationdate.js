window.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('date').addEventListener('change', function() {
        const dateInfraction = new Date(this.value);
        const dateDuJour = new Date();

        if (dateInfraction > dateDuJour) {
            alert('La date ne peut pas être supérieure à la date du jour.');
            this.value = dateDuJour.toISOString().split('T')[0];
        }
    });
});