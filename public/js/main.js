// Tous les tags déjà enregistré par d'autres recettes, à partir de l'API JSON.
var tags = new Bloodhound({
    prefetch: '/tags/tags.json',
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
})


// Transforme l'input de base en input de tags pour le formulaire des recettes.
$('.tag-input').tagsinput({
    typeaheadjs: [{
        highlights: true
    },
    {
    name: 'tags',
    display: 'name',
    value: 'name',
    source: tags
    }]
});


// Désactiver la touche entrée pour valider le formulaire (pour les formulaires des recettes)
// Pour ajouter simplement les tags grace à la touche entrer.
$(document).ready(function() {
    $('form[name="recipe"]').bind("keypress", function(e) {
        if (e.keyCode == 13) {
            return false;
        }
    });
});

// Popup de confirmation
function toggleModal(modalID){
    document.getElementById(modalID).classList.toggle("hidden");
    document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
    document.getElementById(modalID).classList.toggle("flex");
    document.getElementById(modalID + "-backdrop").classList.toggle("flex");
}