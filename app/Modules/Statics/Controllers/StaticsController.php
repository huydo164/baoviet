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
use App\Modules\Models\Author;
use App\Modules\Models\Category;
use App\Modules\Models\Comment;
use App\Modules\Models\Contact;
use App\Modules\Models\Info;
use App\Modules\Models\Statics;
use App\Modules\Models\Tag;
use App\Modules\Models\TagStatics;
use App\Modules\Models\Video;
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
    public function pageAuthor($name = '' , $id = 0){
        $data = $statics = array();
        if($id > 0 )
        {
            $data = Author::getById($id);
            $statics = Statics::getByAuthor($id);

        }

        return view('Statics::content.pageAuthor',[
            'data' =>$data,
            'statics'=>$statics,
        ]);
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
    public function binhluan(){

        $comment =  Request::get('comment','');
        $gmail =  Request::get('gmail','');
        $name =  Request::get('name','');
        $web =  Request::get('web','');
        $statics_id = Request::get('statics_id','');
        $ip = Request::ip();
        if ( $comment != '' && $name != ''){
            $dataInput = array(
                'statics_id' => $statics_id,
                'comment_name' => $name,
                'comment_email' => $gmail,
                'comment_detail'=>$comment,
                'comment_web'=>$web,
                'comment_ip'=>$ip,
                'comment_status'=>0

            );
            $query = Comment::addData($dataInput);

            if ($query > 0){
                return '
                <div class="modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Modal body text goes here.</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>';
            }
        }
        else{
            Utility::messages('messages' , 'Thông tin liên hệ chưa chính sác. Bạn hãy đăng ký lại!');

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


        $comment = Comment::getByStaticId($data->statics_id);



        $dataTags=[];
        if(!empty($data)){
            $tmp = ($data->statics_tag != '') ? json_decode($data->statics_tag, true) : [];
            $dataTags = $dataTags + $tmp;
        }

        return view('Statics::content.pageStaticInfo',[
            'data' => $data,
            'dataSame' => $dataSame,
            'dataTags' => $dataTags,
            'comment' => $comment
        ]);
    }

    public function pageVideo($catname, $catid){
        $pageNo = (int)Request::get('page', 1);
        $pageScroll = CGlobal::num_scroll_page;
        $limit = CGlobal::num_record_per_page;
        $offset = ($pageNo - 1)*$limit;
        $total = 0;
        $data = $search = $dataCate =  array();
        $paging = '';

        if ($catid > 0){
            $search['video_cat_name'] = $catname;
            $search['video_catid'] = $catid;
            $search['video_status'] = CGlobal::status_show;
            $search['field_get'] = 'video_id,video_catid,video_cat_name,video_cat_alias,video_title,video_intro,video_content,video_image,video_created,video_youtube,video_tag,video_path';
            $data = Video::searchByCondition($search, $limit, $offset, $total);
            $paging = $total > 0 ? Pagging::getPager($pageScroll,$pageNo,$total,$limit, $search) : '';
            $dataCate = Category::getById($catid);
        }
        $text_title_video = self::viewShareVal('TEXT_TITLE_VIDEO');

        return view('Statics::content.pageVideo',[
            'data' => $data,
            'dataCate' => $dataCate,
            'paging' => $paging,
            'text_title_video' => $text_title_video,
        ]);
    }
    public function videoDetail($name = '', $id = 0){
        $data = $dataCate = array();
        if ($id > 0){
            $data = Video::getById($id);
            $dataCate = Category::getById($data->video_catid);
        }
        return view('Statics::content.videoDetail',[
            'data' => $data,
            'dataCate' => $dataCate,
        ]);
    }
}

