// Filtrage des produitsgetscript("dragNdrop.js", function(){
$(document).ready( setDragDrop );
let pageDiv = document.querySelector('#page');
let pageForm = document.querySelector('#pageForm');

let data = {'page' : 0};

document.querySelector('#prec').addEventListener('click', function(){

    if(data.page > 0){
        data.page--;
    }
    pageForm.setAttribute('value', data.page);
    console.log(data.page);

    ajax();
})

document.querySelector('#next').addEventListener('click', function(){

        data.page++;

        pageForm.setAttribute('value', data.page);

        console.log(data.page);
        document.querySelector('#prec').classList.remove('hidden');

        ajax();
})

$('.check').change(ajax)

function ajax(){

        // On récupère les valeurs du formulaire 'filtres'
        let filtres = $('#filtres').serialize();

        //filtres += '&'+ JSON.stringify(data);
        console.log(filtres)

        $.get('http://localhost:8000/api/recipes/', filtres)
        .then(function (response){

            

            $('#product-list').html(" ");

            console.log(response);

            if(response.length >24){
                
                document.querySelector('#next').classList.remove('hidden');
            }
            else{
                document.querySelector('#next').classList.add('hidden');
            }

            response.forEach(recipeF => {
                let newrecipe = $('#product-list')
                .append(
                
                '<div id = '+ recipeF["id"] +' class="m-2 myDraggableElement object" draggable="true">'+
                '<li class="flex flex-col border-2 border-gray-400 rounded shadow-lg rounded-lg text-center h-full p-4 m-2 recipe">'+
                recipeF['name']+
                '<a href="'+ recipeF['slug'] +'" >Voir</a>'+
                '</li>'+
                '</div>');
            });

            setDragDrop();

        });
    
}

$('#searchBar').keydown(function (){

    let searchTerms = { 'searchTerms' : $('#search').val() };

    $.get('http://localhost:8000/api/recipes/search', searchTerms)
    .then(function(response){

        $('#resultList').html(' ');
        response.forEach(item =>{

            $('#resultList').append('<li'+
            ' class="shadow p-2 bg-white ">'+
            '<a href="/recipe/'+ item['slug'] +'">'+item['name']+
            '</li>'+
            '<hr>');
        });
    })
})


