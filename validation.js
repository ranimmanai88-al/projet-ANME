document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const engagementCheckbox = document.getElementById('engagement');
    const signatureCanvas = document.getElementById('signature-canvas');
    const signatureOutput = document.getElementById('signature-output');
    const signatureCtx = signatureCanvas.getContext('2d');

    function isValidDate(date) {
        const regex = /^\d{2}\/\d{2}\/\d{4}$/;
        return regex.test(date);
    }

    function validateForm(event) {
        let isValid = true;

        const typePrestataire = document.getElementById('function');
        if (!typePrestataire.value) {
            isValid = false;
            alert("Veuillez sélectionner un type de prestataire.");
        }

        const roleChecked = document.querySelector('input[name="role"]:checked');
        if (!roleChecked) {
            isValid = false;
            alert("Veuillez choisir un rôle.");
        }

        const genderChecked = document.querySelector('input[name="gender"]:checked');
        if (!genderChecked) {
            isValid = false;
            alert("Veuillez sélectionner votre genre.");
        }

        const textFields = ['firstName', 'lastName', 'email', 'phone', 'dob', 'raisonSocial', 'valeurcapital', 'adresseSiege', 'gouvernorat', 'delegation', 'telephone', 'telecopie', 'email_societe'];
        textFields.forEach(id => {
            const field = document.getElementById(id);
            if (field && !field.value.trim()) {
                isValid = false;
                alert(`${id} est requis.`);
            }
        });

        const dob = document.getElementById('dob').value;
        if (dob && !isValidDate(dob)) {
            isValid = false;
            alert("Veuillez entrer une date de naissance valide (format : jj/mm/aaaa).");
        }

        const dateCreation = document.getElementById('date_creation').value;
        if (dateCreation && !isValidDate(dateCreation)) {
            isValid = false;
            alert("Veuillez entrer une date de création valide (format : jj/mm/aaaa).");
        }

        if (signatureCtx.getImageData(0, 0, signatureCanvas.width, signatureCanvas.height).data.every(pixel => pixel === 255)) {
            isValid = false;
            alert("Veuillez dessiner une signature.");
        }

        if (!engagementCheckbox.checked) {
            isValid = false;
            alert("Vous devez accepter l'engagement.");
        }

        if (!isValid) {
            event.preventDefault();
        }
    }

    form.addEventListener('submit', validateForm);
});
