<div class="wrap t201plugin">
    <h2>FAQs Categories</h2>

    <div id="message" class="updated below-h2 think201-wp-msg think201-wp-msg-success">
        <p>Category Added</p>
    </div>
    <div id="message" class="error below-h2 think201-wp-msg think201-wp-msg-error">
        <p>Issues adding Category.</p>
    </div>
    
    <div class="tbox">
        <div class="tbox-heading">
            <h3>Add New Category</h3>
            <a href="http://labs.think201.com/plugins/faqs" target="_blank" class="pull-right">Need help?</a>
        </div>
        <div class="tbox-body">
            <form name="faqs-add-category" id="faqs-add-category" action="#" method="post">             
                <input type="hidden" name="action" value="page_add_new_category">
                <table class="form-table">

                    <tr valign="top">
                        <th scope="row">
                            <label for="category">Category:</label>
                        </td>
                        <td>
                            <input type="text" id="cat_name" name="cat_name" class="regular-text" data-validations="required">
                        </td>
                    </tr>                                       

                </table>
                <p class="submit">      
                    <button onClick="Think201WP.post('#faqs-add-category')" class="button button-primary" type="button">Add Category</button>
                </p>
            </form>

        </div>
        <div class="tbox-footer">
            Categories helps you in organizing FAQS. Add as many categories you want from here. 
        </div>
    </div>
</div>