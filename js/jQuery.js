$(document).ready(function() {
    $('#search-item').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();  

        $('.product-list .product').each(function() {
            var itemName = $(this).data('name');  

            if (searchTerm === "" || itemName.indexOf(searchTerm) > -1) {
                $(this).show();  
            } else {
                $(this).hide();  
            }
        });
    });
});

