var tags = new Bloodhound({
    prefetch: '/tags/tags.json',
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
})

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

$(document).ready(function() {
    $('form[name="recipe"]').bind("keypress", function(e) {
        if (e.keyCode == 13) {
            return false;
        }
    });
});