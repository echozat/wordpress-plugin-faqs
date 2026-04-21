<?php

$wp_list_table = new faqs\FAQsListTable();

?>
<div class="wrap t201plugin">
    <h2>
    All FAQs    
    <a href="<?php print admin_url('admin.php?page=faqs-create-faqs'); ?>" class="add-new-h2">Create FAQ</a>
    </h2>

   
<?php
$wp_list_table->display();
?>

</div>