<?php

use App\Library\PHPDev\FuncLib;
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\Utility;
use App\Library\PHPDev\ThumbImg;
?>

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
        <h2 class="widget-title">{!! isset($text_trend_video) ? $text_trend_video : '' !!}</h2>
        <div class="trend-videos">
            @if(isset($data_video) && !empty($data_video))
                @foreach($data_video as $item)
                    <div class="blog-box">
                        <div class="post-media">
                            <a href="{{FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title)}}" title="{{$item->video_title}}">
                                @if($item->video_image != '')
                                    <img src="{{ ThumbImg::thumbBaseNormal(CGlobal::FOLDER_VIDEO,$item->video_id,$item->video_image,800,0,'', true,true) }}" alt="" class="img-fluid">
                                    <div class="hovereffect">
                                        <span class="videohover"></span>
                                    </div>
                                    <!-- end hover -->
                                @endif
                            </a>
                        </div>
                        <!-- end media -->
                        <div class="blog-meta">
                            <h4><a href="{{FuncLib::buildLinkDetailVideo($item->video_id,$item->video_title)}}" title="{{$item->video_title}}">{{stripcslashes($item->video_title)}}</a></h4>
                        </div>
                        <!-- end meta -->
                    </div>
                    <hr class="invis">
                @endforeach
            @endif
        </div>
        <!-- end videos -->
    </div>
    <!-- end widget -->

    <div class="widget">
        <h2 class="widget-title">Popular Posts</h2>
        <div class="blog-list-widget">
            <div class="list-group">
                @foreach($popular_post as $item)
                    <a href="tech-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="w-100 justify-content-between">
                            <img src="{{ThumbImg::thumbBaseNormal(CGlobal::FOLDER_STATICS, $item->statics_id, $item->statics_image, 800, 0, '', true, true)}}" alt="" class="img-fluid float-left">
                            <h5 class="mb-1">{{ $item->statics_title }}</h5>
                            <small>{{ date('d/m/Y', $item->statics_date) }}</small>
                        </div>
                    </a>
                @endforeach
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