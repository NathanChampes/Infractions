function sortByMontant() {
    var table, rows, onChange, i, x, y, echange;
    table = document.querySelector('.formulaire');
    onChange = true;

    while (onChange) {
        onChange = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 2); i++) {
            echange = false;
            x = rows[i].getElementsByTagName('td')[5];
            y = rows[i + 1].getElementsByTagName('td')[5];

            var xValue = parseFloat(x.innerHTML.replace(' €', '').replace(',', '.'));
            var yValue = parseFloat(y.innerHTML.replace(' €', '').replace(',', '.'));

            if (xValue < yValue && !(document.getElementById('ordre').checked)) {
                echange = true;
                break;
            } else if (xValue > yValue && document.getElementById('ordre').checked) {
                echange = true;
                break;
            }
        }

        if (echange) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            onChange = true;
        }
    }
}
 