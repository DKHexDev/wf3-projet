// Ajout ou suppression des recettes en favoris.

$('.liked').click(function (){

    let ThumbLike = $(this);
    let FlashMessage = $('#FlashMessage');

    let CounterLiked = ThumbLike.parent().find('button');
    let CounterContentLiked = CounterLiked.contents()[0].nodeValue;
    let CounterIntLiked = parseInt(CounterContentLiked);

    if(ThumbLike.hasClass("far"))
    {
        $.get('http://localhost:8000/recipe/messages/likes/' + ThumbLike.attr('data-message') + '/add')
        .then(function (response){

            FlashMessage.removeClass("container");
            FlashMessage.html(`
                <div class="bg-${response.color}-100 border-l-4 border-${response.color}-500 text-${response.color}-700 p-4 fixed w-full" role="alert">
                    <p class="font-bold">Information</p>
                    <p>${response.message}</p>
                </div>
            `);

            CounterLiked.addClass('hidden');
            CounterLiked.html(CounterIntLiked + 1);

            setTimeout(() => {
                CounterLiked.removeClass('hidden');
            }, 100)

            if (response.changeClass)
            {
                ThumbLike.removeClass("far");
                ThumbLike.addClass("fas");
                ListAllUserModal = $(`div#alluser`).html()
                $(`div#alluser`).html(`
                    ${ListAllUserModal}

                    <div id="user${response.userPseudo}" class="flex flex-row gap-2 border border-gray-300 shadow-lg items-center w-full p-4">
                        <img class="object-cover rounded-full h-12 self-start" src="/upload/users/${response.userAvatar}" alt="Avatar de ${response.userPseudo}">
                        <span class="text-2xl">${response.userPseudo} a aimé</span>
                    </div>
                `)
            }

            setTimeout(() => {
                FlashMessage.addClass("container");
                FlashMessage.html(``);
            }, 5000)
            
        });
    };

    if (ThumbLike.hasClass("fas"))
    {
        $.get('http://localhost:8000/recipe/messages/likes/' + ThumbLike.attr('data-message') + '/remove')
        .then(function (response){
    
            FlashMessage.removeClass("container");
            FlashMessage.html(`
                <div class="bg-${response.color}-100 border-l-4 border-${response.color}-500 text-${response.color}-700 p-4 fixed w-full" role="alert">
                    <p class="font-bold">Information</p>
                    <p>${response.message}</p>
                </div>
            `);

            CounterLiked.addClass('hidden');
            CounterLiked.html(CounterIntLiked - 1);

            setTimeout(() => {
                CounterLiked.removeClass('hidden');
            }, 100)

            if(response.changeClass)
            {
                ThumbLike.removeClass("fas");
                ThumbLike.addClass("far");
                $(`#${response.messageID}`).find(`div#user${response.userPseudo}`).remove();
            }
    
            setTimeout(() => {
                FlashMessage.addClass("container");
                FlashMessage.html(``);
            }, 5000)
            
        });
    };
    
});

