// Filtrage des produits



$('.check').change(function (){

    // On récupère les valeurs du formulaire 'filtres'
    let filtres = $('#filtres').serialize();

    $.get('http://localhost:8000/api/recipes/', filtres)
    .then(function (response){

        $('#product-list').html(response);
    });

})