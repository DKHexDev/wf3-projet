// Ajout ou suppression des recettes en favoris.

$('.far').click(function (){

    let StarFav = $(this);
    let FlashMessage = $('#FlashMessage');

    $.get('http://localhost:8000/account/favorites/' + StarFav.attr('data-recipe') + '/add')
    .then(function (response){

        FlashMessage.removeClass("container");
        FlashMessage.html(`
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 fixed w-full" role="alert">
                <p class="font-bold">Information</p>
                <p>${response}</p>
            </div>
        `);
        StarFav.removeClass("far");
        StarFav.addClass("fas");

        setTimeout(() => {
            FlashMessage.addClass("container");
            FlashMessage.html(``);
        }, 5000)
        
    });
});

$('.fas').click(function (){

    let StarFav = $(this);
    let FlashMessage = $('#FlashMessage');

    $.get('http://localhost:8000/account/favorites/' + StarFav.attr('data-recipe') + '/remove')
    .then(function (response){

        FlashMessage.removeClass("container");
        FlashMessage.html(`
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 fixed w-full" role="alert">
                <p class="font-bold">Information</p>
                <p>${response}</p>
            </div>
        `);
        StarFav.removeClass("fas");
        StarFav.addClass("far");

        setTimeout(() => {
            FlashMessage.addClass("container");
            FlashMessage.html(``);
        }, 5000)
        
    });
});

