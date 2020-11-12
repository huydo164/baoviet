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
        $search['statics_focus'] = CGlobal::status_show;
        $search['field_get'] = 'statics_id,statics_catid,statics_cat_name,statics_cat_alias,statics_title,statics_intro,statics_content,statics_image,statics_created';
        $data_first = Statics::searchByConditionOnePage($search,3);


        $pageNo = (int)Request::get('page', 1);
        $pageScroll = CGlobal::num_scroll_page;
        $limit = 2;
        $offset = ($pageNo -1)*$limit;
        $total = 0;
        $data = $search = $dataCate =  array();
        $paging = '';

        $search['statics_status'] = CGlobal::status_show;
        $search['field_get'] = 'statics_id,statics_catid,statics_cat_name,statics_cat_alias,statics_title,statics_intro,statics_content,statics_image,statics_created,statics_view_num';
        $data  = Statics::searchByCondition($search, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getPager($pageScroll, $pageNo, $total, $limit, $search) : '';





        return view('Statics::content.index',[
            'data_first' => $data_first,
            'data' => $data,
            'paging' => $paging,
        ]);
    }
    public function author(){
        return view('Statics::content.pageAuthor');
    }
    public function danhmuc($catname, $catid){
        $pageNo = (int)Request::get('page', 1);
        $pageScroll = CGlobal::num_scroll_page;
        $limit  =12;
        $offset = ($pageNo - 1)* $limit;
        $total = 0;
        $data = $search = $dataCate = array();
        $paging = '';

        if ($catid > 0){
            $search['statics_cat_name'] = $catname;
            $search['statics_catid'] = $catid;
            $search['statics_status'] = CGlobal::status_show;
            $search['field_get'] = 'statics_id,statics_catid,statics_cat_name,statics_cat_alias,statics_title,statics_intro,statics_content,statics_image,statics_created';
            $data  = Statics::searchByCondition($search, $limit, $offset, $total);
            $paging = $total > 0 ? Pagging::getPager($pageScroll, $pageNo, $total, $limit, $search) : '';
            $dataCate = Category::getById($catid);
        }

        return view('Statics::content.pageCategory1',[
            'data' => $data,
            'dataCate' => $dataCate,
            'paging' => $paging,
        ]);
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
    public function contactPost(){

        if (!empty($_POST)) {
            $contact_name = Request::get('name');
            $contact_email = Request::get('email');
            $contact_phone = Request::get('phone');
            $contact_content = Request::get('message');
            $contact_created = time();

            if ($contact_name != '' || $contact_email != '' || $contact_phone != '' || $contact_content != '') {
                $dataInput = array(
                    'contact_name' => $contact_name,
                    'contact_phone' => $contact_phone,
                    'contact_email' => $contact_email,
                    'contact_content' => $contact_content,

                    'contact_created' => $contact_created,
                );
                $query = Contact::addData($dataInput);
                if ($query > 0){
                    $p = '<p> Cảm ơn bạn đã liên hệ với chúng tôi</p>';
                    return $p;
                }
                else
                {
                    return '<p> Gửi liên hệ thất bại</p>';
                }
            }
        }
    }
    public function StaticDetail($name = '' , $id = 0){
        $data = $dataCate = $dataSame =  array();

        if($id > 0){
            $data = Statics::getById($id);
            $dataCate = Category::getById($data->statics_catid);
        }

        $searchSame['field_get'] = 'statics_id,statics_catid,statics_cat_name,statics_cat_alias,statics_title,statics_intro,statics_content,statics_image,statics_created';
        $dataSame = Statics::getSameData($id, $data->statics_catid, $limit = 2, $searchSame);



        $dataTags=[];
        if(!empty($data)){
            $tmp = ($data->statics_tag != '') ? json_decode($data->statics_tag, true) : [];
            $dataTags = $dataTags + $tmp;
        }

        return view('Statics::content.pageStaticInfo',[
            'data' => $data,
            'dataSame' => $dataSame,
            'dataTags' => $dataTags,
        ]);
    }
}

