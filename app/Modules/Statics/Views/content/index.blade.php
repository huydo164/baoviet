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
    <section class="section first-section">
        <div class="container-fluid">
            <div class="masonry-blog clearfix">
                @foreach($data_first as $key => $item)
                    @if($key == 0)
                        <div class="first-slot">
                            <div class="masonry-box post-media">
                                <img src="https://genk.mediacdn.vn/thumb_w/640/2019/10/16/pixel-image-1-15711948680921149315497-crop-15711968629591144940646.jpg" alt="">
                                <div class="shadoweffect">
                                    <div class="shadow-desc">
                                        <div class="blog-meta">
                                            <span class="bg-orange"><a href="tech-category-01.html" title="">{{ $item->statics_cat_name }}</a></span>
                                            <h4><a href="tech-single.html" title="">{{ $item->statics_title }}</a></h4>
                                            <small><a href="tech-single.html" title="">{{ date('d/m/Y', $item->statics_date) }}</a></small>
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
                    @elseif($key == 1)
                        <div class="second-slot">
                            <div class="masonry-box post-media">
                                <img src="https://genk.mediacdn.vn/thumb_w/640/2019/10/16/pixel-image-1-15711948680921149315497-crop-15711968629591144940646.jpg" alt="">

                                <div class="shadoweffect">
                                    <div class="shadow-desc">
                                        <div class="blog-meta">
                                            <span class="bg-orange"><a href="tech-category-01.html" title="">{{ $item->statics_cat_name }}</a></span>
                                            <h4><a href="tech-single.html" title="">{{ $item->statics_title }}</a></h4>
                                            <small><a href="tech-single.html" title="">{{ date('d/m/Y', $item->statics_date) }}</a></small>
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
                    @elseif($key == 2)
                        <div class="last-slot">
                            <div class="masonry-box post-media">
                                <img src="https://genk.mediacdn.vn/thumb_w/640/2019/10/16/pixel-image-1-15711948680921149315497-crop-15711968629591144940646.jpg" alt="">
                                <div class="shadoweffect">
                                    <div class="shadow-desc">
                                        <div class="blog-meta">
                                            <span class="bg-orange"><a href="tech-category-01.html" title="">{{ $item->statics_cat_name }}</a></span>
                                            <h4><a href="tech-single.html" title="">{{ $item->statics_title }}</a></h4>
                                            <small><a href="tech-single.html" title="">{{ date('d/m/Y', $item->statics_date) }}</a></small>
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
                    @endif
                @endforeach
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
                            @foreach($data as $key=>$item)
                                <div class="blog-box row">
                                    <div class="col-md-4">
                                        <div class="post-media">
                                            <a href="tech-single.html" title="">
                                                @if($item->statics_image != '')
                                                    <img src="{{ ThumbImg::thumbBaseNormal(CGlobal::FOLDER_STATICS, $item->statics_id, $item->statics_image, 800, 0, '', true, true) }}" alt="">
                                                @endif
                                                <div class="hovereffect"></div>
                                            </a>
                                        </div>
                                        <!-- end media -->
                                    </div>
                                    <!-- end col -->

                                    <div class="blog-meta big-meta col-md-8">
                                        <h4><a href="tech-single.html" title="">{{ $item->statics_title }}</a></h4>
                                        <p>Aenean interdum arcu blandit, vehicula magna non, placerat elit. Mauris et pharetratortor. Suspendissea sodales urna. In at augue elit. Vivamus enim nibh, maximus ac felis nec, maximus tempor odio.</p>
                                        <small class="firstsmall"><a class="bg-orange" href="tech-category-01.html" title="">{{ $item->statics_cat_name }}</a></small>
                                        <small><a href="tech-single.html" title="">{{ date('d/m/Y', $item->statics_date) }}</a></small>
                                        <small><a href="tech-author.html" title="">by Matilda</a></small>
                                        <small><a href="tech-single.html" title=""><i class="fa fa-eye"></i> {{ $item->statics_view_num }}</a></small>
                                    </div>
                                    <!-- end meta -->
                                </div>
                                <!-- end blog-box -->

                                <hr class="invis">
                            @endforeach


                        </div>
                        <!-- end blog-list -->
                    </div>
                    <!-- end page-wrapper -->

                    <hr class="invis">

                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($data) && $data->count() > 1)
                                <div class="listPaginatePage">
                                    <div class="showListPage">{!! $paging !!}</div>
                                </div>
                            @endif
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end col -->

            @include('Statics::block.right')
            <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
@stop
