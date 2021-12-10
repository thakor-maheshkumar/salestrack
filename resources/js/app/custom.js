$.custom = {
	getGroupType: {
		init: function () {
			$(document).on("change", ':radio[name="under"]', function(){
	            var type = $(this).val();

	            $.ajax({
	                url: config.routes.url + '/admin/masters/account/get-groups-type/' + type,
	                type: 'GET',
	                success:function(response) {

	                    var _select = $("<select />", {
	                        'class': 'form-control',
	                        'id': 'group_type',
	                        'name': 'group_type',
	                    });

	                    if (response.success)
	                    {
	                        var text = '';

	                        if (type == 1)
	                        {
	                            var _label = $("<label />", {
	                                'for': 'group_type'
	                            }).text('Primary Group');

	                            $.each(response.data, function(index, el) {
	                                $('<option/>', {
	                                    'value': index,
	                                    'text': el
	                                }).appendTo(_select);
	                            });

	                            $(".select-group-wrapper").html(_label.add(_select));
	                        }
	                        else
	                        {
	                            var _label = $("<label />", {
	                                'for': 'group_type'
	                            }).text('Sub Group');

	                            $.each(response.data, function(index, el) {
	                                $('<option/>', {
	                                    'value': index,
	                                    'text': el
	                                }).appendTo(_select);
	                            });

	                            $(".select-group-wrapper").html(_label.add(_select));
	                        }
	                    }
	                },
	                error: function(error) {
	                    console.log(error);
	                }
	            })
	        });
		}
	},
	confirmBox: {
		init: function () {
			$(document).on('click', '.confirm-action', function() {
				if (!confirm("Are you sure?")){
				  	return false;
				}
			});
		}
	},
    checkFullPageBackgroundImage: {
        init: function() {
            $page = $('.full-page');
            image_src = $page.data('image');

            if (image_src !== undefined) {
              image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>';
              $page.append(image_container);
            }
        }
    }
}

jQuery(document).ready(
    function($) {
        //$.custom.getGroupType.init();
        $.custom.confirmBox.init();
        $.custom.checkFullPageBackgroundImage.init();
    }
);
