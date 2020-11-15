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
    <div class="container">
        <div class="title">
            {{$data->video_title}}
        </div>
        @if($data->video_youtube != '')
            <iframe width="100%" height="200" src="{{ $data->video_youtube }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        @endif
        <div class="content">
            {!! addslashes($data->video_content) !!}
        </div>
    </div>
@stop