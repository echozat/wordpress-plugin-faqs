/******* Jquery No Conflict Function *******/
window.$ = jQuery.noConflict();

var Validator = {

    init: function()
    {

    },

    check: function(FormObj)
    {
        if (typeof $.fn.validator !== 'function') {
            return true;
        }
        return FormObj.validator('checkform', FormObj);
    },

    set: function(FormId)
    {
        if (typeof $.fn.validator !== 'function') {
            return;
        }
        $(FormId+' input').validator({events   : 'blur change'});
    },

};

 
$(function() {
    Validator.set('#faqs_add_form');
});

window.Validator = Validator;