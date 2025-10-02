document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('signature-canvas');
    if (!canvas) {
        console.error("Canvas non trouvé !");
        return;
    }

    const context = canvas.getContext('2d');
    if (!context) {
        console.error("Contexte 2D non supporté !");
        return;
    }

    let drawing = false;

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);

    const clearButton = document.getElementById('clearButton');
    const downloadButton = document.getElementById('downloadButton');

    if (clearButton) {
        clearButton.addEventListener('click', clearSignature);
    } else {
        console.error("Bouton 'Effacer' non trouvé !");
    }

    if (downloadButton) {
        downloadButton.addEventListener('click', handleDownload);
    } else {
        console.error("Bouton 'Télécharger' non trouvé !");
    }

    function startDrawing(e) {
        drawing = true;
        draw(e);
    }

    function draw(e) {
        if (!drawing) return;

        context.lineWidth = 2;
        context.lineCap = 'round';
        context.strokeStyle = 'black';

        context.lineTo(e.offsetX, e.offsetY);
        context.stroke();
        context.beginPath();
        context.moveTo(e.offsetX, e.offsetY);
    }

    function stopDrawing() {
        drawing = false;
        context.beginPath();
    }

    function clearSignature() {
        context.clearRect(0, 0, canvas.width, canvas.height);
    }

    function handleDownload() {
        // Convertir le canvas en image (base64)
        const dataUrl = canvas.toDataURL();

          document.getElementById('signature-output').value=dataUrl;
         
    }

    function saveSignatureToDatabase(imageUrl) {
        // Envoyer une requête POST au serveur
        fetch('votre-endpoint-api', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ imageUrl }), // Envoyer l'URL de l'image
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors de l\'enregistrement de la signature');
                }
                return response.json();
            })
            .then(data => {
                console.log('Signature enregistrée avec succès:', data);
                alert('Signature enregistrée avec succès !');
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'enregistrement de la signature');
            });
    }
});