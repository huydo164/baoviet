<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/
namespace App\Modules\Statics\Controllers;

use App\Library\PHPDev\FuncLib;
use App\Library\PHPDev\Loader;
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\Memcache;
use App\Library\PHPDev\Pagging;
use App\Library\PHPDev\SEOMeta;
use App\Library\PHPDev\ThumbImg;
use App\Library\PHPDev\Utility;
use App\Modules\Models\Category;
use App\Modules\Models\Contact;
use App\Modules\Models\Info;
use App\Modules\Models\Orders;
use App\Modules\Models\Product;
use App\Modules\Models\Rating;
use App\Modules\Models\Statics;
use App\Modules\Models\Tag;
use App\Modules\Models\TagStatics;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class StaticsController extends BaseStaticsController{

    public function actionRouter($catname, $catid){
        if ($catid > 0 && $catname != ''){
            $arrCate = Category::getById($catid);
            if ($arrCate != null){
                $type_keyword = $arrCate->category_type_keyword;
                if ($type_keyword == 'group_statics'){
                    return self::pageStatics($catname,$catid);
                }
                elseif($type_keyword == 'group_video'){
                    return self::pageVideo($catname,$catid);
                }
            }
            else{
                return Redirect::route('page.404');
            }
        }
        else{
            return Redirect::route('page.404');
        }
    }

    public function index(){
        return view('Statics::content.index');
    }
    public function author(){
        return view('Statics::content.pageAuthor');
    }
    public function cate1(){
        return view('Statics::content.pageCategory1');
    }
    public function cate2(){
        return view('Statics::content.pageCategory2');
    }
    public function cate3(){
        return view('Statics::content.pageCategory3');
    }
    public function contact(){
        return view('Statics::content.pageContact');
    }
    public function static(){
        return view('Statics::content.pageStaticInfo');
    }
}

