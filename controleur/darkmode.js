if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
}

document.getElementById('toggle-dark-mode').addEventListener('click', function() {
    const body = document.body;
    body.classList.toggle('dark-mode');

    const isDarkMode = body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode);

    this.textContent = isDarkMode ? '🌞' : '🌙';
});

window.onload = function() {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    document.body.classList.toggle('dark-mode', isDarkMode);

    const button = document.getElementById('toggle-dark-mode');
    button.textContent = isDarkMode ? '🌞' : '🌙';
};