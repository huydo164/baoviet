<?php
use App\Library\PHPDev\FuncLib;
?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('Statics::block.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('Statics::block.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="wrap-page">
	<div class="line">
		<div class="page-access">
			<div class="wrap-page-access">
				<div class="box-page-access">
                    <div class="page-access-left">
                        <div class="title-access">404</div>
                    </div>
                    <div class="page-access-right">
                        <img src="<?php echo e(FuncLib::getBaseUrl()); ?>assets/frontend/img/access.png" alt="" title="">
                        <div class="desc-access"><?php echo e($txt404); ?></div>
                        <div class="link-access"><a href="<?php echo e(FuncLib::getBaseUrl()); ?>">Trở về trang chủ</a></div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Statics::layout.html', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\project.vn\baoviet\app\Modules/Statics/Views/errors/page-404.blade.php ENDPATH**/ ?>