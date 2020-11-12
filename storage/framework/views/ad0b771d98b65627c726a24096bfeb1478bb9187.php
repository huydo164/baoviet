<?php

use App\Library\PHPDev\FuncLib;
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\Utility;
use App\Library\PHPDev\ThumbImg;
?>

<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
    <div class="sidebar">
        <div class="widget">
            <div class="banner-spot clearfix">
                <div class="banner-img">
                    <img src="upload/banner_07.jpg" alt="" class="img-fluid">
                </div>
                <!-- end banner-img -->
            </div>
            <!-- end banner -->
        </div>
        <!-- end widget -->

        <div class="widget">
            <h2 class="widget-title">Trend Videos</h2>
            <div class="trend-videos">
                <div class="blog-box">
                    <div class="post-media">
                        <a href="tech-single.html" title="">
                            <img src="upload/tech_video_01.jpg" alt="" class="img-fluid">
                            <div class="hovereffect">
                                <span class="videohover"></span>
                            </div>
                            <!-- end hover -->
                        </a>
                    </div>
                    <!-- end media -->
                    <div class="blog-meta">
                        <h4><a href="tech-single.html" title="">We prepared the best 10 laptop presentations for you</a></h4>
                    </div>
                    <!-- end meta -->
                </div>
                <!-- end blog-box -->

                <hr class="invis">

                <div class="blog-box">
                    <div class="post-media">
                        <a href="tech-single.html" title="">
                            <img src="upload/tech_video_02.jpg" alt="" class="img-fluid">
                            <div class="hovereffect">
                                <span class="videohover"></span>
                            </div>
                            <!-- end hover -->
                        </a>
                    </div>
                    <!-- end media -->
                    <div class="blog-meta">
                        <h4><a href="tech-single.html" title="">We are guests of ABC Design Studio - Vlog</a></h4>
                    </div>
                    <!-- end meta -->
                </div>
                <!-- end blog-box -->

                <hr class="invis">

                <div class="blog-box">
                    <div class="post-media">
                        <a href="tech-single.html" title="">
                            <img src="upload/tech_video_03.jpg" alt="" class="img-fluid">
                            <div class="hovereffect">
                                <span class="videohover"></span>
                            </div>
                            <!-- end hover -->
                        </a>
                    </div>
                    <!-- end media -->
                    <div class="blog-meta">
                        <h4><a href="tech-single.html" title="">Both blood pressure monitor and intelligent clock</a></h4>
                    </div>
                    <!-- end meta -->
                </div>
                <!-- end blog-box -->
            </div>
            <!-- end videos -->
        </div>
        <!-- end widget -->

        <div class="widget">
            <h2 class="widget-title">Popular Posts</h2>
            <div class="blog-list-widget">
                <div class="list-group">
                    <?php $__currentLoopData = $popular_post; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="tech-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="w-100 justify-content-between">
                                <img src="<?php echo e(ThumbImg::thumbBaseNormal(CGlobal::FOLDER_STATICS, $item->statics_id, $item->statics_image, 800, 0, '', true, true)); ?>" alt="" class="img-fluid float-left">
                                <h5 class="mb-1"><?php echo e($item->statics_title); ?></h5>
                                <small><?php echo e(date('d/m/Y', $item->statics_date)); ?></small>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <!-- end blog-list -->
        </div>
        <!-- end widget -->



        <div class="widget">
            <h2 class="widget-title">Theo dõi chúng tôi</h2>

            <div class="row text-center">
                <div class="fb-page" data-href="https://www.facebook.com/quangcaondvmedia/" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/quangcaondvmedia/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/quangcaondvmedia/">Công ty quảng cáo ndvmedia</a></blockquote></div>
            </div>
        </div>
        <!-- end widget -->

        <div class="widget">
            <div class="banner-spot clearfix">
                <div class="banner-img">
                    <img src="upload/banner_03.jpg" alt="" class="img-fluid">
                </div>
                <!-- end banner-img -->
            </div>
            <!-- end banner -->
        </div>
        <!-- end widget -->
    </div>
    <!-- end sidebar -->
</div>
<?php /**PATH D:\wamp64\www\baoviet\app\Modules/Statics/Views/block/right.blade.php ENDPATH**/ ?>