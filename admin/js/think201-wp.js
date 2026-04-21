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
          console.log('success');
          $('.think201-wp-msg-success p').html(data.msg);
          $('.think201-wp-msg-success').fadeIn(1000).siblings('.think201-wp-msg').hide();
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
        $('.think201-wp-msg-error p').html(data.msg);
        $('.think201-wp-msg-error').fadeIn(1000).siblings('.think201-wp-msg').hide();
      }                        
    }); 
  }
};


