// Filtrage des produits

// Remplacer la classe par la classe Tailwind adaptée
let filtreCase = document.querySelector('.form-check-input');


filtreCase.addEventListener('click', (event) => {

    // #filtres est l'id à placer sur le formalaire des filtres.
    // On récupère ici toutes les données du formulaires (les filtres à renvoyer au fichier php )
    const result = document.querySelector('#filtres');
    result = new FormData(result);

    // On lance la requête ajax :

    let request = new XMLHttpRequest();
    request.open('GET', '/api/recipes', true);

    // on envoie les données du form à la requête
    request.send(result);

});