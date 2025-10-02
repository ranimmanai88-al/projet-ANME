document.addEventListener("DOMContentLoaded", () => {
    // Gestion de la sélection pour le fichier RNE
    const wrapperRNE = document.querySelector(".wrapper"),
          fileInputRNE = wrapperRNE.querySelector(".file-input"),
          fileNameRNE = wrapperRNE.querySelector(".file-name"),
          filePreviewRNE = wrapperRNE.querySelector(".file-preview");

    wrapperRNE.addEventListener("click", () => {
        fileInputRNE.click();
    });

    fileInputRNE.addEventListener("change", ({ target }) => {
        const file = target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                filePreviewRNE.src = e.target.result;
                filePreviewRNE.style.display = "block"; 
            };

            reader.readAsDataURL(file); 
            fileNameRNE.textContent = `Fichier sélectionné : ${file.name}`;
        } else {
            fileNameRNE.textContent = "Aucun fichier sélectionné";
            filePreviewRNE.style.display = "none"; 
        }
    });

 

    const wrapperCarte = document.querySelector(".wrapper-carte"),
          fileInputCarte = wrapperCarte.querySelector(".file-input-carte"),
          fileNameCarte = wrapperCarte.querySelector(".file-name-carte"),
          filePreviewCarte = wrapperCarte.querySelector(".file-preview-carte");

    wrapperCarte.addEventListener("click", () => {
        fileInputCarte.click();
    });

    fileInputCarte.addEventListener("change", ({ target }) => {
        const file = target.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                filePreviewCarte.src = e.target.result;
                filePreviewCarte.style.display = "block"; 
            };

            reader.readAsDataURL(file); 
            fileNameCarte.textContent = `Fichier sélectionné : ${file.name}`;
        } else {
            fileNameCarte.textContent = "Aucun fichier sélectionné";
            filePreviewCarte.style.display = "none"; 
        }
    });
});
