<div class=" kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
    <div class=" kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
        <div class="d-flex kt-grid__item kt-grid__item--fluid kt-login__wrapper">
            <div class="kt-login__container align-self-center">
                <div class="kt-login__logo">
                    <a href="#">
                        <h1>ERP OTO</h1>
                    </a>
                </div>
                <div class="kt-login__signin">
                    <div class="kt-login__head">
                        <h3 class="kt-login__title">Đăng nhập</h3>
                    </div>
                    <form class="kt-form" action="/account/login" method="post" id="form-login">
                        <div class="input-group">
                            <input class="form-control" require="true" type="text" placeholder="Tên đăng nhập"
                                name="username" autocomplete="off" aria-describedby="email-error" aria-invalid="true"
                                data-model="username">
                            <div id="email-error" class="error-v invalid-feedback err-username-v">Tên đăng nhập không
                                được bỏ
                                trống.</div>
                        </div>
                        <div class="input-group">
                            <input class="form-control" id="password" type="password" placeholder="Mật khẩu" name="password">
                            <label class="error-v invalid-feedback err-password-v" for="password">Vui lòng nhập mật khẩu</label>
                        </div>
                        <div class="kt-login__actions">
                            <button id="btn-login-v" type="submit"
                                class="btn btn-brand btn-elevate kt-login__btn-primary" name="btnLogin">Đăng
                                nhập</button>
                                <div class="kt-forgot-pass">
                                    <span><a href="" id="kt_login_forgot">Quên mật khẩu</a></span>
                                </div>
                        </div>
                    </form>
                </div>
                <div class="kt-login__forgot">
                    <div class="kt-login__head">
                        <h3 class="kt-login__title">Gửi lại mật khẩu</h3>
                        <div class="kt-login__desc">Nhập email của bạn để gửi lại mật khẩu</div>
                    </div>
                    <form class="kt-form"  method="post" id="form-forgot">
                        <div class="input-group">
                            <input class="form-control" type="email" placeholder="Email" name="email">
                            <div id="email-error-forgot-pass" class="error-v invalid-feedback">Vui lòng
                                nhập
                                email hợp lệ để được gửi mật khẩu.</div>
                        </div>
                        <div class="kt-login__actions">
                            <button id="btn-forgot-v" type="submit" class="btn btn-brand btn-elevate kt-login__btn-primary"
                                id="send-mail-forgot-pass">Gửi</button>&nbsp;&nbsp;
                            <div class="kt-forgot-pass">
                                <span><a id="kt_login_signup_cancel">Quay lại</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(isset($success_verify_token)) echo $success_verify_token?>
<?php add_script(assets_url_page('/guest/login/login.js'),'login'); ?>
<?php add_style(assets_url_page('/guest/login/login.css'),'login'); ?>