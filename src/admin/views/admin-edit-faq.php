<?php
   if(isset($_GET['page']) && isset($_GET['faqsid']))
   {
      if($_GET['page'] === 'faqs-edit-faq')
      {
         $update_id = $_GET['faqsid'];
         $Faqs = faqs\FAQsData::getFaqsDetail($update_id); 
      }
      else
      {
         faqs\faqsRedirectTo('admin.php?page=faqs-all-faqs');
      }
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

?>

<div class="wrap t201plugin">
   <h2>
      Update
      <a href="<?php print admin_url('admin.php?page=faqs-all-faqs'); ?>" class="add-new-h2">Back</a>
   </h2>
   
   <div id="message" class="updated below-h2 think201-wp-msg think201-wp-msg-success">
      <p>Faqs has been updated</p>
   </div>
   <div id="message" class="error below-h2 think201-wp-msg think201-wp-msg-error">
      <p>Faqs has been not updated</p>
   </div>
   <div class="tbox">
      <div class="tbox-heading">
         <h3><?php print $Faqs->name ?></h3>
         <a href="http://labs.think201.com/plugins/faqs" target="_blank" class="pull-right">Need help?</a>
      </div>
      <div class="tbox-body">
         <form name="faqs_add_form" id="faqs_add_form" action="#" method="post">             
               <input type="hidden" name="action" value="page_add_new_faqs">
               <input type="hidden" name="update" value="update">
               <input type="hidden" name="update_id" value="<?php print $Faqs->id ?>">
            <table class="form-table">
               <tr valign="top">
                  <th scope="row">
                     <label for="name">Name:</label>
                  </td>
                  <td>
                     <input type="text" id="name" name="name" placeholder="Faqs Name" class="regular-text" data-validations="required" value="<?php print $Faqs->name ?>">
                  </td>
               </tr>
            </table>            
            </table>
            <p class="submit">       
              <button onClick="Think201WP.post('#faqs_add_form', true)" class="button button-primary" type="button">Update Faqs</button>
            </p>
          </form>
      </div>

      <div class="tbox-footer">
        Update Faqs details. Make sure your cross check the details provided.
      </div>
   </div>
</div>
