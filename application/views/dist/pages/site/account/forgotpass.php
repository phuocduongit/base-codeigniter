<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
        <div class="d-flex kt-grid__item kt-grid__item--fluid kt-login__wrapper kt-signin__wrapper kt-create__wrapper ">
            <div class="kt-login__container align-self-center">
                <div class="kt-login__logo">
                    <a href="#">
                        <h1>ERP OTO</h1>
                    </a>
                </div>
                <div class="kt-login__signup_2">
                    <div class="kt-login__head">
                        <h3 class="kt-login__title">Đổi mật khẩu</h3>
                        <div class="kt-login__desc">Nhập đầy đủ cả hai yêu cầu bên dưới:</div>
                    </div>
                    <form class="kt-form" action="" id="kt-form-forgot-pass" method="POST"
                        enctype="multipart/form-data">
                        <div class="input-group">
                            <input class="form-control" type="password" placeholder="Password" name="password">
                            <div class="invalid-feedback err-password-v error-v">Password không được bỏ trống</div>
                        </div>
                        <div class="input-group">
                            <input class="form-control" type="password" placeholder="Nhập lại pasword" name="rpassword">
                            <div class="invalid-feedback err-password-v error-v">Nhập lại password không được bỏ trống
                            </div>
                        </div>

                        <div class="kt-login__actions">
                            <button class="btn btn-brand btn-elevate kt-login__btn-primary" id="btn-newpass"
                                name="btnForGotPass" type="sumbit">ĐỒNG Ý</button>&nbsp;&nbsp;
                        </div>
                        <div class="kt-forgot-pass" style="margin-top:100px;">
                            <span><a href="/login">Quay lại đăng nhập</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
const ref = `<?= isset($_GET['ref']) && !empty($_GET['ref']) ? $_GET['ref'] : ''?>`;
const token_forgot = `<?= isset($_GET['token']) && !empty($_GET['token']) ? $_GET['token'] : ''?>`;
</script>
<?php add_script(assets_url_page('/guest/login/login.js'),'login'); ?>
<?php add_style(assets_url_page('/guest/login/login.css'),'login'); ?>