// Ajout ou suppression des recettes en favoris.

$('.fav').click(function (){

    let StarFav = $(this);
    let FlashMessage = $('#FlashMessage');

    if(StarFav.children().hasClass("far"))
    {
        $.get('http://localhost:8000/account/favorites/' + StarFav.children().attr('data-recipe') + '/add')
        .then(function (response){

            FlashMessage.removeClass("container");
            FlashMessage.html(`
                <div class="bg-${response.color}-100 border-l-4 border-${response.color}-500 text-${response.color}-700 p-4 fixed top-0 z-50 w-full" role="alert">
                    <p class="font-bold">Information</p>
                    <p>${response.message}</p>
                </div>
            `);

            if (response.changeClass)
            {
                StarFav.children().removeClass("far");
                StarFav.children().addClass("fas");
            }

            setTimeout(() => {
                FlashMessage.addClass("container");
                FlashMessage.html(``);
            }, 5000)
            
        });
    };

    if (StarFav.children().hasClass("fas"))
    {
        $.get('http://localhost:8000/account/favorites/' + StarFav.children().attr('data-recipe') + '/remove')
        .then(function (response){
    
            FlashMessage.removeClass("container");
            FlashMessage.html(`
                <div class="bg-${response.color}-100 border-l-4 border-${response.color}-500 text-${response.color}-700 p-4 fixed z-50 top-0 w-full" role="alert">
                    <p class="font-bold">Information</p>
                    <p>${response.message}</p>
                </div>
            `);

            if(response.changeClass)
            {
                StarFav.children().removeClass("fas");
                StarFav.children().addClass("far");
            }
    
            setTimeout(() => {
                FlashMessage.addClass("container");
                FlashMessage.html(``);
            }, 5000)
            
        });
    };
    
});

