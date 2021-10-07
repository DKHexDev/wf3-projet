// Filtrage des produitsgetscript("dragNdrop.js", function(){
$(document).ready( setDragDrop );

$('.check').change(function (){

        // On récupère les valeurs du formulaire 'filtres'
        let filtres = $('#filtres').serialize();

    
        $.get('http://localhost:8000/api/recipes/', filtres)
        .then(function (response){

            $('#product-list').html(" ");
            //console.log(response);

            response.forEach(recipeF => {
                let newrecipe = $('#product-list')
                .append(' <div id="'+ recipeF['id'] +'" class="myDraggableElement object" draggable="true"><li class="flex flex-col flex-space bg-gray-200 rounded-lg p-4 m-2 recipe">' +
                recipeF['name']  +
                ','+
                recipeF['description']+
                '</li> </div>'); 
            });
            setDragDrop();

        });
    
    })


