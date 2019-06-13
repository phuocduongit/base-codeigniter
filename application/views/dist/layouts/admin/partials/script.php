<?php stack('scriptsdata');?>

<!-- <script src="<?= assets_url() ?>/dist/vendor/manifest.js" type="text/javascript"></script> -->
<script src="<?= assets_url() ?>/dist/vendor/vendor.js" type="text/javascript"></script>
<script src="<?= assets_url() ?>/dist/app/app.js" type="text/javascript"></script>
<!-- <script src="<?= assets_url() ?>/dist/themes/metronic/scripts.bundle.min.js" type="text/javascript"></script> -->
<?php load_script();?>
<?php stack('scripts');?>