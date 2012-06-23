 /**
  *  YunoHost - Self-hosting for all
  *  Copyright (C) 2012  
  * 	Kload <kload@kload.fr>
  * 	Guillaume DOTT <github@dott.fr>
  *
  *  This program is free software: you can redistribute it and/or modify
  *  it under the terms of the GNU Affero General Public License as
  *  published by the Free Software Foundation, either version 3 of the
  *  License, or (at your option) any later version.
  *
  *  This program is distributed in the hope that it will be useful,
  *  but WITHOUT ANY WARRANTY; without even the implied warranty of
  *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  *  GNU Affero General Public License for more details.
  *
  *  You should have received a copy of the GNU Affero General Public License
  *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
  */

jQuery(document).ready(function() {
	jQuery(".alert").alert();

	jQuery('#welcomeModal').modal();

	jQuery(".hidden").hide();

        /**
         * jQuery dataTables plugin with tweaks for bootstrap 2 compatibility
         * http://datatables.net/blog/Twitter_Bootstrap_2
         */
        jQuery("table.table-sortable").dataTable({
          "oLanguage": dataTable_i18n,
          "bPaginate": false,
          "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>"
        });
        jQuery.extend( jQuery.fn.dataTableExt.oStdClasses, {
          "sWrapper": "dataTables_wrapper form-inline"
        } );

	/**
	 *	User form ergonomic functions
	 */

	jQuery(".entityForm #username").blur(function () {
		jQuery(".entityForm #mail").val(jQuery(this).val() + '@' + jQuery(".entityForm #domain").val());
	});
	jQuery(".entityForm #domain").change(function () {
		jQuery(".entityForm #mail").val(jQuery(".entityForm #username").val() + '@' + jQuery(this).val());
	});


	/**
	 *	User form validation functions
	 */

	jQuery(".entityForm #mail").blur(function() {
		var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (reg.test(jQuery(this).val()) && jQuery(".entityForm #domain").val() == jQuery(this).val().substr(jQuery(this).val().indexOf('@') + 1)) {
			jQuery(this).css('color', '#555');
		} else {
			jQuery(this).css('color', '#E9322D');
		}
	});

	jQuery(".entityForm .aliasrow").blur(function() {
		var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (reg.test(jQuery(this).val())) {
			jQuery(this).css('color', '#555');
		} else {
			jQuery(this).css('color', '#E9322D');
		}
	});

	jQuery(".entityForm #username").blur(function() {
		var reg = /^[a-z0-9]{2,20}$/;
		if (reg.test(jQuery(this).val())) {
			jQuery(this).css('color', '#555');
		} else {
			jQuery(this).css('color', '#E9322D');
		}
	});

	jQuery(".entityForm #firstname").blur(function() {
		var reg = /^[a-zA-Z0-9]{2,20}$/;
		if (reg.test(jQuery(this).val())) {
			jQuery(this).css('color', '#555');
		} else {
			jQuery(this).css('color', '#E9322D');
		}
	});

	jQuery(".entityForm #lastname").blur(function() {
		var reg = /^[a-zA-Z0-9]{2,20}$/;
		if (reg.test(jQuery(this).val())) {
			jQuery(this).css('color', '#555');
		} else {
			jQuery(this).css('color', '#E9322D');
		}
	});

	jQuery(".entityForm #confirm").blur(function() {
		if (jQuery(this).val() == jQuery(".entityForm #password").val()) {
			jQuery(this).css('color', '#46a546');
			jQuery(".entityForm #password").css('color', '#46a546');
		} else {
			jQuery(this).css('color', '#E9322D');
			jQuery(".entityForm #password").css('color', '#E9322D');
		}
	});

	/**
	 *	Add && Remove aliases ui
	 */

	jQuery(".entityForm #addAlias").click(function() {
		jQuery(".mailrow").last().after('<p class="row mailrow aliasrow">'+jQuery('.parentaliasrow').html()+'</p>');
	});

	jQuery(".entityForm a.removeAlias").live('click', function() {
		jQuery(this).closest('.aliasrow').remove();
	});

	/**
	 *	Change password ui
	 */

	jQuery(".entityForm #newPassword2").blur(function() {
		if (jQuery(this).val() == jQuery(".entityForm #newPassword").val()) {
			jQuery(this).css('color', '#46a546');
			jQuery(".entityForm #newPassword").css('color', '#46a546');
		} else {
			jQuery(this).css('color', '#E9322D');
			jQuery(".entityForm #newPassword").css('color', '#E9322D');
		}
	});

	/**
	 *	Upgrade checker & button
	 */

	jQuery("#upgrade-li a").live('click', function() {
		html = '<a href="#" title="" style="color: #fff" id="check-upgrades"><img src="/public/img/ajax-loader-white.gif" /></a>';
		jQuery('#upgrade-li').html(html);
		jQuery.get('/tools/upgrade/number', function(data) {
				jQuery("#upgrade-li").html(data);
				jQuery("#upgrade-li .tiptool").fadeIn(300).delay(4000).fadeOut(300);
		});
	});

	jQuery("#system-upgrade").click(function(event) {
		event.preventDefault();
		html = '<img src="/public/img/ajax-loader.gif" />';
		jQuery("#upgrade-result").html(html);
		jQuery.get('/tools/upgrade/packages', function(data) {
			jQuery("#upgrade-result").html(data);
		});
	});

	/**
	 *	Welcome pop-up
	 */

	jQuery(".btn-change-tab").click(function() {
		jQuery('.nav-tabs .active').removeClass('active');
		href = jQuery(this).attr('href');
		jQuery(".nav-tabs a:[href='"+href+"']").parent().toggleClass('active');
	});

	jQuery("#ajaxAddUser").submit(function(event) {
	    event.preventDefault(); 	        
	    jQuery.post( "/user/add", { 
	    	ajax: true,
	    	username: jQuery("#username").val(),
	    	password: jQuery("#password").val(),
	    	confirm: jQuery("#confirm").val(),
	    	firstname: jQuery("#firstname").val(),
	    	lastname: jQuery("#lastname").val(),
	    	mail: jQuery("#mail").val(),
	    	isadmin: true
	    	}, 
	    	function( data ) {
	         if (data == 1) {
	         	jQuery('#nextUser').fadeIn();
	         	jQuery('.btn-submit').removeClass('btn-primary').removeClass('btn-danger').addClass('btn-success').after('<i class="icon-ok" style="margin: 2px 0 0 6px"></i>');
	         } else {
	         	jQuery('.btn-submit').removeClass('btn-primary').removeClass('btn-success').addClass('btn-danger').after('<i class="icon-remove" style="margin: 2px 0 0 6px"></i>');
	         }
	    });
	});

        if (typeof operationAjaxUrl != 'undefined') {
          jQuery.get(operationAjaxUrl,
          function(data) {
            jQuery("#operation-result").html("<pre>"+data.result+"</pre>");
            if(data.errorCode == 0) {
              jQuery("#operation-success").show();
            }
            else {
              jQuery("#operation-fail").show();
            }
          });
        }
});



