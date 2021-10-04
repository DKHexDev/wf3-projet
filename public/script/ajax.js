// Filtrage des produits



$('.check').change(function (){

        // On récupère les valeurs du formulaire 'filtres'
        let filtres = $('#filtres').serialize();
    
        $.get('http://localhost:8000/api/recipes/', filtres)
        .then(function (response){

            $('#product-list').html(" ");
            console.log(response);

            response.forEach(recipe => {

                let newrecipe = $('#product-list')
                .append('<li>'+'<div class="flex flex-col flex-space bg-gray-200 rounded-lg p-4 m-2 recipe">' +
                recipe['name']  +
                ','             +
                recipe['season']+
                '</div> </li>');
            });

        });
    
    })


