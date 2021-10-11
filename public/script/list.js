const generateButton = document.querySelector('#generate');
const menu = document.querySelector('#menu');
const liste = document.querySelector('#divListe');

generateButton.addEventListener('click', generateList);

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
        url: 'http://localhost:8000/api/recipes/list',
        data: obj
    })
    .then(function(response){
        $('#liste').html(' ');
        liste.classList.remove('hidden');
        response.forEach(ingredient => {

            $('#liste').append('<li>' + ingredient.name + '</li>');
        });
    });
}