<?php

use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\ThumbImg;
use App\Library\PHPDev\FuncLib;
?>
@extends('Admin::layout.html')
@section('header')
@include('Admin::block.header')
@stop
@section('left')
@include('Admin::block.left')
@stop
@section('content')
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="{{URL::route('admin.dashboard')}}">Trang chủ</a>
                </li>
                <li class="active">@if($id==0)Thêm mới @else Sửa @endif bài viết tĩnh</li>
            </ul>
        </div>

        < <div class="page-content">
            <div class="col-xs-12">
                <div class="row">
                    @if(isset($error) && $error != '')
                    <div class="alert-admin alert alert-danger">{!! $error !!}</div>
                    @endif
                    <form class="form-horizontal paddingTop30" name="txtForm" action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 mb-12">
                                <div class="nav-tabs-horizontal nav-tabs-inverse" data-plugin="tabs">
                                    <ul class="nav nav-tabs nav-tabs-solid" role="tablist">
                                        <li class="nav-item active" role="presentation">
                                            <a class="nav-link active" data-toggle="tab" href="#tabNoiDung" aria-controls="tabNoiDung" role="tab">
                                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                Nội dung
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content pt-10">
                                        <div class="tab-pane panelDetail active" id="tabNoiDung" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="clearfix"></div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tên tác giả<span>*</span></label>
                                                            <div class="controls">
                                                                <input type="text" class="form-control input-sm" name="author_name" value="@if(isset($data['author_name'])){{$data['author_name']}}@endif">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Ảnh tác giả</label>
                                                            <div class="controls">
                                                                <a href="javascript:;" class="btn btn-primary link-button btn-sm" onclick="UploadAdmin.uploadMultipleImages(2);">Upload ảnh tác giả</a>
                                                                <div id="sys_show_image_banner">
                                                                    @if(isset($data['author_image']) && $data['author_image'] !='')
                                                                    <img src="{{ThumbImg::thumbBaseNormal(CGlobal::FOLDER_AUTHOR, $data['author_id'], $data['author_image'], 300, 0, '', true, true)}}" />
                                                                    @endif
                                                                </div>
                                                                <input name="img" type="hidden" id="img" @if(isset($data['author_image']))value="{{$data['author_image']}}" @endif>
                                                                <input name="img_old" type="hidden" id="img_old" @if(isset($data['author_image']))value="{{$data['author_image']}}" @endif>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>



                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="panel-footer clearfix">
                                        <div class="form-inline float-right">
                                            <div class="form-row">
                                                {!! csrf_field() !!}
                                                <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}" />
                                                <button type="submit" name="txtSubmit" id="buttonSubmit" class="btn btn-primary btn-sm">Lưu lại</button>
                                                <button type="reset" class="btn btn-sm">Bỏ qua</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
</div>



@stop