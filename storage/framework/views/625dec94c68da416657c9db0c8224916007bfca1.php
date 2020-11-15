<?php

use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\ThumbImg;
use App\Library\PHPDev\FuncLib;
?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('Admin::block.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('left'); ?>
    <?php echo $__env->make('Admin::block.left', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="<?php echo e(URL::route('admin.dashboard')); ?>">Trang chủ</a>
                    </li>
                    <li class="active"><?php if($id==0): ?>Thêm mới <?php else: ?> Sửa <?php endif; ?> bài viết tĩnh</li>
                </ul>
            </div>

            <
            <div class="page-content">
                <div class="col-xs-12">
                    <div class="row">
                        <?php if(isset($error) && $error != ''): ?>
                            <div class="alert-admin alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form class="form-horizontal paddingTop30" name="txtForm" action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 mb-12">
                                    <div class="nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
                                        <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
                                            <li class="nav-item active" role="presentation">
                                                <a class="nav-link active" data-toggle="tab" href="#tabNoiDung" aria-controls="tabNoiDung" role="tab">
                                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                    Nội dung
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content pt-10">
                                            <div class="tab-pane panelDetail active" id="tabNoiDung" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="clearfix"></div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Sản phẩm đánh giá<span>*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" class="form-control input-sm" name="statics_id" value="<?php if(isset($data['statics_id'])): ?><?php echo e($data['statics_id']); ?><?php endif; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Tên người đánh giá<span>*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" class="form-control input-sm" name="comment_name" value="<?php if(isset($data['comment_name'])): ?><?php echo e($data['comment_name']); ?><?php endif; ?>">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="clearfix"></div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Email<span>*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" class="form-control input-sm" name="comment_email" value="<?php if(isset($data['comment_email'])): ?><?php echo e($data['comment_email']); ?><?php endif; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Comment<span>*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" class="form-control input-sm" name="comment_detail" value="<?php if(isset($data['comment_detail'])): ?><?php echo e($data['comment_detail']); ?><?php endif; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>

                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Địa chỉ IP<span>*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" class="form-control input-sm" name="comment_ip" value="<?php if(isset($data['comment_ip'])): ?><?php echo e($data['comment_ip']); ?><?php endif; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Trạng thái<span>*</span></label>
                                                                <div class="controls">
                                                                    <select name="rating_status" >
                                                                        <option value="0" <?php if(isset($data['comment_status']) == 0): ?>  selected="selected" <?php endif; ?>>Ẩn</option>
                                                                        <option value="1" <?php if(isset($data['comment_status']) == 1): ?>  selected="selected" <?php endif; ?>>Hiện</option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="panel-footer clearfix">
                                            <div class="form-inline float-right">
                                                <div class="form-row">
                                                    <?php echo csrf_field(); ?>

                                                    <input type="hidden" id="id_hiden" name="id_hiden" value="<?php echo e($id); ?>" />
                                                    <button type="submit" name="txtSubmit" id="buttonSubmit" class="btn btn-primary btn-sm">Lưu lại</button>
                                                    <button type="reset" class="btn btn-sm">Bỏ qua</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('Admin::layout.html', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\baoviet\app\Modules/Admin/Views/comment/add.blade.php ENDPATH**/ ?>