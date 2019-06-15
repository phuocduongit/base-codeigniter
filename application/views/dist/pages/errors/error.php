<div class=" d-flex" style="margin-top:20px;">
<div class="container align-self-center">
        <div class="card ">
            <div class="card-header">
                <h3><?=(isset($title))?$title:"Lỗi"?></h3>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" role="alert">
                <?=(isset($description))?$description:"ôi! lỗi rồi"?>
                </div>
            </div>
            <div class="card-footer text-muted">
                <a href="<?=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/"?>" class="btn btn-primary btn-lg text-light">Quay lại</a>
            </div>
        </div>
    </div>
</div>