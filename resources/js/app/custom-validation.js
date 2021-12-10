$.Customvalid = {
    addCustomMethods: {
        init: function() {
            jQuery.validator.addMethod("validEmail", function(value, element) {
                return this.optional( element ) || /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test( value );
            }, 'Please enter a valid email address.');

            jQuery.validator.addMethod("regex", function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            }, "Please enter valid value.");  
        }
    }
}

jQuery(document).ready(
    function($) {

        $.Customvalid.addCustomMethods.init();
    }
);

