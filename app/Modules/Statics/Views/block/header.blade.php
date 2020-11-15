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
                                <li class="nav-item @if($key == 1) nav-item dropdown has-submenu menu-large hidden-md-down hidden-sm-down hidden-xs-down @endif">
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
                                                                    <button data="{{$sub->category_id}}" class="tablinks tablinks{{$sub->category_id}}  @if($k == 2) active @endif" onclick="openCategory(event, '{{$k}}')">{{$sub->category_title}}</button>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="tab-detail clearfix">
                                                            @foreach($arrCategory as $k => $sub)
                                                                @if($sub->category_menu == CGlobal::status_show && $sub->category_parent_id == $cat->category_id)
                                                                    <div id="{{$k}}" class="tabcontent @if($k == 2) active @endif">
                                                                        <div class="row">
                                                                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                                                <div class="blog-box blog-box24 active">
                                                                                    <div class="post-media">
                                                                                        <a href="tech-single.html" title="">
                                                                                            <img src="upload/tech_menu_01.jpg" alt="" class="img-fluid">
                                                                                            <div class="hovereffect">
                                                                                            </div><!-- end hover -->
                                                                                            <span class="menucat">Science</span>
                                                                                        </a>
                                                                                    </div><!-- end media -->
                                                                                    <div class="blog-meta">
                                                                                        <h4><a href="tech-single.html" title="">box24</a></h4>
                                                                                    </div><!-- end meta -->
                                                                                </div><!-- end blog-box -->
                                                                                <div class="blog-box blog-box25">
                                                                                    <div class="post-media">
                                                                                        <a href="tech-single.html" title="">
                                                                                            <img src="upload/tech_menu_01.jpg" alt="" class="img-fluid">
                                                                                            <div class="hovereffect">
                                                                                            </div><!-- end hover -->
                                                                                            <span class="menucat">Science</span>
                                                                                        </a>
                                                                                    </div><!-- end media -->
                                                                                    <div class="blog-meta">
                                                                                        <h4><a href="tech-single.html" title="">box25</a></h4>
                                                                                    </div><!-- end meta -->
                                                                                </div><!-- end blog-box -->
                                                                                <div class="blog-box blog-box26">
                                                                                    <div class="post-media">
                                                                                        <a href="tech-single.html" title="">
                                                                                            <img src="upload/tech_menu_01.jpg" alt="" class="img-fluid">
                                                                                            <div class="hovereffect">
                                                                                            </div><!-- end hover -->
                                                                                            <span class="menucat">Science</span>
                                                                                        </a>
                                                                                    </div><!-- end media -->
                                                                                    <div class="blog-meta">
                                                                                        <h4><a href="tech-single.html" title="">box26</a></h4>
                                                                                    </div><!-- end meta -->
                                                                                </div><!-- end blog-box -->
                                                                            </div>

                                                                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                                                <div class="blog-box">
                                                                                    <div class="post-media">
                                                                                        <a href="tech-single.html" title="">
                                                                                            <img src="upload/tech_menu_02.jpg" alt="" class="img-fluid">
                                                                                            <div class="hovereffect">
                                                                                            </div><!-- end hover -->
                                                                                            <span class="menucat">Science</span>
                                                                                        </a>
                                                                                    </div><!-- end media -->
                                                                                    <div class="blog-meta">
                                                                                        <h4><a href="tech-single.html" title="">The secret of your beauty is handmade soap</a></h4>
                                                                                    </div><!-- end meta -->
                                                                                </div><!-- end blog-box -->
                                                                            </div>

                                                                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                                                <div class="blog-box">
                                                                                    <div class="post-media">
                                                                                        <a href="tech-single.html" title="">
                                                                                            <img src="upload/tech_menu_03.jpg" alt="" class="img-fluid">
                                                                                            <div class="hovereffect">
                                                                                            </div><!-- end hover -->
                                                                                            <span class="menucat">Science</span>
                                                                                        </a>
                                                                                    </div><!-- end media -->
                                                                                    <div class="blog-meta">
                                                                                        <h4><a href="tech-single.html" title="">Benefits of face mask made from mud</a></h4>
                                                                                    </div><!-- end meta -->
                                                                                </div><!-- end blog-box -->
                                                                            </div>

                                                                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                                                <div class="blog-box">
                                                                                    <div class="post-media">
                                                                                        <a href="tech-single.html" title="">
                                                                                            <img src="upload/tech_menu_04.jpg" alt="" class="img-fluid">
                                                                                            <div class="hovereffect">
                                                                                            </div><!-- end hover -->
                                                                                            <span class="menucat">Science</span>
                                                                                        </a>
                                                                                    </div><!-- end media -->
                                                                                    <div class="blog-meta">
                                                                                        <h4><a href="tech-single.html" title="">Relax with the unique warmth of candle flavor</a></h4>
                                                                                    </div><!-- end meta -->
                                                                                </div><!-- end blog-box -->
                                                                            </div>
                                                                        </div>
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
