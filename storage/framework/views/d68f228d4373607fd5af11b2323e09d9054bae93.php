<?php
use App\Library\PHPDev\FuncLib;
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\Utility;
use App\Library\PHPDev\ThumbImg;
?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('Statics::block.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('Statics::block.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="page-title lb single-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <h2>
                        <i class="fa fa-play bg-orange"></i>
                        <?php if(isset($dataCate)): ?>
                            <?php echo e($dataCate->category_title); ?>

                        <?php endif; ?>
                        <small class="hidden-xs-down hidden-sm-down"><?php echo isset($text_title_video) ? strip_tags($text_title_video) : ''; ?></small>
                    </h2>
                </div><!-- end col -->
                <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(FuncLib::getBaseUrl()); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Blog</a></li>
                        <li class="breadcrumb-item active">
                            <?php if(isset($dataCate)): ?>
                                <?php echo e($dataCate->category_title); ?>

                            <?php endif; ?>
                        </li>
                    </ol>
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end page-title -->

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-wrapper">
                        <div class="blog-custom-build">
                            <?php if(isset($data) && !empty($data)): ?>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="blog-box">
                                        <div class="post-media">
                                            <a href="<?php echo e(FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title)); ?>" title="">
                                                <?php if($item->video_image != ''): ?>
                                                    <img src="<?php echo e(ThumbImg::thumbBaseNormal(CGlobal::FOLDER_VIDEO, $item->video_id, $item->video_image, 600, 0, '', true, true)); ?>" alt="<?php echo e($item->video_title); ?>" class="img-fluid">
                                                <?php endif; ?>
                                                <div class="hovereffect">
                                                    <span class="videohover"></span>
                                                </div>
                                                <!-- end hover -->
                                            </a>
                                        </div>
                                        <!-- end media -->
                                        <div class="blog-meta big-meta text-center">
                                            <div class="post-sharing">
                                                <ul class="list-inline">
                                                    <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                                    <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                                    <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                                </ul>
                                            </div><!-- end post-sharing -->
                                            <h4><a href="<?php echo e(FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title)); ?>" title=""><?php echo e($item->video_title); ?></a></h4>
                                            <p><?php echo e($item->video_intro); ?></p>
                                            <small><a href="<?php echo e(FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title)); ?>" title=""><?php if(isset($dataCate)): ?>
                                                        <?php echo e($dataCate->category_title); ?>

                                                    <?php endif; ?></a></small>
                                            <small><a href="<?php echo e(FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title)); ?>" title=""><?php echo e(date('d-m-Y', $item->video_created)); ?></a></small>
                                            <small><a href="<?php echo e(FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title)); ?>" title="">by <?php if(isset($users['user_full_name']) && $users['user_full_name'] != ''): ?> <?php echo e($users['user_full_name']); ?> <?php endif; ?></a></small>
                                            <small><a href="#" title=""><i class="fa fa-eye"></i> <?php echo e($item->video_view_num); ?></a></small>
                                        </div><!-- end meta -->
                                    </div><!-- end blog-box -->
                                    <hr class="invis">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <?php if($total>0): ?>
                            <div class="show-bottom-info">
                                <div class="list-item-page">
                                    <div class="showListPage"><?php echo $paging; ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div><!-- end col -->

                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                    <?php echo $__env->make('Statics::block.right', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div><!-- end col -->
            </div>
        </div><!-- end container -->
    </section>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('Statics::layout.html', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\project.vn\baoviet\app\Modules/Statics/Views/content/pageVideo.blade.php ENDPATH**/ ?>