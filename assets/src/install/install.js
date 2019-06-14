window.jQuery = window.$ = require('jquery');
bsCustomFileInput = require('bs-custom-file-input')
require('popper.js')
require('bootstrap')
require('mdbootstrap/js/mdb.min.js')
require('../../vendor/mdb-pro/js/addons-pro/stepper');
$(document).ready(function () {
    $('.stepper').mdbStepper();
})