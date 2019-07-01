<div class="container">
    <div id="install">
        <div class="card wrapper-loading">
            <div class="card-header card-primary">
                <h3>The wizard setup the website</h3>
            </div>
            <div class="card-body">
                <div class="wizard">
                    <div class="stepwizard">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step">
                                <a href="#step-1" type="button" class="btn btn-primary btn-circle">
                                    <i class="flaticon2-rocket"></i>
                                </a>
                                <p>Step 1</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-2" type="button" class="btn btn-default btn-circle"
                                    disabled="disabled">
                                    <i class="flaticon2-delivery-package"></i>
                                    </a>
                                <p>Step 2</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-3" type="button" class="btn btn-default btn-circle"
                                    disabled="disabled">
                                    <i class="flaticon-email-black-circular-button"></i>
                                    </a>
                                <p>Step 3</p>
                            </div>
                        </div>
                    </div>
                    <form role="form" id="frm-setup">
                        <div class="row setup-content" id="step-1">
                            <div class="col-md-12">
                                <h4> Download and Install Package</h4>
                                <div class="panel">
                                    <pre>composer install</pre>
                                    <pre>yarn && yarn run dev</pre>
                                </div>
                                <button class="btn btn-primary nextBtn float-right"
                                    type="button">Next</button>
                            </div>
                        </div>
                        <div class="row setup-content" id="step-2">
                            <div class="col-md-12">
                                <h3>Config Database</h3>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">Hostname</label>
                                            <input type="text" class="form-control" name="hostname" placeholder="Hostname" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">Database Name</label>
                                            <input type="text" class="form-control" name="database" placeholder="Database Name" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">Username</label>
                                            <input type="text" class="form-control" name="username" placeholder="Username" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">Password</label>
                                            <input type="text" class="form-control" name="password" placeholder="Password" />
                                        </div>
                                    </div>
                                    
                                </div>
                            
                                <button class="btn btn-primary float-right"
                                    type="submit">Next</button>
                            </div>
                        </div>
                        <div class="row setup-content" id="step-3">
                            <div class="col-md-12">
                                <div class="private mt-4">
                                    <div class="success-checkmark">
                                        <div class="check-icon">
                                            <span class="icon-line line-tip"></span>
                                            <span class="icon-line line-long"></span>
                                            <div class="icon-circle"></div>
                                            <div class="icon-fix"></div>
                                        </div>
                                    </div>
                                </div>
                                <a  class="btn btn-success float-right" href="/">Finish</a>
                                <!-- <button class="btn btn-success float-right" type="submit">Finish!</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php push() ?>
<script>

    window.stepKit = function(){
        var navListItems,
            allWells,
            allNextBtn,
            stepSelector;
        var cbNextButton;

        function initStep(selector){
            navListItems = $(selector).find('.setup-panel div a'),
            allWells = $(selector).find('.setup-content'),
            allNextBtn = $(selector).find('.nextBtn');

            allWells.hide();
            navListItems.click(function (e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                    $item = $(this);

                if (!$item.hasClass('disabled')) {
                    navListItems.removeClass('btn-primary').addClass('btn-default');
                    $item.addClass('btn-primary');
                    allWells.hide();
                    $target.show();
                    $target.find('input:eq(0)').focus();
                }
            });

            allNextBtn.click(function () {
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $(selector).find('.setup-panel div a[href="#' + curStepBtn + '"]').parent().next()
                    .children("a"),
                    isValid = true;

                    $(selector).find(".form-group").removeClass("has-error");
                if(cbNextButton)
                {
                    var isValid = cbNextButton(curStep);
                }
                if (isValid)
                    nextStepWizard.removeAttr('disabled').trigger('click');
                
            });
            $('div.setup-panel div a.btn-primary').trigger('click');
        }
        return {
            init:function(selector,mcbNextButton){
                stepSelector = selector;
                cbNextButton = mcbNextButton;
                initStep(selector);
            },
            next(curStepBtn){
                var nextStepWizard = $(stepSelector).find('.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
                nextStepWizard.removeAttr('disabled').trigger('click');
            }
        }
    }();
    $(document).ready(function () {
        stepKit.init('.wizard',function(form){
            if(form.attr("id")  == 'step-1')
            {
                return true;
            }
            debugger;
            return false;
        });

        $('#frm-setup').validate({
            rules : {
                hostname : {
                    required: true,
                },
                database : {
                    required: true,
                },
                username : {
                    required: true,
                },
            },
            submitHandler: function (form) {
                $('.nextBtn').addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                $.ajax({
                    url: '/api/install/run-config-db',
                    method: 'post',
                    data: {
                        hostname:$('input[name=hostname]').val(),
                        database:$('input[name=database]').val(),
                        username:$('input[name=username]').val(),
                        password:$('input[name=password]').val(),
                    },
                }).done(function (response) {
                    $('.nextBtn').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                    if (response.status) {
                        stepKit.next('step-2');
                        showErrorMsg($(form), 'success', response.message);
                        toastr.success(response.message);
                    } else {
                        showErrorMsg($(form), 'danger', response.message);
                        toastr.error(response.message);
                    }
                }).fail(function (response) {
                    toastr.error(response.responseJSON.message)
                    showErrorMsg($(form), 'danger', response.message);
                    $('.nextBtn').removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light');
                });
            }
        });
    });
</script>
<?php endpush("scripts") ?>