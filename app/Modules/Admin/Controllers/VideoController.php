<?php
namespace App\Modules\Admin\Controllers;

use App\Library\PHPDev\FuncLib;
use App\Modules\Models\Statics;
use App\Modules\Models\Tag;
use App\Modules\Models\TagStatics;
use App\Modules\Models\Trash;
use App\Modules\Models\Type;
use App\Modules\Models\Category;
use App\Modules\Models\Video;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\Loader;
use App\Library\PHPDev\Pagging;
use App\Library\PHPDev\Utility;
use App\Library\PHPDev\ValidForm;
use App\Library\PHPDev\ThumbImg;

class VideoController extends BaseAdminController{

    private $arrStatus = array(-1 => 'Chọn', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    private $arrFocus = array(-1 => 'Chọn', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    private $arrCate = array(-1=>'Chọn danh mục cha');
    private $strCategoryProduct = '';
    private $error = '';

    public function __construct(){
        parent::__construct();
        Loader::loadJS('backend/js/admin.js', CGlobal::$postEnd);
        Loader::loadCSS('libs/upload/cssUpload.css', CGlobal::$postHead);
        Loader::loadJS('libs/upload/jquery.uploadfile.js', CGlobal::$postEnd);
        Loader::loadJS('backend/js/upload-admin.js', CGlobal::$postEnd);
        Loader::loadJS('libs/dragsort/jquery.dragsort.js', CGlobal::$postHead);
        Loader::loadCSS('libs/jAlert/jquery.alerts.css', CGlobal::$postHead);
        Loader::loadJS('libs/jAlert/jquery.alerts.js', CGlobal::$postEnd);

        $typeId = Type::getIdByKeyword('group_video');
        $this->arrCate = CategoryController::getArrCategory($typeId);

    }
    public function listView(){

        //Config Page
        $pageNo = (int) Request::get('page', 1);
        $pageScroll = CGlobal::num_scroll_page;
        $limit = CGlobal::num_record_per_page;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['video_catid'] = (int)Request::get('video_catid', -1);
        $search['video_title'] = addslashes(Request::get('video_title', ''));
        $search['video_status'] = (int)Request::get('video_status', -1);
        $search['video_focus'] = (int)Request::get('video_focus', -1);
        $search['submit'] = (int)Request::get('submit', 0);
        $search['field_get'] = '';

        $dataSearch = Video::searchByCondition($search, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getPager($pageScroll, $pageNo, $total, $limit, $search) : '';

        $optionStatus = Utility::getOption($this->arrStatus, $search['video_status']);
        $optionFocus = Utility::getOption($this->arrFocus, $search['video_focus']);

        $messages = Utility::messages('messages');
        $typeId = Type::getIdByKeyword('group_video');
        $this->strCategoryProduct = CategoryController::createOptionCategory($typeId, isset($search['video_catid']) ? $search['video_catid'] : 0);


        return view('Admin::video.list',[
            'data'=>$dataSearch,
            'total'=>$total,
            'paging'=>$paging,
            'arrStatus'=>$this->arrStatus,
            'optionStatus'=>$optionStatus,
            'optionFocus'=>$optionFocus,
            'arrCate'=>$this->arrCate,
            'strCategoryProduct'=>$this->strCategoryProduct,
            'search'=>$search,
            'messages'=>$messages,
        ]);
    }
    public function getItem($id=0){

        Loader::loadJS('libs/ckeditor/ckeditor.js', CGlobal::$postHead);

        $data = array();
        $video_image = '';
        $video_image_other = array();
        $arrTag = array();

        if($id > 0) {
            $data = Video::getById($id);
            if($data != null){
                if($data->video_image_other != ''){
                    $videoImageOther = unserialize($data->video_image_other);
                    if(!empty($videoImageOther)){
                        foreach($videoImageOther as $k=>$v){
                            $url_thumb = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_VIDEO, $id, $v, 400, 400, '', true, true);
                            $video_image_other[] = array('img_other'=>$v,'src_img_other'=>$url_thumb);
                        }
                    }
                }
                //Main Img
                $video_image = trim($data->video_image);
                if(Request::hasFile('file')){

                    $file = Request::file('file');
                    $filename = $file->getClientOriginalName();
                    $path = public_path().'/uploads/';
                    return $file->move($path, $filename);
                }

            }
        }

        $arrTag = Tag::getAllTag(array(), $limit = 0);

        $optionStatus = Utility::getOption($this->arrStatus, isset($data['video_status'])? $data['video_status'] : CGlobal::status_show);
        $optionFocus = Utility::getOption($this->arrFocus, isset($data['video_focus'])? $data['video_focus'] : CGlobal::status_hide);
        $typeId = Type::getIdByKeyword('group_video');
        $this->strCategoryProduct = CategoryController::createOptionCategory($typeId, isset($data['video_catid'])? $data['video_catid'] : 0);

        return view('Admin::video.add',[
            'id'=>$id,
            'data'=>$data,
            'arrTag' => $arrTag,
            'optionStatus'=>$optionStatus,
            'optionFocus'=>$optionFocus,
            'news_image'=>$video_image,
            'news_image_other'=>$video_image_other,
            'optionCategoryProduct'=>$this->strCategoryProduct,
            'error'=>$this->error,
        ]);

    }
    public function postItem($id=0){

        Loader::loadJS('libs/ckeditor/ckeditor.js', CGlobal::$postHead);

        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = array();

        $dataSave = array(
            'video_title'=>array('value'=>addslashes(Request::get('video_title')), 'require'=>1, 'messages'=>'Tiêu đề không được trống!'),
            'video_catid'=>array('value'=>(int)(Request::get('video_catid')),'require'=>0),
            'video_intro'=>array('value'=>addslashes(Request::get('video_intro')),'require'=>0),
            'video_content'=>array('value'=>addslashes(Request::get('video_content')),'require'=>0),
            'video_order_no'=>array('value'=>(int)addslashes(Request::get('video_order_no')),'require'=>0),
            'video_created'=>array('value'=>time()),
            'video_status'=>array('value'=>(int)Request::get('video_status', -1),'require'=>0),
            'video_focus'=>array('value'=>(int)Request::get('video_focus', -1),'require'=>0),
            'meta_title'=>array('value'=>addslashes(Request::get('meta_title')),'require'=>0),
            'meta_keywords'=>array('value'=>addslashes(Request::get('meta_keywords')),'require'=>0),
            'meta_description'=>array('value'=>addslashes(Request::get('meta_description')),'require'=>0),
            'video_tag' => array('value' => Request::get('video_tag', []), 'require' => 0),
            'video_youtube' => array('value' => addslashes(Request::get('video_youtube')), 'require' => 0)
        );

        //get video_cat_name, video_cat_alias
        if(isset($dataSave['video_catid']['value']) && $dataSave['video_catid']['value'] > 0){
            $arrCat = Category::getById($dataSave['video_catid']['value']);
            if($arrCat != null){
                $dataSave['video_cat_name']['value'] = $arrCat->category_title;
                $dataSave['video_cat_alias']['value'] = $arrCat->category_title_alias;
            }
        }
        $video_tag = $dataSave['video_tag']['value'];
        $dataSave['video_tag']['value'] = json_encode($video_tag);

        //Main Img
        $image_primary = addslashes(Request::get('image_primary', ''));
        //Other Img
        $arrInputImgOther = array();
        $getImgOther = Request::get('img_other',array());
        if(!empty($getImgOther)){
            foreach($getImgOther as $k=>$val){
                if($val !=''){
                    $arrInputImgOther[] = $val;
                }
            }
        }
        if(!empty($arrInputImgOther) && count($arrInputImgOther) > 0) {
            //Neu Ko chon Anh Chinh, Lay Anh Chinh La Cai Dau Tien
            $dataSave['video_image']['value'] = ($image_primary != '') ? $image_primary : $arrInputImgOther[0];
            $dataSave['video_image_other']['value'] = serialize($arrInputImgOther);
        }
        if($id > 0){
            unset($dataSave['video_created']);
        }

        $this->error = ValidForm::validInputData($dataSave);
        if($this->error == ''){
            $id = ($id == 0) ? $id_hiden : $id;
            $id = Video::saveData($id, $dataSave);
            if($id > 0){
                TagStatics::where('video_id', $id)->delete();
                foreach ($video_tag as $key => $item){
                    $tmp = [
                        'tag_id'=>$key,
                        'video_id'=>$id,
                    ];
                    TagStatics::create($tmp);
                }
            }
            return Redirect::route('admin.video');
        }else{
            foreach($dataSave as $key=>$val){
                $data[$key] = $val['value'];
            }
        }

        $optionStatus = Utility::getOption($this->arrStatus, isset($data['video_status'])? $data['video_status'] : -1);
        $optionFocus = Utility::getOption($this->arrFocus, isset($data['video_focus'])? $data['video_focus'] : CGlobal::status_hide);
        $typeId = Type::getIdByKeyword('group_video');
        $this->strCategoryProduct = CategoryController::createOptionCategory($typeId, isset($data['video_catid'])? $data['video_catid'] : 0);

        return view('Admin::video.add',[
            'id'=>$id,
            'data'=>$data,
            'optionStatus'=>$optionStatus,
            'optionFocus'=>$optionFocus,
            'news_image'=>$image_primary,
            'news_image_other'=>$arrInputImgOther,
            'optionCategoryProduct'=>$this->strCategoryProduct,
            'error'=>$this->error,
        ]);
    }

    public function delete(){

        $listId = Request::get('checkItem', array());
        $token = Request::get('_token', '');
        if(Session::token() === $token){
            if(!empty($listId) && is_array($listId)){
                foreach($listId as $id){
                    Trash::addItem($id, 'Video', CGlobal::FOLDER_VIDEO, 'video_id', 'video_title', 'video_image', '');
                    Video::deleteId($id);
                }
                Utility::messages('messages', 'Xóa thành công!', 'success');
            }
        }
        return Redirect::route('admin.video');
    }

}