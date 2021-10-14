const generateButton = document.querySelector('#generate');
const mailButton = document.querySelector('#mail');
const menu = document.querySelector('#menu');
const liste = document.querySelector('#divList');

let ingredientsList = [];

generateButton.addEventListener('click', generateList);
mailButton.addEventListener('click', sendMail);

$(document).click((event) =>{

    if(!$(event.target).closest('#listSquare').lenght){

        liste.classList.add('hidden');
    }
})

function generateList(){

    let id = [];
    let recipes = menu.querySelectorAll('.object');

    recipes.forEach(element => {
        
        id.push(element.id);
    });

    sendAjax(id);
}

function sendAjax(id){

    let obj = {"id" : id};

    $.ajax({
        type:'POST',
        url: '/api/recipes/list',
        data: obj
    })
    .then(function(response){

        $('#liste').html(' ');
        liste.classList.remove('hidden');
        response.forEach(ingredient => {

            ingredientsList.push(ingredient.name);
            $('#liste').append('<li>' + ingredient.name + '</li>');
        });
    });
}

function sendMail(){

    let mailObj = 
    {ingredients : ingredientsList,
    mail : 'evrard.ulrick.etc@gmail.com',
    
    };

    $.ajax({
        type: 'GET',
        url: '/recipe/email',
        data: mailObj
    });
}
