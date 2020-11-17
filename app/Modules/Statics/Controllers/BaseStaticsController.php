<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/
namespace App\Modules\Statics\Controllers;

use App\Modules\Models\Banner;
use App\Modules\Models\Category;
use App\Modules\Models\Info;
use App\Modules\Models\User;

use App\Modules\Models\Statics;
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\FuncLib;
use App\Library\PHPDev\Loader;
use App\Library\PHPDev\SEOMeta;
use App\Library\PHPDev\ThumbImg;
use Illuminate\Support\Facades\View;

class BaseStaticsController extends Controller{

    public function __construct(){

        $arrOnline = Info::getItemByKeyword('SITE_ONLINE');
        if(isset($arrOnline->info_status) && $arrOnline->info_status == CGlobal::status_show){
            $this->middleware(function ($request, $next) {
                $users = User::userLogin();
                if(empty($users)){
                    header('Content-Type: text/html; charset=utf-8');
                    echo '<div style="text-align: center"><img src="'.FuncLib::getBaseUrl().'assets/frontend/img/maintain.png"></div>';
                    echo '<div style="text-align: center; margin-top:10px">'.CGlobal::txtMaintain.'</div>';die;
                }
                return $next($request);
            });
        }

        Loader::loadJS('frontend/js/site.js', CGlobal::$postEnd);
        Loader::loadJS('libs/jAlert/jquery.alerts.js', CGlobal::$postEnd);
        Loader::loadCSS('libs/jAlert/jquery.alerts.css', CGlobal::$postHead);
        Loader::loadCSS('libs/fontAwesome/css/font-awesome.min.css', CGlobal::$postHead);

        $bannerHeader['banner_status'] = CGlobal::status_show;
        $bannerHeader['banner_type'] = 0;
        $bannerHeader['field_get'] = 'banner_id,banner_title,banner_title_show,banner_image,banner_link,banner_is_target,banner_is_rel,banner_is_run_time,banner_start_time,banner_end_time';
        $dataBannerHeader = Banner::getBannerSite($bannerHeader, $limit = 2, 'header');
        $dataBannerHeader = FuncLib::checkBannerShow($dataBannerHeader);
        View::share('dataBannerHeader', $dataBannerHeader);

        $arrCategory = Category::getAllCategory(0, array(), 0);
        View::share('arrCategory',$arrCategory);

        $arrStaticsByCatid = array();
        $dataSearch['field_get'] = 'statics_id,statics_catid,statics_cat_name,statics_cat_alias,statics_title,statics_intro,statics_content,statics_image,statics_created';
        if (!empty($arrCategory)){
            foreach ($arrCategory as $item){
                if ($item->category_parent_id > 0){
                    $cateParentId =  $item->category_parent_id;
                }
            }
        }
        if ($cateParentId > 0){
            $arrStaticsByCatid = Statics::getFocus($dataSearch,$limit = 20);
        }
        View::share('arrStaticsByCatid',$arrStaticsByCatid);

        $arrTextLogo = Info::getItemByKeyword('SITE_LOGO');
        View::share('arrTextLogo',$arrTextLogo);

        $textFooter = self::viewShareVal('TEXT_FOOTER');
        View::share('textFooter',$textFooter);

        $search['field_get'] = 'statics_id,statics_title,statics_intro,statics_created,statics_view_num';
        $popular_post = Statics::getPopularPost($search,3);
        View::share('popular_post',$popular_post);

    }
    public function page403(){
        $meta_img='';
        $meta_title = $meta_keywords = $meta_description = $txt403 = CGlobal::txt403;
        SEOMeta::init($meta_img, $meta_title, $meta_keywords, $meta_description);
        return view('Statics::errors.page-403',['txt403'=>$txt403]);
    }
    public function page404(){
        $meta_img='';
        $meta_title = $meta_keywords = $meta_description = $txt404 = CGlobal::txt404;
        SEOMeta::init($meta_img, $meta_title, $meta_keywords, $meta_description);
        return view('Statics::errors.page-404',['txt404'=>$txt404]);
    }
    public static function viewShareVal($key=''){
        $str='';
        if($key != '') {
            $arrStr = Info::getItemByKeyword($key);
            if(isset($arrStr->info_id)) {
                $str = stripslashes($arrStr->info_content);
            }
        }
        return $str;
    }
}