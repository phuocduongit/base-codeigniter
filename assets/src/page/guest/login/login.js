var KTLoginGeneral = function () {
    var login = $('#kt_login');
    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="kt-alert kt-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
			<span></span>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        //alert.animateClass('fadeIn animated');
        KTUtil.animateClass(alert[0], 'fadeIn animated');
        alert.find('span').html(msg);
    }

    var displaySignUpForm = function() {
        login.removeClass('kt-login--forgot');
        login.removeClass('kt-login--signin');

        login.addClass('kt-login--signup');
        KTUtil.animateClass(login.find('.kt-login__signup')[0], 'flipInX animated');
    }

    var displaySignInForm = function() {
        login.removeClass('kt-login--forgot');
        login.removeClass('kt-login--signup');

        login.addClass('kt-login--signin');
        KTUtil.animateClass(login.find('.kt-login__signin')[0], 'flipInX animated');
        //login.find('.kt-login__signin').animateClass('flipInX animated');
    }

    var displayForgotForm = function() {
        login.removeClass('kt-login--signin');
        login.removeClass('kt-login--signup');

        login.addClass('kt-login--forgot');
        //login.find('.kt-login--forgot').animateClass('flipInX animated');
        KTUtil.animateClass(login.find('.kt-login__forgot')[0], 'flipInX animated');

    }

    var handleFormSwitch = function() {
        $('#kt_login_forgot').click(function(e) {
            e.preventDefault();
            displayForgotForm();
        });

        $('#kt_login_forgot_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });

        $('#kt_login_signup').click(function(e) {
            e.preventDefault();
            displaySignUpForm();
        });

        $('#kt_login_signup_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });
    }
    var handleSignInFormSubmit = function () {
        $('#form-login').validate({
            rules : {
                username : {
                    required : true
                },
                password : {
                    required : true
                }
            },
            messages : {
                username : {
                    required : "Tên đăng nhập không được để trống"
                },
                password : {
                    required : "Vui lòng nhập mật khẩu"
                }
            },
            submitHandler: function (form) {
                $('#btn-login-v').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                $.ajax({
                    url: '/api/account/login',
                    method: 'post',
                    data: {
                        username:$('input[name=username]').val(),
                        password:$('input[name=password]').val()
                    },
                }).done(function (response) {
                    $('#btn-login-v').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                    if (response.status) {
                        showErrorMsg($(form), 'success', response.message);
                        toastr.success(response.message);
                        window.location.replace(response.data.redirect);
                    } else {
                        showErrorMsg($(form), 'danger', response.message);
                        toastr.error(response.message);
                    }
                }).fail(function (response) {
                    toastr.error(response.responseJSON.message)
                    $('#btn-login-v').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                });
            }
        })
    }

    var handleSignUpFormSubmit = function() {
        $('#kt_login_signup_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    fullname: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                    rpassword: {
                        required: true
                    },
                    agree: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            form.ajaxSubmit({
                url: '',
                success: function(response, status, xhr, $form) {
                	// similate 2s delay
                	setTimeout(function() {
	                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
	                    form.clearForm();
	                    form.validate().resetForm();

	                    // display signup form
	                    displaySignInForm();
	                    var signInForm = login.find('.kt-login__signin form');
	                    signInForm.clearForm();
	                    signInForm.validate().resetForm();

	                    showErrorMsg(signInForm, 'success', 'Thank you. To complete your registration please check your email.');
	                }, 2000);
                }
            });
        });
    }

    var handleForgotFormSubmit = function() {
        $('#form-forgot').validate({
            rules : {
                email : {
                    required: true,
                    email: true
                },
            },
            messages : {
                email : {
                    required: "Bạn phải nhập email đã đăng ký để nhận lại mật khẩu",
                    email: "Email không đúng định dạng"
                }
            },
            submitHandler: function (form) {
                $('#btn-forgot-v').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                $.ajax({
                    url: '/api/account/forgot',
                    method: 'post',
                    data: {
                        email:$('input[name=email]').val(),
                    },
                }).done(function (response) {
                    $('#btn-forgot-v').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                    if (response.status) {
                        showErrorMsg($(form), 'success', response.message);
                        toastr.success(response.message);
                    } else {
                        showErrorMsg($(form), 'danger', response.message);
                        toastr.error(response.message);
                    }
                }).fail(function (response) {
                    toastr.error(response.responseJSON.message)
                    showErrorMsg($(form), 'danger', response.message);
                    $('#btn-forgot-v').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                });
            }
        })
    }

    var handleNewPassFormSubmit = function() {
        $('#kt-form-forgot-pass').validate({
            rules : {
                password: {
                    required: true
                },
                rpassword: {
                    required: true
                },
            },
            messages : {
                password : {
                    required: "Bạn phải nhập mật khẩu để đổi",
                },
                rpassword : {
                    required: "Vui lòng nhập lại mật khẩu",
                }
            },
            submitHandler: function (form) {
                $('#btn-newpass').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                $.ajax({
                    url: '/api/account/newpassword',
                    method: 'post',
                    data: {
                        password: $('input[name=password]').val(),
                        rpassword: $('input[name=rpassword]').val(),
                        token:token_forgot,
                    },
                }).done(function (response) {
                    $('#btn-newpass').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                    if (response.status) {
                        showErrorMsg($(form), 'success', response.message);
                        toastr.success(response.message);
                        window.location.replace(response.data.redirect);
                    } else {
                        showErrorMsg($(form), 'danger', response.message);
                        toastr.error(response.message);
                    }
                }).fail(function (response) {
                    toastr.error(response.responseJSON.message)
                    showErrorMsg($(form), 'danger', response.message);
                    $('#btn-newpass').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                });
            }
        })
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            handleFormSwitch();
            handleSignInFormSubmit();
            handleSignUpFormSubmit();
            handleForgotFormSubmit();
            handleNewPassFormSubmit();
        }
    };
}();

jQuery(document).ready(function() {
    KTLoginGeneral.init();
});