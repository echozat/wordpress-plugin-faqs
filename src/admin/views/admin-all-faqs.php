<?php
$wp_list_table = new faqs\FAQsListTable();
$wp_list_table->prepare_items();

?>
<div class="wrap t201plugin">
    <h2>
    All FAQs    
    <a href="<?php print admin_url('admin.php?page=faqs-create-faqs'); ?>" class="add-new-h2">Create FAQ</a>
    </h2>

    <div id="message" class="updated below-h2 think201-wp-msg think201-wp-msg-success" style="display:none;">
        <p>FAQ deleted successfully.</p>
    </div>
    <div id="message" class="error below-h2 think201-wp-msg think201-wp-msg-error" style="display:none;">
        <p>Oops, there seems to be some issue.</p>
    </div>

    <form method="get">
        <input type="hidden" name="page" value="faqs-all-faqs">
        <?php $wp_list_table->search_box('Search FAQs', 'faqs-search'); ?>
        <?php $wp_list_table->display(); ?>
    </form>

</div>