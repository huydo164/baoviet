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
                                            <small><a href="{{ FuncLib::buildLinkDetailVideo($item->video_id, $item->video_title) }}" title="">by @if(isset($users['user_full_name']) && $users['user_full_name'] != '') {{$users['user_full_name']}} @endif</a></small>
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
                    @include('Statics::block.right')
                </div><!-- end col -->
            </div>
        </div><!-- end container -->
    </section>


@stop