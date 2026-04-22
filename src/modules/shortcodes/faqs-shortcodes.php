<?php

// Shortcode to render the FAQs plugin accordion.
add_shortcode('faqs_accordion', function () {
    if (! function_exists('faqs_getAll')) {
        return '';
    }
    ob_start();
    faqs_getAll(1, ['accordion' => true]);
    return ob_get_clean();
});
