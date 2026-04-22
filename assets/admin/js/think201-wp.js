/******* Jquery No Conflict Function *******/
window.$ = jQuery.noConflict();

var Think201WP = {

  settings:
  { 
    formObj  : null,
  },

  post: function(FormId)
  {    
    Think201WP.settings.formObj = $(FormId);

    if(Validator.check(Think201WP.settings.formObj) == false)
    {
        return false;
    }

    $.ajax({
      url: ajaxurl,
      type: 'post',
      data: Think201WP.settings.formObj.serialize(),
      success: function(data, status) 
      {
        if (data.status == true) 
        {
          $('.think201-wp-msg-success p').html(data.msg);
          $('.think201-wp-msg-success').fadeIn(1000).siblings('.think201-wp-msg').hide();
          if ($(FormId).find('input[name="action"]').val() === 'page_add_new_category') {
            setTimeout(function() { window.location.reload(); }, 250);
            return;
          }
          $(FormId)[0].reset();
        } 
        else 
        {
          $('.think201-wp-msg-error p').html(data.msg);
          $('.think201-wp-msg-error').fadeIn(1000).siblings('.think201-wp-msg').hide();
        }
      },
      error: function() 
      {
        $('.think201-wp-msg-error p').html('Oops, there seems to be some issue.');
        $('.think201-wp-msg-error').fadeIn(1000).siblings('.think201-wp-msg').hide();
      }                        
    }); 
  }
};

window.Think201WP = Think201WP;


