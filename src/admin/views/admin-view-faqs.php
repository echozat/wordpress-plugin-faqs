<?php
   $faqsid = null;

   if(isset($_GET['faqsid']))
   {
      $faqsid = $_GET['faqsid'];
   }
   else
   {
      if(function_exists('faqsRedirectTo'))
      {
         faqs\faqsRedirectTo('admin.php?page=faqs-all-faqs');
      }
      else
      {
         die('Do not have sufficient permission to access page.');
      }
   }

   $wp_list_table = new faqs\FAQsQuestionsListTable($faqsid);
   $wp_list_table->prepare_items();

   // get faqs details
   $FAQ = faqs\FAQsData::getFaqsDetail($faqsid);
?>
<div class="wrap t201plugin">
    <h2>
      <?php echo $FAQ->name; ?> | FAQ 
      <a href="<?php print admin_url('admin.php?page=faqs-add-question&faqsid='. $faqsid); ?>" class="add-new-h2">Add Question</a>
    </h2>   
<form method="get">
   <input type="hidden" name="page" value="faqs-view-faqs">
   <input type="hidden" name="faqsid" value="<?php echo (int) $faqsid; ?>">
   <?php $wp_list_table->search_box('Search Questions', 'faqs-questions-search'); ?>
   <?php $wp_list_table->display(); ?>
</form>

</div>