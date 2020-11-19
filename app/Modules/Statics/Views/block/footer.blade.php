<?php

use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\FuncLib;
use App\Library\PHPDev\ThumbImg;
?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="widget">
                    <div class="footer-text text-left">
                        @if(isset($arrTextLogo) && !empty($arrTextLogo))
                            <a href="{{ FuncLib::getBaseUrl() }}">
                                <img src="{{ ThumbImg::thumbBaseNormal(CGlobal::FOLDER_INFO, $arrTextLogo['info_id'], $arrTextLogo['info_img'], 2000, 0, '',true, true ) }}" alt="" class="img-fluid">
                            </a>
                        @endif
                        <p>{!! isset($textFooter) ? strip_tags($textFooter) : '' !!}</p>
                        <div class="social">
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Facebook"><i class="fa fa-facebook"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Twitter"><i class="fa fa-twitter"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Instagram"><i class="fa fa-instagram"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Google Plus"><i class="fa fa-google-plus"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Pinterest"><i class="fa fa-pinterest"></i></a>
                        </div>

                        <hr class="invis">

                        <div class="newsletter-widget text-left">
                            <form class="form-inline">
                                <input type="text" class="form-control" placeholder="Enter your email address">
                                <button type="submit" class="btn btn-primary">Gửi</button>
                            </form>
                        </div>
                        <!-- end newsletter -->
                    </div>
                    <!-- end footer-text -->
                </div>
                <!-- end widget -->
            </div>
            <!-- end col -->

            <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <div class="widget">
                    <h2 class="widget-title">{!! isset($title_footer_center) ? $title_footer_center : '' !!}</h2>
                    <div class="link-widget">
                        {!! isset($site_footer_center) ? $site_footer_center : '' !!}
                    </div>
                    <!-- end link-widget -->
                </div>
                <!-- end widget -->
            </div>
            <!-- end col -->

            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                <div class="widget">
                    <h2 class="widget-title">{!! isset($title_footer_right) ? $title_footer_right : '' !!}</h2>
                    <div class="link-widget">
                        {!! isset($site_footer_right) ? $site_footer_right : '' !!}
                    </div>
                    <!-- end link-widget -->
                </div>
                <!-- end widget -->
            </div>
            <!-- end col -->
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <br>
                <div class="copyright">{!! isset($copyright) ? $copyright : '' !!}</div>
            </div>
        </div>
    </div>
    <!-- end container -->
</footer>
<!-- end footer -->

<div class="dmtop">Scroll to Top</div>

