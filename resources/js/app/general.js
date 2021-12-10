$.General = {
	confirmBox: {
		init: function () {
			$(document).on('click', '.confirm-action', function() {
				if (!confirm("Are you sure?")){
				  	return false;
				}
			});
		}
	}
}

jQuery(document).ready(
    function($) {
        // $.General.confirmBox.init();
    }
);

