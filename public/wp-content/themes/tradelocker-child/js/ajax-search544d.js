jQuery(document).ready(function($) {
    $('.search-input').on('keyup', function(){
        var query = $(this).val();
        if (query.length < 3) {
            $('.search-suggestions').removeClass('active').empty();
            return;
        }
        // Add the active class to display the suggestions
        $('.search-suggestions').addClass('active');

        $.ajax({
            url: ajax_obj.ajaxurl,
            type: 'POST',
            data: {
                action: 'ajax_search_suggestions',
                term: query
            },
            success: function(response) {
                var suggestions = '';
                $.each(response, function(index, post) {
                    suggestions += `
                    <li>
                        <a href="${post.permalink}">
                        <div class="search-suggestion-icon"></div>
                        <div class="search-suggestion-body">
                            <div class="search-suggestion-title">${post.title}</div>
                            <div class="search-suggestion-description">
                                <span class="line-clamp-1">${post.category}</span>
                            </div>
                        </div>
                        </a>
                    </li>`;
                });
                $('.search-suggestions').html('<ul>' + suggestions + '</ul>');
            }
        });
    });

    // Hide suggestions when clicking anywhere outside the search input or suggestions block.
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-input, .search-suggestions').length) {
            $('.search-suggestions').removeClass('active').empty();
        }
    });

    // Hide suggestions when the Escape key is pressed.
    $(document).on('keydown', function(e) {
        if (e.key === "Escape") {
            $('.search-suggestions').removeClass('active').empty();
        }
    });
});
