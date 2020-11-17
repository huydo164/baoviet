<?php
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\FuncLib;
use App\Library\PHPDev\ThumbImg;
?>
<header class="tech-header header">
    {!! isset($messages) && ($messages != '') ? $messages : '' !!}
    <div class="container-fluid">
        <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @if(isset($arrTextLogo) && !empty($arrTextLogo))
                <a class="navbar-brand" href="{{ FuncLib::getBaseUrl() }}">
                    @if($arrTextLogo->info_img != '')
                        <img src="{{ ThumbImg::thumbBaseNormal(CGlobal::FOLDER_INFO, $arrTextLogo['info_id'], $arrTextLogo['info_img'], 2000, 0, '',true, true ) }}" alt="">
                    @endif
                </a>
            @endif
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    @if(isset($arrCategory) && !empty($arrCategory))
                        @foreach($arrCategory as $key => $cat)
                            @if($cat->category_menu == CGlobal::status_show && $cat->category_parent_id == 0)
                                <?php $i=0 ?>
                                @foreach($arrCategory as $k => $sub)
                                    @if($sub->category_menu == CGlobal::status_show && $sub->category_parent_id == $cat->category_id)
                                        <?php $i++ ?>
                                    @endif
                                @endforeach
                                <li class="nav-item @if($key == 1) dropdown has-submenu menu-large hidden-md-down hidden-sm-down hidden-xs-down @endif">
                                    <a @if($i > 0) @endif title="{{$cat->category_title}}" class="nav-link @if($key == 1) dropdown-toggle @endif" @if($key == 1) id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif href="@if($cat->category_link_replace != ''){{$cat->category_link_replace}}@else{{FuncLib::buildLinkCategory($cat->category_id, $cat->category_title)}}@endif">
                                        {{$cat->category_title}}
                                    </a>
                                    @if($i > 0)
                                        <ul class="dropdown-menu megamenu" aria-labelledby="dropdown01">
                                            <li>
                                                <div class="container">
                                                    <div class="mega-menu-content clearfix">
                                                        <div class="tab">
                                                            @foreach($arrCategory as $k => $sub)
                                                                @if($sub->category_menu == CGlobal::status_show && $sub->category_parent_id == $cat->category_id)
                                                                    <button class="tablinks  @if($sub->category_id == 24) active @endif" onclick="openCategory(event, '{{$sub->category_id}}')">{{$sub->category_title}}</button>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="tab-detail clearfix">
                                                            @foreach($arrCategory as $k => $sub)
                                                                @if($sub->category_menu == CGlobal::status_show && $sub->category_parent_id == $cat->category_id)
                                                                    <div id="{{$sub->category_id}}" class="tabcontent @if($sub->category_id == 24) active @endif">
                                                                        <div class="row">
                                                                            @if($sub->category_parent_id > 0)
                                                                                @if(isset($arrStaticsByCatid) && !empty($arrStaticsByCatid))
                                                                                    @foreach($arrStaticsByCatid as $key => $item)
                                                                                        @if($item->statics_catid == $sub->category_id)
                                                                                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                                                                <div class="blog-box">
                                                                                                    <div class="post-media">
                                                                                                        <a href="{{FuncLib::buildLinkCategory($item->statics_id,$item->statics_title)}}" title="{{$item->statics_title}}">
                                                                                                            <img src="{{ThumbImg::thumbBaseNormal(CGlobal::FOLDER_STATICS,$item->statics_id,$item->statics_image,400,0,'',true, true)}}" alt="" class="img-fluid">
                                                                                                            <div class="hovereffect">
                                                                                                            </div><!-- end hover -->
                                                                                                            <span class="menucat">{{$sub->category_title}}</span>
                                                                                                        </a>
                                                                                                    </div><!-- end media -->
                                                                                                    <div class="blog-meta">
                                                                                                        <h4><a href="{{FuncLib::buildLinkCategory($item->statics_id,$item->statics_title)}}" title="{{$item->statics_title}}" title="">{{$item->statics_title}}</a></h4>
                                                                                                    </div><!-- end meta -->
                                                                                                </div><!-- end blog-box -->
                                                                                            </div>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                            @endif
                                                                        </div><!-- end row -->
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    @endif
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
