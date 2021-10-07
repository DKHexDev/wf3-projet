const generateButton = document.querySelector('#generate');
const menu = document.querySelector('#menu');


generateButton.addEventListener('click', generateList);

function generateList(){

    let id = [];
    let recipes = menu.querySelectorAll('.object');

    recipes.forEach(element => {
        
        id.push(element.id);
    });

}

function sendAjax(){

    let request = new XMLHttpRequest();
    request.open('POST', '/api/recipe/list', true);
    request.setRequestHeader('Content-Type', 'application/x')
}