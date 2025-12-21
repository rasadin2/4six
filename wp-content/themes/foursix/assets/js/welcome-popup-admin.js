/**
 * Welcome Popup Admin Scripts
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        // Initialize color pickers
        if ($.fn.wpColorPicker) {
            $('.color-picker').wpColorPicker();
        }

        // Feature Repeater: Add new feature row
        var featureIndex = $('#popup-features-repeater .feature-repeater-row').length;

        $('#add-feature-row').on('click', function() {
            var template = getFeatureRowTemplate(featureIndex);
            $('#popup-features-repeater').append(template);
            featureIndex++;
            updateFeatureNumbers();
        });

        // Feature Repeater: Remove feature row
        $(document).on('click', '.remove-feature-row', function() {
            if ($('.feature-repeater-row').length > 1) {
                $(this).closest('.feature-repeater-row').fadeOut(300, function() {
                    $(this).remove();
                    updateFeatureNumbers();
                });
            } else {
                alert('You must have at least one feature.');
            }
        });

        // Feature Repeater: Icon selection
        $(document).on('change', '.icon-selection input[type="radio"]', function() {
            var row = $(this).closest('.feature-repeater-row');
            var iconType = $(this).data('icon-type');
            row.find('.icon-type-field').val(iconType);
        });

        // Feature Repeater Template
        function getFeatureRowTemplate(index) {
            var html = '<div class="feature-repeater-row" data-index="' + index + '">';
            html += '<div class="feature-row-header">';
            html += '<span class="dashicons dashicons-move drag-handle"></span>';
            html += '<strong>Feature #' + (index + 1) + '</strong>';
            html += '<button type="button" class="button remove-feature-row">Remove</button>';
            html += '</div>';
            html += '<div class="feature-row-content">';

            // Title field
            html += '<div class="feature-field">';
            html += '<label>Title</label>';
            html += '<input type="text" name="foursix_popup_features[' + index + '][title]" value="" class="regular-text" placeholder="Feature title">';
            html += '</div>';

            // Subtitle field
            html += '<div class="feature-field">';
            html += '<label>Subtitle</label>';
            html += '<input type="text" name="foursix_popup_features[' + index + '][subtitle]" value="" class="regular-text" placeholder="Feature subtitle">';
            html += '</div>';

            // Icon field
            html += '<div class="feature-field">';
            html += '<label>Icon</label>';
            html += '<div class="icon-selection">';
            html += '<div class="icon-options">';
            html += '<label class="icon-option"><input type="radio" name="foursix_popup_features[' + index + '][icon_value]" value="gift" data-icon-type="predefined" checked><span class="icon-preview icon-gift">Gift (Deposit/Bonus)</span></label>';
            html += '<label class="icon-option"><input type="radio" name="foursix_popup_features[' + index + '][icon_value]" value="star" data-icon-type="predefined"><span class="icon-preview icon-star">Star (Free Spins/Special)</span></label>';
            html += '<label class="icon-option"><input type="radio" name="foursix_popup_features[' + index + '][icon_value]" value="chart" data-icon-type="predefined"><span class="icon-preview icon-chart">Chart (Cashback/Growth)</span></label>';
            html += '<label class="icon-option"><input type="radio" name="foursix_popup_features[' + index + '][icon_value]" value="trophy" data-icon-type="predefined"><span class="icon-preview icon-trophy">Trophy (Achievement)</span></label>';
            html += '<label class="icon-option"><input type="radio" name="foursix_popup_features[' + index + '][icon_value]" value="coins" data-icon-type="predefined"><span class="icon-preview icon-coins">Coins (Money/Rewards)</span></label>';
            html += '</div>';
            html += '<input type="hidden" name="foursix_popup_features[' + index + '][icon_type]" value="predefined" class="icon-type-field">';
            html += '</div>';
            html += '</div>';

            html += '</div>';
            html += '</div>';

            return html;
        }

        // Update feature numbers
        function updateFeatureNumbers() {
            $('.feature-repeater-row').each(function(index) {
                $(this).attr('data-index', index);
                $(this).find('.feature-row-header strong').text('Feature #' + (index + 1));
            });
        }

        // Media uploader functionality (for future use with coin images)
        var mediaUploader;

        $('.upload-image-button').on('click', function(e) {
            e.preventDefault();

            var button = $(this);
            var targetInput = button.data('target');

            // If the uploader object has already been created, reopen the dialog
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            // Create the media uploader
            mediaUploader = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });

            // When an image is selected, run a callback
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#' + targetInput).val(attachment.id);
                $('#' + targetInput + '_preview').attr('src', attachment.url);
            });

            // Open the uploader dialog
            mediaUploader.open();
        });

        // Remove image button
        $('.remove-image-button').on('click', function(e) {
            e.preventDefault();

            var button = $(this);
            var targetInput = button.data('target');

            $('#' + targetInput).val('');
            $('#' + targetInput + '_preview').attr('src', '');
        });
    });

})(jQuery);
