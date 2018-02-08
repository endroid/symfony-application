$(document).ready(function() {
    $('#search').select2({
        placeholder: 'Search',
        ajax: {
            url: '/search/suggest',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    query: params.term
                }
            },
            processResults: function (data, params) {
                return {
                    results: data
                }
            }
        },
        cache: true,
        minimumInputLength: 1
    });
});
