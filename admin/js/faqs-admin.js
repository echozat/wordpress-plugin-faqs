/******* Jquery No Conflict Function *******/
window.$ = jQuery.noConflict();

var Validator = {

    init: function()
    {

    },

    check: function(FormObj)
    {
        return FormObj.validator('checkform', FormObj);
    },

    set: function(FormId)
    {
        $(FormId+' input').validator({events   : 'blur change'});
    },

};

 
$(function() {
    Validator.set('#faqs_add_form');
});
