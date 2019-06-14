<!DOCTYPE html>
<html lang="en">
<?php $this->load->view($path_layout."/partials/head") ?>
<body>
    <?php $this->load->view($path_layout."template-parts/header-top") ?>
    <main>
        <?php echo $content_view;?>
    </main>
    <?php $this->load->view($path_layout."template-parts/footer") ?>
    <?php $this->load->view($path_layout."/partials/script") ?>
</body>

</html>