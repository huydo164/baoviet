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
    <?php if(isset($data)): ?>
        <section class="section single-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        <div class="page-wrapper">
                            <div class="blog-title-area text-center">
                                <ol class="breadcrumb hidden-xs-down">
                                    <li class="breadcrumb-item"><a href="<?php echo e(FuncLib::getBaseUrl()); ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Blog</a></li>
                                    <li class="breadcrumb-item active"><?php echo e($data->video_title); ?></li>
                                </ol>

                                <span class="color-orange"><a href="" title=""><?php echo e($dataCate->category_title); ?></a></span>

                                <h3><?php echo e($data->video_title); ?></h3>

                                <div class="blog-meta big-meta">
                                    <small><a href="" title=""><?php echo e($data->video_cat_name); ?></a></small>
                                    <small><a href="<?php echo e(FuncLib::buildLinkAuthor($data->author_id, $data->author_name)); ?>" title="">by <?php echo e($data->author_name); ?></a></small>
                                    <small><a href="#" title=""><i class="fa fa-eye"></i> <?php echo e($data->video_view_num); ?></a></small>
                                </div>
                                <!-- end meta -->

                                <div class="post-sharing">
                                    <ul class="list-inline">
                                        <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                        <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                        <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                                <!-- end post-sharing -->
                            </div>
                            <!-- end title -->

                            <div class="single-post-media">
                                <?php if(isset($data['video_path'])): ?>
                                    <div class="video-upload" style="display: inline-block; text-align: center" >
                                        <video width="100%" controls>
                                            <source src="<?php echo e(FuncLib::getBaseUrl().'uploads/'.CGlobal::FOLDER_VIDEO_1.'/'.$data['video_id'].'/'.$data['video_path']); ?>" type="video/mp4">
                                            <source src="<?php echo e(FuncLib::getBaseUrl().'uploads/'.CGlobal::FOLDER_VIDEO_1.'/'.$data['video_id'].'/'.$data['video_path']); ?>" type="video/mp4">
                                        </video>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- end media -->

                            <div class="blog-content">
                                <?php echo stripslashes($data->video_content); ?>

                            </div>
                            <!-- end content -->

                            <div class="blog-title-area">
                                <div class="tag-cloud-single">
                                    <span>Tags</span>
                                    <?php if(isset($dataTags) && sizeof($dataTags)>0): ?>
                                        <?php $__currentLoopData = $dataTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <small><a href="#" title=""><?php echo e($item); ?></a></small>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                </div>
                                <!-- end meta -->

                                <div class="post-sharing">
                                    <ul class="list-inline">
                                        <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                        <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                        <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                                <!-- end post-sharing -->
                            </div>
                            <!-- end title -->

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="banner-spot clearfix">
                                        <div class="banner-img">
                                            <img src="upload/banner_01.jpg" alt="" class="img-fluid">
                                        </div>
                                        <!-- end banner-img -->
                                    </div>
                                    <!-- end banner -->
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                            <hr class="invis1">
                            <div class="custombox authorbox clearfix">
                                <h4 class="small-title">About author</h4>
                                <div class="row">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                        <img src="upload/author.jpg" alt="" class="img-fluid rounded-circle">
                                    </div>
                                    <!-- end col -->

                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                        <h4><a href="#">Jessica</a></h4>
                                        <p>Quisque sed tristique felis. Lorem <a href="#">visit my website</a> amet, consectetur adipiscing elit. Phasellus quis mi auctor, tincidunt nisl eget, finibus odio. Duis tempus elit quis risus congue feugiat. Thanks for
                                            stop Tech Blog!</p>

                                        <div class="topsocial">
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i class="fa fa-facebook"></i></a>
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Youtube"><i class="fa fa-youtube"></i></a>
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Pinterest"><i class="fa fa-pinterest"></i></a>
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Twitter"><i class="fa fa-twitter"></i></a>
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Instagram"><i class="fa fa-instagram"></i></a>
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Website"><i class="fa fa-link"></i></a>
                                        </div>
                                        <!-- end social -->

                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end author-box -->

                            <hr class="invis1">

                            <div class="custombox clearfix">
                                <h4 class="small-title">You may also like</h4>
                                <div class="row">
                                    <?php $__currentLoopData = $dataSame; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-lg-6">
                                            <div class="blog-box">
                                                <div class="post-media">
                                                    <a href="<?php echo e(FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title)); ?>" title="">
                                                        <img src="<?php echo e(ThumbImg::thumbBaseNormal(CGlobal::FOLDER_VIDEO, $item->video_id, $item->video_image, 800, 300, '', true, true)); ?>" alt="" class="img-fluid">
                                                        <div class="hovereffect">
                                                            <span class=""></span>
                                                        </div>
                                                        <!-- end hover -->
                                                    </a>
                                                </div>
                                                <!-- end media -->
                                                <div class="blog-meta">
                                                    <h4><a href="<?php echo e(FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title)); ?>" title=""><?php echo e($item->video_title); ?></a></h4>
                                                    <small><a href="<?php echo e(FuncLib::getBaseUrl()); ?>" title=""><?php echo e($item->video_cat_name); ?></a></small>
                                                    <small><a href="#" title=""><?php echo e(date('d/m/Y', $item->video_created)); ?></a></small>
                                                </div>
                                                <!-- end meta -->
                                            </div>
                                            <!-- end blog-box -->
                                        </div>
                                        <!-- end col -->

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end custom-box -->

                            <hr class="invis1">

                            <div class="custombox clearfix">
                                <?php if(isset($comment)): ?>
                                    <h4 class="small-title"> <?php echo e(sizeof($comment)); ?> Comments</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="comments-list">
                                                <?php $__currentLoopData = $comment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <h4 class="media-heading user_name"><?php echo e($item->comment_name); ?> <small>5 days ago</small></h4>
                                                            <p><?php echo e($item->comment_detail); ?></p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                            <?php endif; ?>
                            <!-- end row -->
                            </div>
                            <!-- end custom-box -->

                            <hr class="invis1">

                            <div class="custombox clearfix">
                                <h4 class="small-title">Leave a Reply</h4>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-wrapper" >
                                            <input type="text" class="form-control" name="comment_name" id="comment_name" placeholder="Your name">
                                            <input type="text" class="form-control" name="comment_email" id="comment_email" placeholder="Email address">
                                            <input type="text" class="form-control" name="comment_web" id="comment_web" placeholder="Website">
                                            <textarea class="form-control" name="comment_details" id="comment_details" placeholder="Your comment"></textarea>
                                            <input type="hidden" id="statics_id" value="<?php echo e($data->video_id); ?>">
                                            <?php echo e(csrf_field()); ?>

                                            <button type="submit" class="btn btn-primary" id="comment_submit">Bình luận</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page-wrapper -->
                    </div>
                    <!-- end col -->

                <?php echo $__env->make('Statics::block.right', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Statics::layout.html', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\project.vn\baoviet\app\Modules/Statics/Views/content/videoDetail.blade.php ENDPATH**/ ?>