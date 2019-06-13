<!DOCTYPE html>
<html lang="en">
<?php $this->load->view($path_layout."/partials/head") ?>

<body>
    <h1>MENU</h1>
    <div class="content">
        <?php echo $content_view;?>
    </div>
    <?php $this->load->view($path_layout."/partials/script") ?>
</body>
</html>