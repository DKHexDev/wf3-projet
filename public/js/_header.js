const btn_header = document.querySelector('.mobile-menu-button'); 
const menu_header = document.querySelector ('.mobile-menu');

btn_header.addEventListener("click",() => {
    menu_header.classList.toggle("hidden");
})


