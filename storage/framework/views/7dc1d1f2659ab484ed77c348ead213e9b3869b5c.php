<?php
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\FuncLib;
use App\Library\PHPDev\ThumbImg;
?>
<header class="tech-header header">
    <?php echo isset($messages) && ($messages != '') ? $messages : ''; ?>

    <div class="container-fluid">
        <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php if(isset($arrTextLogo) && !empty($arrTextLogo)): ?>
                <a class="navbar-brand" href="<?php echo e(FuncLib::getBaseUrl()); ?>">
                    <?php if($arrTextLogo->info_img != ''): ?>
                        <img src="<?php echo e(ThumbImg::thumbBaseNormal(CGlobal::FOLDER_INFO, $arrTextLogo['info_id'], $arrTextLogo['info_img'], 2000, 0, '',true, true )); ?>" alt="">
                    <?php endif; ?>
                </a>
            <?php endif; ?>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <?php if(isset($arrCategory) && !empty($arrCategory)): ?>
                        <?php $__currentLoopData = $arrCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($cat->category_menu == CGlobal::status_show && $cat->category_parent_id == 0): ?>
                                <?php $i=0 ?>
                                <?php $__currentLoopData = $arrCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($sub->category_menu == CGlobal::status_show && $sub->category_parent_id == $cat->category_id): ?>
                                        <?php $i++ ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item <?php if($key == 1): ?> dropdown has-submenu menu-large hidden-md-down hidden-sm-down hidden-xs-down <?php endif; ?>">
                                    <a <?php if($i > 0): ?> <?php endif; ?> title="<?php echo e($cat->category_title); ?>" class="nav-link <?php if($key == 1): ?> dropdown-toggle <?php endif; ?>" <?php if($key == 1): ?> id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?php endif; ?> href="<?php if($cat->category_link_replace != ''): ?><?php echo e($cat->category_link_replace); ?><?php else: ?><?php echo e(FuncLib::buildLinkCategory($cat->category_id, $cat->category_title)); ?><?php endif; ?>">
                                        <?php echo e($cat->category_title); ?>

                                    </a>
                                    <?php if($i > 0): ?>
                                        <ul class="dropdown-menu megamenu" aria-labelledby="dropdown01">
                                            <li>
                                                <div class="container">
                                                    <div class="mega-menu-content clearfix">
                                                        <div class="tab">
                                                            <?php $__currentLoopData = $arrCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($sub->category_menu == CGlobal::status_show && $sub->category_parent_id == $cat->category_id): ?>
                                                                    <button class="tablinks  <?php if($sub->category_id == 24): ?> active <?php endif; ?>" onclick="openCategory(event, '<?php echo e($sub->category_id); ?>')"><?php echo e($sub->category_title); ?></button>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                        <div class="tab-detail clearfix">
                                                            <?php $__currentLoopData = $arrCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($sub->category_menu == CGlobal::status_show && $sub->category_parent_id == $cat->category_id): ?>
                                                                    <div id="<?php echo e($sub->category_id); ?>" class="tabcontent <?php if($sub->category_id == 24): ?> active <?php endif; ?>">
                                                                        <div class="row">
                                                                            <?php if($sub->category_parent_id > 0): ?>
                                                                                <?php if(isset($arrStaticsByCatid) && !empty($arrStaticsByCatid)): ?>
                                                                                    <?php $__currentLoopData = $arrStaticsByCatid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                        <?php if($item->statics_catid == $sub->category_id): ?>
                                                                                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                                                                <div class="blog-box">
                                                                                                    <div class="post-media">
                                                                                                        <a href="<?php echo e(FuncLib::buildLinkCategory($item->statics_id,$item->statics_title)); ?>" title="<?php echo e($item->statics_title); ?>">
                                                                                                            <img src="<?php echo e(ThumbImg::thumbBaseNormal(CGlobal::FOLDER_STATICS,$item->statics_id,$item->statics_image,400,0,'',true, true)); ?>" alt="" class="img-fluid">
                                                                                                            <div class="hovereffect">
                                                                                                            </div><!-- end hover -->
                                                                                                            <span class="menucat"><?php echo e($sub->category_title); ?></span>
                                                                                                        </a>
                                                                                                    </div><!-- end media -->
                                                                                                    <div class="blog-meta">
                                                                                                        <h4><a href="<?php echo e(FuncLib::buildLinkCategory($item->statics_id,$item->statics_title)); ?>" title="<?php echo e($item->statics_title); ?>" title=""><?php echo e($item->statics_title); ?></a></h4>
                                                                                                    </div><!-- end meta -->
                                                                                                </div><!-- end blog-box -->
                                                                                            </div>
                                                                                        <?php endif; ?>
                                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php endif; ?>
                                                                            <?php endif; ?>
                                                                        </div><!-- end row -->
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav mr-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-rss"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-android"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-apple"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div><!-- end container-fluid -->
</header><!-- end market-header -->
<?php /**PATH D:\wamp64\www\project.vn\baoviet\app\Modules/Statics/Views/block/header.blade.php ENDPATH**/ ?>