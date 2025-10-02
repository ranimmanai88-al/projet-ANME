document.addEventListener('DOMContentLoaded', () => {
    const selectDrop = document.querySelector('#countries');

    if (!selectDrop) {
        console.error("Élément select '#countries' non trouvé !");
        return;
    }

    fetch('https://restcountries.com/v3.1/all')
        .then(res => {
            if (!res.ok) {
                throw new Error(`Erreur HTTP: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            let output = "";

            data.sort((a, b) => {
                const nameA = a.name.common || a.name.official;
                const nameB = b.name.common || b.name.official;
                return nameA.localeCompare(nameB);
            });

            data.forEach(country => {
                const countryName = country.name.common || country.name.official;
                output += `<option value="${countryName}">${countryName}</option>`;
            });

            output = `<option value="" disabled selected>Choisir une nationalité</option>${output}`;

            selectDrop.innerHTML = output;
        })
        .catch(err => {
            console.error('Erreur API:', err);
            selectDrop.innerHTML = `<option value="" disabled selected>Erreur de chargement des pays</option>`;
        });
});