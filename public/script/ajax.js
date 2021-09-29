// Filtrage des produits

// Remplacer la classe par la classe Tailwind adaptée
const filtreCase = document.querySelector('.form-check-input');
let request = new XMLHttpRequest();

filtreCase.addEventListener('click', (event) => {

    // #filtres est l'id à placer sur le formalaire des filtres.
    // On récupère ici toutes les données du formulaires (les filtres à renvoyer au fichier php )
    let result = document.querySelector('#filtres');
    result = new FormData(result);
    console.log(result);

    // On lance la requête ajax :

    request.open('POST', '/api/recipes', true);

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    
    request.send(result);

})