 /**
  *  YunoHost - Self-hosting for all
  *  Copyright (C) 2012  Kload <kload@kload.fr>
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
	 *	User form ergonomic functions
	 */
	jQuery(".useradd #username").blur(function () {
		jQuery(".useradd #mail").val(jQuery(this).val() + '@' + jQuery(".useradd #domain").val());
	});
	jQuery(".useradd #domain").change(function () {
		jQuery(".useradd #mail").val(jQuery(".useradd #username").val() + '@' + jQuery(this).val());
	});


	/**
	 *	User form validation functions
	 */

	jQuery(".useradd #mail").blur(function() {
		var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (reg.test(jQuery(this).val()) && jQuery(".useradd #domain").val() == jQuery(this).val().substr(jQuery(this).val().indexOf('@') + 1)) {
			jQuery(this).css('color', '#555');
		} else {
			jQuery(this).css('color', '#E9322D');
		}
	});

	jQuery(".useradd .aliasrow").blur(function() {
		var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if (reg.test(jQuery(this).val())) {
			jQuery(this).css('color', '#555');
		} else {
			jQuery(this).css('color', '#E9322D');
		}
	});

	jQuery(".useradd #username").blur(function() {
		var reg = /^[a-z0-9]{2,20}$/;
		if (reg.test(jQuery(this).val())) {
			jQuery(this).css('color', '#555');
		} else {
			jQuery(this).css('color', '#E9322D');
		}
	});

	jQuery(".useradd #firstname").blur(function() {
		var reg = /^[a-zA-Z0-9]{2,20}$/;
		if (reg.test(jQuery(this).val())) {
			jQuery(this).css('color', '#555');
		} else {
			jQuery(this).css('color', '#E9322D');
		}
	});

	jQuery(".useradd #lastname").blur(function() {
		var reg = /^[a-zA-Z0-9]{2,20}$/;
		if (reg.test(jQuery(this).val())) {
			jQuery(this).css('color', '#555');
		} else {
			jQuery(this).css('color', '#E9322D');
		}
	});

	jQuery(".useradd #confirm").blur(function() {
		if (jQuery(this).val() == jQuery(".useradd #password").val()) {
			jQuery(this).css('color', '#46a546');
			jQuery(".useradd #password").css('color', '#46a546');
		} else {
			jQuery(this).css('color', '#E9322D');
			jQuery(".useradd #password").css('color', '#E9322D');
		}
	});

	/**
	 *	Add && Remove aliases ui
	 */

	jQuery(".useradd #addAlias").click(function() {
		jQuery(".mailrow").last().after('<p class="row mailrow aliasrow">'+jQuery('.parentaliasrow').html()+'</p>');
	});

	jQuery(".useradd a.removeAlias").live('click', function() {
		jQuery(this).closest('.aliasrow').remove();
	});

	/**
	 *	Change password ui
	 */

	jQuery(".useradd #newPassword2").blur(function() {
		if (jQuery(this).val() == jQuery(".useradd #newPassword").val()) {
			jQuery(this).css('color', '#46a546');
			jQuery(".useradd #newPassword").css('color', '#46a546');
		} else {
			jQuery(this).css('color', '#E9322D');
			jQuery(".useradd #newPassword").css('color', '#E9322D');
		}
	});
});



