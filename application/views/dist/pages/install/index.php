<div class="container">
    <div id="install">
        <div class="card">
            <div class="card-header card-primary">
                <h3>The wizard setup the website</h3>
            </div>
            <div class="card-body">
                <ul class="stepper horizontal horizontal-fix" id="horizontal-stepper-fix">
                    <li class="step active">
                        <div class="step-title waves-effect waves-dark">Install Package</div>
                        <div class="step-new-content">
                            <div>
                                <button class="btn btn-primary waves-effect waves-light" >
                                    RUN Composer install
                                    <i class="fas fa-download ml-2"></i>
                                </button>
                            </div>
                            <!-- <div class="step-actions">
                                <button class="waves-effect waves-dark btn btn-sm btn-primary next-step" data-feedback="someFunction22">CONTINUE</button>
                            </div> -->
                        </div>
                    </li>
                    <li class="step">
                        <div class="step-title waves-effect waves-dark">Database</div>
                        <div class="step-new-content">
                        <div class="row">
                            <div class="md-form col-12 ml-auto">
                            <input id="password-horizontal-fix" type="password" class="validate form-control" required>
                            <label for="password-horizontal-fix">Your password</label>
                            </div>
                        </div>
                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn btn-sm btn-primary next-step" data-feedback="someFunction22">CONTINUE</button>
                            <button class="waves-effect waves-dark btn btn-sm btn-secondary previous-step">BACK</button>
                        </div>
                        </div>
                    </li>
                    <li class="step">
                        <div class="step-title waves-effect waves-dark">Finnish</div>
                        <div class="step-new-content">
                        Finish!
                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn-sm btn btn-primary m-0 mt-4" type="button">SUBMIT</button>
                        </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php push() ?>
<script>
function someFunction22() {
    setTimeout(function () {
         $('#horizontal-stepper-fix').nextStep();
    }, 0);
}
</script>
<?php endpush("scripts") ?>

