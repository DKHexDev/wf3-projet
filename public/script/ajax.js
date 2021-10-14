// Filtrage des produitsgetscript("dragNdrop.js", function(){
$(document).ready( setDragDrop );
let pageDiv = document.querySelector('#page');
let pageForm = document.querySelector('#pageForm');

let data = {'page' : 0};

document.querySelector('#prec').addEventListener('click', function(){

    if(data.page > 0){
        data.page--;
    }
    else 
    {
        document.querySelector('#prec').classList.add('hidden');
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

        const recipesFav = [];

        //filtres += '&'+ JSON.stringify(data);

        $.get('/api/recipes', filtres)
        .then(function (response){

            // Si l'utilisateur est connecté
            if (response.userLogin)
            {
                $.get('/api/user/favorites')
                .then(function (rep) {



                    $('#product-list').html(" ");

                    if(response[0].length >24){
                        
                        document.querySelector('#next').classList.remove('hidden');
                    }
                    else{
                        document.querySelector('#next').classList.add('hidden');
                    }

                    rep.forEach(recipeFav => {
                        recipesFav.push(recipeFav);
                    });


                    response[0].forEach(recipeF => {

                        let statusFav = "far";

                        recipesFav.forEach(recipeFav => {
                            if(recipeF["id"] == recipeFav.id)
                            {
                                statusFav = "fas";
                            }
                        })

                        let newrecipe = $('#product-list')
                        .append(`
                            <li id="${recipeF["id"]}" class="m-2 myDraggableElement object" draggable="true">
                                <article class="slide-in-right relative w-full h-full md:h-80 bg-white rounded-lg">
                                    <img class="w-full h-full object-cover rounded-lg" src="${recipeF["background"] != null ? "/upload/recipes/" + recipeF["background"] : "/assets_img/default_img.jpg"}" alt="${recipeF["name"]}">
            
                                    <span class="fav absolute top-0 z-20 mt-3 ml-3"><i data-recipe="${recipeF["id"]}" class="${statusFav} fa-star text-yellow-500 text-lg rounded-full p-2 bg-gray-600 border border-gray-500"></i></span>
            
                                    <button class="absolute top-0 right-0 z-20 cross hidden"><i class="text-xl absolute -top-1 -right-1 text-red-600 fas fa-times-circle"></i></button>

                                    <a href="/recipe/${recipeF['slug']}" class="absolute w-full h-full z-5 inset-0 bg-black text-center flex flex-col items-center justify-center opacity-0 hover:opacity-100 bg-opacity-50 duration-300 rounded-lg">
                                        <h1 class="tracking-wider font-extrabold text-xl text-yellow-500">${recipeF["name"]}</h1>
                                        <p class="mx-auto text-white">${recipeF["description"].substring(0, 80)}${recipeF["description"].length > 80 ? "..." : ""}</p>    
                                    </a>
                                </article>
                            </li>
                        `);
                    });

                    setDragDrop();
                    RefreshEventClickFavorites();
                });
            }
            // Si l'utilisateur n'est pas connecté
            else
            {
                $('#product-list').html(" ");

                if(response[0].length >24){
                    
                    document.querySelector('#next').classList.remove('hidden');
                }
                else{
                    document.querySelector('#next').classList.add('hidden');
                }

                response[0].forEach(recipeF => {
                    let newrecipe = $('#product-list')
                    .append(`
                        <li id="${recipeF["id"]}" class="m-2 myDraggableElement object" draggable="true">
                            <article class="slide-in-right relative w-full h-full md:h-80 bg-white rounded-lg">
                                <img class="w-full h-full object-cover rounded-lg" src="${recipeF["background"] != null ? "/upload/recipes/" + recipeF["background"] : "/assets_img/default_img.jpg"}" alt="${recipeF["name"]}">

                                <span class="fav absolute top-0 z-20 mt-3 ml-3"><i data-recipe="${recipeF["id"]}" class="far fa-star text-yellow-500 text-lg rounded-full p-2 bg-gray-600 border border-gray-500"></i></span>

                                <button class="absolute top-0 right-0 z-20 cross hidden"><i class="text-xl absolute -top-1 -right-1 text-red-600 fas fa-times-circle"></i></button>

                                <a href="/recipe/${recipeF['slug']}" class="absolute w-full h-full z-5 inset-0 bg-black text-center flex flex-col items-center justify-center opacity-0 hover:opacity-100 bg-opacity-50 duration-300 rounded-lg">
                                    <h1 class="tracking-wider font-extrabold text-xl text-yellow-500">${recipeF["name"]}</h1>
                                    <p class="mx-auto text-white">${recipeF["description"].substring(0, 80)}${recipeF["description"].length > 80 ? "..." : ""}</p>    
                                </a>
                            </article>
                        </li>
                    `);
                });

                setDragDrop();
                RefreshEventClickFavorites();
            }

        });
    
}

$('#searchBar').keydown(function (){

    let searchTerms = { 'searchTerms' : $('#search').val() };

    $.get('/api/recipes/search', searchTerms)
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


