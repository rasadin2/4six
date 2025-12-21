/**
 * Blog Cards - Load More Functionality
 */
(function($) {
    'use strict';

    /**
     * Load More Button Handler
     */
    function initLoadMore() {
        $('.loadmore-btn').on('click', function(e) {
            e.preventDefault();

            var $button = $(this);
            var $grid = $('#' + $button.data('target'));
            var currentPage = parseInt($grid.data('page'), 10);
            var maxPages = parseInt($button.data('max-pages'), 10);
            var perPage = parseInt($grid.data('perpage'), 10);
            var category = $grid.data('category');
            var order = $grid.data('order');
            var orderby = $grid.data('orderby');

            // Check if we can load more
            if (currentPage >= maxPages) {
                return;
            }

            // Show loading state
            $button.addClass('loading');
            $button.find('.loadmore-text').hide();
            $button.find('.loadmore-loader').show();
            $button.prop('disabled', true);

            // AJAX request
            $.ajax({
                url: foursixBlogCards.ajax_url,
                type: 'POST',
                data: {
                    action: 'foursix_load_more',
                    nonce: foursixBlogCards.nonce,
                    page: currentPage + 1,
                    perpage: perPage,
                    category: category,
                    order: order,
                    orderby: orderby
                },
                success: function(response) {
                    if (response.success && response.html) {
                        // Append new cards with animation
                        var $newCards = $(response.html);
                        $newCards.hide();
                        $grid.append($newCards);

                        // Fade in new cards with stagger
                        $newCards.each(function(index) {
                            var $card = $(this);
                            setTimeout(function() {
                                $card.fadeIn(400);
                            }, index * 100);
                        });

                        // Update page number
                        $grid.data('page', response.current_page);

                        // Update counter
                        var $loadmoreSection = $button.closest('.blog-cards-loadmore');
                        var loadedCount = Math.min(response.loaded_count, response.total_posts);
                        $loadmoreSection.find('.current-count').text(loadedCount);

                        // Hide button if no more posts
                        if (!response.has_more) {
                            $button.fadeOut(300, function() {
                                $loadmoreSection.find('.loadmore-status').html(
                                    '<span style="color: #10b981;">All articles loaded ✓</span>'
                                );
                            });
                        }
                    } else {
                        // Show error
                        showError($button, 'Failed to load more posts');
                    }
                },
                error: function() {
                    // Show error
                    showError($button, 'Connection error. Please try again.');
                },
                complete: function() {
                    // Reset button state
                    $button.removeClass('loading');
                    $button.find('.loadmore-text').show();
                    $button.find('.loadmore-loader').hide();
                    $button.prop('disabled', false);
                }
            });
        });
    }

    /**
     * Show Error Message
     */
    function showError($button, message) {
        var $error = $('<div class="loadmore-error">' + message + '</div>');
        $button.after($error);

        setTimeout(function() {
            $error.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }

    /**
     * Animate Cards on Scroll (Optional)
     */
    function initScrollAnimation() {
        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            // Observe all cards
            document.querySelectorAll('.blog-card').forEach(function(card) {
                observer.observe(card);
            });
        }
    }

    /**
     * Smooth Scroll to New Content (Optional)
     */
    function smoothScrollToNewContent($grid) {
        var lastCardOffset = $grid.find('.blog-card:last').offset().top;
        var scrollOffset = lastCardOffset - 100; // 100px offset from top

        $('html, body').animate({
            scrollTop: scrollOffset
        }, 600, 'swing');
    }

    /**
     * Initialize on Document Ready
     */
    $(document).ready(function() {
        initLoadMore();
        initScrollAnimation();

        // Re-initialize on AJAX complete for dynamic content
        $(document).ajaxComplete(function() {
            initScrollAnimation();
        });
    });

})(jQuery);
