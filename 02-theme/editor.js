// Button block style variations
wp.blocks.registerBlockStyle('core/button', {
    name: 'secondary-cta',
    label: 'Secondary CTA',
    isDefault: true
});
wp.blocks.registerBlockStyle('core/button', {
    name: 'primary-cta',
    label: 'Primary CTA'
});
wp.blocks.registerBlockStyle('core/button', {
    name: 'dark-cta',
    label: 'Dark Blue CTA'
});
// Separator block style variations
wp.blocks.registerBlockStyle('core/separator', {
    name: 'blue',
    label: 'Blue'
});
wp.blocks.registerBlockStyle('core/separator', {
    name: 'gold',
    label: 'Gold'
});
wp.domReady( function() {
    // Remove Core blocks
    wp.blocks.unregisterBlockType( 'core/nextpage' ); // Pagebreak
    wp.blocks.unregisterBlockType( 'core/pullquote' );

    // Core Button: remove default styles
    wp.blocks.unregisterBlockStyle('core/button', 'default');
    wp.blocks.unregisterBlockStyle('core/button', 'fill');
    wp.blocks.unregisterBlockStyle('core/button', 'outline');
    wp.blocks.unregisterBlockStyle('core/button', 'squared');

    // Core Separator: remove default styles
    wp.blocks.unregisterBlockStyle('core/separator', 'wide');
    wp.blocks.unregisterBlockStyle('core/separator', 'dots');

    // Core Quote: remove default style
    wp.blocks.unregisterBlockStyle('core/quote', 'large');

    // Body Class: add Page Template body class if one is chosen
    jQuery(document).ready(function($) {
        var pageTemplateSelect = $(".editor-page-attributes__template select");
        // If there is a Page Template select (dropdown)
        if(typeof pageTemplateSelect.val() !== 'undefined') {
            var pageTemplate = pageTemplateSelect.val().substring(-4, pageTemplateSelect.val().length - 4);
            document.body.classList.add(pageTemplate);
            // listen for page template changes
            pageTemplateSelect.change(function() {
                // remove all previous template classes
                $(".editor-page-attributes__template select option").each(function() {
                    var oldTemplate = $(this).val().substring(-4, $(this).val().length - 4);
                    if($(document.body).hasClass(pageTemplate)) {
                        document.body.classList.remove(pageTemplate);
                    }
                });
                // add new template class
                pageTemplate = pageTemplateSelect.val().substring(-4, pageTemplateSelect.val().length - 4);
                if(pageTemplate.length > 1) {
                    document.body.classList.add(pageTemplate);
                }
            });
        }
    });
});