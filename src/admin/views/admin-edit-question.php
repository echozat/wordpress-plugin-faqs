<?php
   if(isset($_GET['page']) && isset($_GET['faqsid']))
   {
      $faqsid = $_GET['faqsid'];
      $update_id = $_GET['questionid'];
      $FaqsQuestion = faqs\FAQsData::getFaqsQuestionDetail($update_id, $faqsid); 
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

   // Get all categories
   $Categories = faqs\FAQsData::getFaqsCategory(); 
?>
<div class="wrap t201plugin">
   <h2>      
      <a href="<?php print admin_url('admin.php?page=faqs-view-faqs&faqsid='.$faqsid); ?>" class="add-new-h2">Back</a>
   </h2>
   
   <div id="message" class="updated below-h2 think201-wp-msg think201-wp-msg-success">
      <p>Question has been updated</p>
   </div>
   <div id="message" class="error below-h2 think201-wp-msg think201-wp-msg-error">
      <p>Question has been not updated</p>
   </div>
   <div class="tbox">
      <div class="tbox-heading">
         <h3>Edit Question</h3>
         <a href="http://labs.think201.com/plugins/faqs" target="_blank" class="pull-right">Need help?</a>
      </div>
      <div class="tbox-body">
         <form name="faqs_add_question_form" id="faqs_add_question_form" action="#" method="post">             
            <input type="hidden" name="action" value="page_add_faqs_question">
            <input type="hidden" name="faq_id" value="<?php print $faqsid; ?>">
            <input type="hidden" name="update" value="update">
            <input type="hidden" name="update_id" value="<?php print $update_id ?>">
            <table class="form-table">
               <tr valign="top">
                  <th scope="row">
                     <label for="name">Question:</label>
                  </td>
                  <td>
                     <input type="text" id="question" name="question" placeholder="Enter Question" class="regular-text" data-validations="required" value="<?php print $FaqsQuestion->question;?>">
                  </td>
               </tr>
               <tr valign="top">
                  <th scope="row">
                     <label for="name">Answer:</label>
                  </td>
                  <td>
                     <textarea id="answer" name="answer" placeholder="Enter Answer" cols="39" rows="4" class="regular-text" data-validations="required"><?php print $FaqsQuestion->answer;?></textarea>
                  </td>
               </tr>
               <tr valign="top">
                  <th scope="row">
                     <label for="name">Category:</label>
                  </td>
                  <td>
                     <select name="category_id" class="regular-text" data-validations="required">
                        <option value="">Select Category</option>
                        <?php
                        foreach($Categories as $category)
                        {
                           if($category->id == $FaqsQuestion->category_id)
                           {
                              $selected = 'selected';
                           }
                           else
                           {
                              $selected = '';
                           }
                        ?>
                           <option <?php echo $selected; ?> value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>                       
                        <?php
                        }
                        ?>
                     </select>                     
                     <i>Note: Create new category from <a href="<?php print admin_url('admin.php?page=faqs-create-category'); ?>">here</a></i>
                  </td>
               </tr>
               <tr valign="top">
                  <th scope="row">
                     <label for="name">Order:</label>
                  </td>
                  <td>
                     <input type="text" id="question_order" name="question_order" placeholder="Enter Question Order" class="regular-text" data-validations="required" value="<?php print $FaqsQuestion->question_order;?>">
                  </td>
               </tr>
            </table>
            <p class="submit">       
               <button onClick="Think201WP.post('#faqs_add_question_form', false)" class="button button-primary" type="button">Update Question</button>
            </p>
         </form>
      </div>

      <div class="tbox-footer">
        Update question. Make sure your cross check the details provided.
      </div>
   </div>
</div>