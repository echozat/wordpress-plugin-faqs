/******* Jquery No Conflict Function *******/
window.$ = jQuery.noConflict();

var Think201WP = {

  settings:
  { 
    formObj  : null,
  },

  showError: function(msg)
  {
    $('.think201-wp-msg-error p').html(msg || 'Oops, there seems to be some issue.');
    $('.think201-wp-msg-error').fadeIn(1000).siblings('.think201-wp-msg').hide();
  },

  showSuccess: function(msg)
  {
    $('.think201-wp-msg-success p').html(msg);
    $('.think201-wp-msg-success').fadeIn(1000).siblings('.think201-wp-msg').hide();
  },

  post: function(FormId, options)
  {
    options = options || {};
    Think201WP.settings.formObj = FormId ? $(FormId) : null;
    if (options.beforeSend && options.beforeSend() !== true) return false;
    if (Think201WP.settings.formObj && Think201WP.settings.formObj.length && Validator.check(Think201WP.settings.formObj) == false) return false;
    $.ajax({
      url: ajaxurl,
      type: 'post',
      data: options.data || Think201WP.settings.formObj.serialize(),
      success: function(data, status)
      {
        if (typeof options.onSuccess === 'function') return options.onSuccess(data, status, FormId);
        if (data.status == true)
        {
          Think201WP.showSuccess(data.msg);
          if (Think201WP.settings.formObj && $(FormId).find('input[name="action"]').val() === 'page_add_new_category') {
            setTimeout(function() { window.location.reload(); }, 250);
            return;
          }
          if (Think201WP.settings.formObj && Think201WP.settings.formObj[0]) Think201WP.settings.formObj[0].reset();
        }
        else
        {
          Think201WP.showError(data.msg);
        }
      },
      error: function()
      {
        Think201WP.showError();
      }
    });
  },

  bindDeleteAction: function(options)
  {
    options = options || {};

    $(document).off('click', options.selector).on('click', options.selector, function(e) {
      //
      e.preventDefault();
      var $button = $(this);
      var id = parseInt($button.data(options.idKey || 'id'), 10);
      var nonce = $button.data(options.nonceKey || 'nonce');
      var payload = { action: options.action, nonce: nonce };
      if (!id || !nonce) return Think201WP.showError(options.invalidMessage || 'Invalid delete request.');
      payload[options.idParam || 'id'] = id;
      
      Think201WP.post(null, {
        data: payload,
        beforeSend: function() { return window.confirm(options.confirmText || 'Are you sure you want to delete this item?'); },
        onSuccess: function(data) {
          if (data.status == true) {
            Think201WP.showSuccess(data.msg);
            if (options.reload !== false) setTimeout(function() { window.location.reload(); }, 250);
            return;
          }
          Think201WP.showError(data.msg);
        }
      });
    });
  }
};

window.Think201WP = Think201WP;

Think201WP.bindDeleteAction({
  selector: '.faqs-delete-faq',
  action: 'page_delete_faq',
  idKey: 'faqsid',
  idParam: 'faqsid',
  confirmText: 'Are you sure you want to delete this FAQ?',
  invalidMessage: 'Invalid FAQ delete request.'
});


