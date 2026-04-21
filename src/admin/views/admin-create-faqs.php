<div class="wrap t201plugin">
   <h2>
      Add New FAQ
      <a href="<?php print admin_url('admin.php?page=faqs-all-faqs'); ?>" class="add-new-h2">Back</a>
   </h2>
   
   <div id="message" class="updated below-h2 think201-wp-msg think201-wp-msg-success">
      <p>Faqs has been added</p>
   </div>
   <div id="message" class="error below-h2 think201-wp-msg think201-wp-msg-error">
      <p>Faqs has been not added</p>
   </div>
   <div class="tbox">
      <div class="tbox-heading">
         <h3>Faqs</h3>
         <a href="http://labs.think201.com/plugins/faqs" target="_blank" class="pull-right">Need help?</a>
      </div>
      <div class="tbox-body">
         <form name="faqs_add_form" id="faqs_add_form" action="#" method="post">             
            <input type="hidden" name="action" value="page_add_new_faqs">
            <table class="form-table">
               <tr valign="top">
                  <th scope="row">
                     <label for="name">Name:</label>
                  </td>
                  <td>
                     <input type="text" id="name" name="name" placeholder="FAQ's Name" class="regular-text" data-validations="required">
                  </td>
               </tr>
            </table>
            <p class="submit">       
               <button onClick="Think201WP.post('#faqs_add_form', false)" class="button button-primary" type="button">Add FAQ</button>
            </p>
         </form>
      </div>

      <div class="tbox-footer">
        Add faqs. Make sure your cross check the details provided.
      </div>
   </div>
</div>