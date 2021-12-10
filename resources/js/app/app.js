$.app = {
	header: {
		init: function () {
			$('.menu-toggler').on('click', function () {
				$('.main-content--warppar').toggleClass("expand--out expand--in");
			});

			$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
				if (!$(this).next().hasClass('show')) {
					$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				var $subMenu = $(this).next(".dropdown-menu");
				$subMenu.toggleClass('show');

				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
					$('.dropdown-submenu .show').removeClass("show");
				});

				return false;
			});
		}
	},
	dataTable: {
		init: function() {
			$( ".datatable" ).DataTable({
                order: [[ 0, "desc" ]],
                columnDefs: [
                    { targets: 0, visible: false }
                ]
            });
		}
	},
	responsiveTabs: {
		init: function() {
			 // tabbed content
			// http://www.entheosweb.com/tutorials/css/tabs.asp
			$(".tab_content").hide();
			$(".tab_content:first").show();

			/* if in tab mode */
			$("ul.tabs li").click(function() {

				$(".tab_content").hide();
				var activeTab = $(this).attr("rel");
				$("#"+activeTab).fadeIn();

				$("ul.tabs li").removeClass("active");
				$(this).addClass("active");

				$(".tab_drawer_heading").removeClass("d_active");
				$(".tab_drawer_heading[rel^='"+activeTab+"']").addClass("d_active");

			});
			/* if in drawer mode */
			$(".tab_drawer_heading").click(function() {
				$(".tab_content").hide();
				var d_activeTab = $(this).attr("rel");
				$("#"+d_activeTab).fadeIn();

				$(".tab_drawer_heading").removeClass("d_active");
				$(this).addClass("d_active");

				$("ul.tabs li").removeClass("active");
				$("ul.tabs li[rel^='"+d_activeTab+"']").addClass("active");
			});


			/* Extra class "tab_last"
			   to add border to right side
			   of last tab */
			$('ul.tabs li').last().addClass("tab_last");

		}
	},
	datePicker: {
		init: function() {
			$( ".datepicker" ).datepicker({
				format: 'yyyy-mm-dd',
			}).on('keypress', function (e) {
                e.preventDefault();
                return false;
            }).on('keydown', function (event) {
                if (event.ctrlKey==true && (event.which == '118' || event.which == '86')) {
                    event.preventDefault();
                }
            });
		}
	},
	select2Dropdown: {
		init: function() {
			$('.select2-elem').select2();

			$('.permissions-list').select2({
				placeholder: 'Permission',
			});
		}
	},
	singleSelect2Dropdown: {
		init: function() {
			$('.select2bs4').select2({
	            theme: 'bootstrap4'
	        });
		}
	}
}

jQuery(document).ready(
	function($) {
		$.app.header.init();
		$.app.dataTable.init();
		$.app.responsiveTabs.init();
		$.app.datePicker.init();
		$.app.select2Dropdown.init();
		$.app.singleSelect2Dropdown.init();
	}
);
