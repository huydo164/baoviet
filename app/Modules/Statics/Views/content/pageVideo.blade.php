<?php
use App\Library\PHPDev\FuncLib;
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\Utility;
use App\Library\PHPDev\ThumbImg;
?>
@extends('Statics::layout.html')
@section('header')
    @include('Statics::block.header')
@stop
@section('footer')
    @include('Statics::block.footer')
@stop
@section('content')

    <div class="page-title lb single-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <h2>
                        <i class="fa fa-play bg-orange"></i>
                        @if(isset($dataCate))
                            {{ $dataCate->category_title }}
                        @endif
                        <small class="hidden-xs-down hidden-sm-down">{!! isset($text_title_video) ? strip_tags($text_title_video) : '' !!}</small>
                    </h2>
                </div><!-- end col -->
                <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{FuncLib::getBaseUrl()}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Blog</a></li>
                        <li class="breadcrumb-item active">
                            @if(isset($dataCate))
                                {{ $dataCate->category_title }}
                            @endif
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
                            @if(isset($data) && !empty($data))
                                @foreach($data as $key => $item)
                                    <div class="blog-box">
                                        <div class="post-media">
                                            <a href="{{ FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title) }}" title="">
                                                @if($item->video_image != '')
                                                    <img src="{{ ThumbImg::thumbBaseNormal(CGlobal::FOLDER_VIDEO, $item->video_id, $item->video_image, 600, 0, '', true, true) }}" alt="{{$item->video_title}}" class="img-fluid">
                                                @endif
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
                                            <h4><a href="{{ FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title) }}" title="">{{ $item->video_title }}</a></h4>
                                            <p>{{ $item->video_intro }}</p>
                                            <small><a href="{{ FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title) }}" title="">@if(isset($dataCate))
                                                        {{ $dataCate->category_title }}
                                                    @endif</a></small>
                                            <small><a href="{{ FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title) }}" title="">{{date('d-m-Y', $item->video_created)}}</a></small>
                                            <small><a href="{{ FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title) }}" title="">by Amanda</a></small>
                                            <small><a href="#" title=""><i class="fa fa-eye"></i> {{$item->video_view_num}}</a></small>
                                        </div><!-- end meta -->
                                    </div><!-- end blog-box -->
                                    <hr class="invis">
                                @endforeach
                            @endif
                        </div>
                        @if($total>0)
                            <div class="show-bottom-info">
                                <div class="list-item-page">
                                    <div class="showListPage">{!! $paging !!}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div><!-- end col -->

                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                    <div class="sidebar">
                        <div class="widget">
                            <div class="banner-spot clearfix">
                                <div class="banner-img">
                                    <img src="upload/banner_07.jpg" alt="" class="img-fluid">
                                </div><!-- end banner-img -->
                            </div><!-- end banner -->
                        </div><!-- end widget -->

                        <div class="widget">
                            <h2 class="widget-title">Trend Videos</h2>
                            <div class="trend-videos">
                                <div class="blog-box">
                                    <div class="post-media">
                                        <a href="tech-single.html" title="">
                                            <img src="upload/tech_video_01.jpg" alt="" class="img-fluid">
                                            <div class="hovereffect">
                                                <span class="videohover"></span>
                                            </div><!-- end hover -->
                                        </a>
                                    </div><!-- end media -->
                                    <div class="blog-meta">
                                        <h4><a href="tech-single.html" title="">We prepared the best 10 laptop presentations for you</a></h4>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->

                                <hr class="invis">

                                <div class="blog-box">
                                    <div class="post-media">
                                        <a href="tech-single.html" title="">
                                            <img src="upload/tech_video_02.jpg" alt="" class="img-fluid">
                                            <div class="hovereffect">
                                                <span class="videohover"></span>
                                            </div><!-- end hover -->
                                        </a>
                                    </div><!-- end media -->
                                    <div class="blog-meta">
                                        <h4><a href="tech-single.html" title="">We are guests of ABC Design Studio - Vlog</a></h4>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->

                                <hr class="invis">

                                <div class="blog-box">
                                    <div class="post-media">
                                        <a href="tech-single.html" title="">
                                            <img src="upload/tech_video_03.jpg" alt="" class="img-fluid">
                                            <div class="hovereffect">
                                                <span class="videohover"></span>
                                            </div><!-- end hover -->
                                        </a>
                                    </div><!-- end media -->
                                    <div class="blog-meta">
                                        <h4><a href="tech-single.html" title="">Both blood pressure monitor and intelligent clock</a></h4>
                                    </div><!-- end meta -->
                                </div><!-- end blog-box -->
                            </div><!-- end videos -->
                        </div><!-- end widget -->

                        <div class="widget">
                            <h2 class="widget-title">Popular Posts</h2>
                            <div class="blog-list-widget">
                                <div class="list-group">
                                    <a href="tech-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 justify-content-between">
                                            <img src="upload/tech_blog_08.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">5 Beautiful buildings you need..</h5>
                                            <small>12 Jan, 2016</small>
                                        </div>
                                    </a>

                                    <a href="tech-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 justify-content-between">
                                            <img src="upload/tech_blog_01.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">Let's make an introduction for..</h5>
                                            <small>11 Jan, 2016</small>
                                        </div>
                                    </a>

                                    <a href="tech-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 last-item justify-content-between">
                                            <img src="upload/tech_blog_03.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">Did you see the most beautiful..</h5>
                                            <small>07 Jan, 2016</small>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- end blog-list -->
                        </div><!-- end widget -->

                        <div class="widget">
                            <h2 class="widget-title">Recent Reviews</h2>
                            <div class="blog-list-widget">
                                <div class="list-group">
                                    <a href="tech-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 justify-content-between">
                                            <img src="upload/tech_blog_02.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">Banana-chip chocolate cake recipe..</h5>
                                            <span class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </span>
                                        </div>
                                    </a>

                                    <a href="tech-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 justify-content-between">
                                            <img src="upload/tech_blog_03.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">10 practical ways to choose organic..</h5>
                                            <span class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </span>
                                        </div>
                                    </a>

                                    <a href="tech-single.html" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="w-100 last-item justify-content-between">
                                            <img src="upload/tech_blog_07.jpg" alt="" class="img-fluid float-left">
                                            <h5 class="mb-1">We are making homemade ravioli..</h5>
                                            <span class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </span>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- end blog-list -->
                        </div><!-- end widget -->

                        <div class="widget">
                            <h2 class="widget-title">Follow Us</h2>

                            <div class="row text-center">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <a href="#" class="social-button facebook-button">
                                        <i class="fa fa-facebook"></i>
                                        <p>27k</p>
                                    </a>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <a href="#" class="social-button twitter-button">
                                        <i class="fa fa-twitter"></i>
                                        <p>98k</p>
                                    </a>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <a href="#" class="social-button google-button">
                                        <i class="fa fa-google-plus"></i>
                                        <p>17k</p>
                                    </a>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <a href="#" class="social-button youtube-button">
                                        <i class="fa fa-youtube"></i>
                                        <p>22k</p>
                                    </a>
                                </div>
                            </div>
                        </div><!-- end widget -->

                        <div class="widget">
                            <div class="banner-spot clearfix">
                                <div class="banner-img">
                                    <img src="upload/banner_03.jpg" alt="" class="img-fluid">
                                </div><!-- end banner-img -->
                            </div><!-- end banner -->
                        </div><!-- end widget -->
                    </div><!-- end sidebar -->
                </div><!-- end col -->
            </div>
        </div><!-- end container -->
    </section>


@stop