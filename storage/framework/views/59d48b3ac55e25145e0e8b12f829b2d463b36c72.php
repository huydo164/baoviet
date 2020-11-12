<?php

use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\FuncLib;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php echo CGlobal::$extraMeta; ?>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" href="<?php echo e(FuncLib::getBaseUrl()); ?>assets/frontend/img/favicon.ico" type="image/vnd.microsoft.icon">
    <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(URL::asset('assets/libs/bootstrap/css/bootstrap.min.css')); ?>" />

	<?php echo CGlobal::$extraMeta; ?>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" href="<?php echo e(FuncLib::getBaseUrl()); ?>assets/frontend/img/favicon.ico" type="image/vnd.microsoft.icon">
    <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(URL::asset('assets/libs/bootstrap/css/bootstrap.css')); ?>" />
    <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(URL::asset('assets/libs/fontawesome-free-5.15.1-web/css/all.css')); ?>" />
    <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(URL::asset('assets/frontend/css/owl.carousel.min.css')); ?>" />
    <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(URL::asset('assets/frontend/css/font-awesome.min.css')); ?>" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(URL::asset('assets/focus/css/reset.css')); ?>" />
    <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(URL::asset('assets/frontend/css/site.css')); ?>" />
    <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(URL::asset('assets/frontend/css/site-1.css')); ?>" />
    <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(URL::asset('assets/frontend/css/media.css')); ?>" />
    <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(URL::asset('assets/frontend/css/animate.css')); ?>" />
    <link media="all" type="text/css" rel="stylesheet" href="<?php echo e(URL::asset('assets/frontend/css/bootstrap.css')); ?>" />

    <script src="<?php echo e(URL::asset('assets/focus/js/jquery.2.1.1.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/bootstrap/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('assets/libs/number/autoNumeric.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('assets/frontend/js/site.js')); ?>"></script>

    <?php echo CGlobal::$extraHeaderCSS; ?>

    <?php echo CGlobal::$extraHeaderJS; ?>

    <script type="text/javascript">
        var BASE_URL = '<?php echo e(FuncLib::getBaseUrl()); ?>';
    </script>
    <?php if(CGlobal::is_dev == 0): ?>
    <?php endif; ?>
</head>

<body>
<div id="wrapper">
    <?php echo $__env->yieldContent('header'); ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->yieldContent('footer'); ?>
</div>
<?php echo CGlobal::$extraFooterCSS; ?>

<?php echo CGlobal::$extraFooterJS; ?>

</body>

</html><?php /**PATH D:\wamp64\www\project.vn\baoviet\app\Modules/Statics/Views/layout/html.blade.php ENDPATH**/ ?>