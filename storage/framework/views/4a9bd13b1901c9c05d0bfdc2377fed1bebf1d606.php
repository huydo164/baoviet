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
    <section class="section first-section">
        <div class="container-fluid">
            <div class="masonry-blog clearfix">
                <?php $__currentLoopData = $data_first; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key == 0): ?>
                        <div class="first-slot">
                            <div class="masonry-box post-media">
                                <img src="https://genk.mediacdn.vn/thumb_w/640/2019/10/16/pixel-image-1-15711948680921149315497-crop-15711968629591144940646.jpg" alt="">
                                <div class="shadoweffect">
                                    <div class="shadow-desc">
                                        <div class="blog-meta">
                                            <span class="bg-orange"><a href="tech-category-01.html" title=""><?php echo e($item->statics_cat_name); ?></a></span>
                                            <h4><a href="tech-single.html" title=""><?php echo e($item->statics_title); ?></a></h4>
                                            <small><a href="tech-single.html" title=""><?php echo e(date('d/m/Y', $item->statics_date)); ?></a></small>
                                            <small><a href="tech-author.html" title="">by Amanda</a></small>
                                        </div>
                                        <!-- end meta -->
                                    </div>
                                    <!-- end shadow-desc -->
                                </div>
                                <!-- end shadow -->
                            </div>
                            <!-- end post-media -->
                        </div>
                        <!-- end first-side -->
                    <?php elseif($key == 1): ?>
                        <div class="second-slot">
                            <div class="masonry-box post-media">
                                <img src="https://genk.mediacdn.vn/thumb_w/640/2019/10/16/pixel-image-1-15711948680921149315497-crop-15711968629591144940646.jpg" alt="">

                                <div class="shadoweffect">
                                    <div class="shadow-desc">
                                        <div class="blog-meta">
                                            <span class="bg-orange"><a href="tech-category-01.html" title=""><?php echo e($item->statics_cat_name); ?></a></span>
                                            <h4><a href="tech-single.html" title=""><?php echo e($item->statics_title); ?></a></h4>
                                            <small><a href="tech-single.html" title=""><?php echo e(date('d/m/Y', $item->statics_date)); ?></a></small>
                                            <small><a href="tech-author.html" title="">by Jessica</a></small>
                                        </div>
                                        <!-- end meta -->
                                    </div>
                                    <!-- end shadow-desc -->
                                </div>
                                <!-- end shadow -->
                            </div>
                            <!-- end post-media -->
                        </div>
                        <!-- end second-side -->
                    <?php elseif($key == 2): ?>
                        <div class="last-slot">
                            <div class="masonry-box post-media">
                                <img src="https://genk.mediacdn.vn/thumb_w/640/2019/10/16/pixel-image-1-15711948680921149315497-crop-15711968629591144940646.jpg" alt="">
                                <div class="shadoweffect">
                                    <div class="shadow-desc">
                                        <div class="blog-meta">
                                            <span class="bg-orange"><a href="tech-category-01.html" title=""><?php echo e($item->statics_cat_name); ?></a></span>
                                            <h4><a href="tech-single.html" title=""><?php echo e($item->statics_title); ?></a></h4>
                                            <small><a href="tech-single.html" title=""><?php echo e(date('d/m/Y', $item->statics_date)); ?></a></small>
                                            <small><a href="tech-author.html" title="">by Jessica</a></small>
                                        </div>
                                        <!-- end meta -->
                                    </div>
                                    <!-- end shadow-desc -->
                                </div>
                                <!-- end shadow -->
                            </div>
                            <!-- end post-media -->
                        </div>
                        <!-- end second-side -->'
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <!-- end masonry -->
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-wrapper">
                        <div class="blog-top clearfix">
                            <h4 class="pull-left">Recent News <a href="#"><i class="fa fa-rss"></i></a></h4>
                        </div>
                        <!-- end blog-top -->

                        <div class="blog-list clearfix">
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="blog-box row">
                                    <div class="col-md-4">
                                        <div class="post-media">
                                            <a href="tech-single.html" title="">
                                                <?php if($item->statics_image != ''): ?>
                                                    <img src="<?php echo e(ThumbImg::thumbBaseNormal(CGlobal::FOLDER_STATICS, $item->statics_id, $item->statics_image, 800, 0, '', true, true)); ?>" alt="">
                                                <?php endif; ?>
                                                <div class="hovereffect"></div>
                                            </a>
                                        </div>
                                        <!-- end media -->
                                    </div>
                                    <!-- end col -->

                                    <div class="blog-meta big-meta col-md-8">
                                        <h4><a href="tech-single.html" title=""><?php echo e($item->statics_title); ?></a></h4>
                                        <p>Aenean interdum arcu blandit, vehicula magna non, placerat elit. Mauris et pharetratortor. Suspendissea sodales urna. In at augue elit. Vivamus enim nibh, maximus ac felis nec, maximus tempor odio.</p>
                                        <small class="firstsmall"><a class="bg-orange" href="tech-category-01.html" title=""><?php echo e($item->statics_cat_name); ?></a></small>
                                        <small><a href="tech-single.html" title=""><?php echo e(date('d/m/Y', $item->statics_date)); ?></a></small>
                                        <small><a href="tech-author.html" title="">by Matilda</a></small>
                                        <small><a href="tech-single.html" title=""><i class="fa fa-eye"></i> <?php echo e($item->statics_view_num); ?></a></small>
                                    </div>
                                    <!-- end meta -->
                                </div>
                                <!-- end blog-box -->

                                <hr class="invis">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </div>
                        <!-- end blog-list -->
                    </div>
                    <!-- end page-wrapper -->

                    <hr class="invis">

                    <div class="row">
                        <div class="col-md-12">
                            <?php if(isset($data) && $data->count() > 1): ?>
                                <div class="listPaginatePage">
                                    <div class="showListPage"><?php echo $paging; ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end col -->

            <?php echo $__env->make('Statics::block.right', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Statics::layout.html', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\baoviet\app\Modules/Statics/Views/content/index.blade.php ENDPATH**/ ?>