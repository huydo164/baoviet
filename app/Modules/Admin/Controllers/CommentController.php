<?php
namespace App\Modules\Admin\Controllers;

use App\Library\PHPDev\FuncLib;
use App\Modules\Models\Comment;
use App\Modules\Models\Product;
use App\Modules\Models\Type;
use App\Modules\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\Loader;
use App\Library\PHPDev\Pagging;
use App\Library\PHPDev\Utility;
use App\Library\PHPDev\ValidForm;
use App\Library\PHPDev\ThumbImg;

class CommentController extends BaseAdminController{


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

        $typeId = Type::getIdByKeyword('group_static');
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

        $search['comment_id'] = addslashes(Request::get('comment_id', ''));

        $search['submit'] = (int)Request::get('submit', 0);
        $search['field_get'] = '';

        $dataSearch = Comment::searchByCondition($search, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getPager($pageScroll, $pageNo, $total, $limit, $search) : '';
        $messages = Utility::messages('messages');


        return view('Admin::comment.list',[
            'data'=>$dataSearch,
            'total'=>$total,
            'paging'=>$paging,
            'search'=>$search,
            'messages'=>$messages,
        ]);
    }
    public function getItem($id=0){

        Loader::loadJS('libs/ckeditor/ckeditor.js', CGlobal::$postHead);

        $data = array();

        if($id > 0) {
            $data = comment::getById($id);
        }

        return view('Admin::comment.add',[
            'id'=>$id,
            'data'=>$data,
            'error'=>$this->error,
        ]);

    }
    function str_rand($len) {
        $str = '';
        $times = ceil($len/32);
        for ($i = 0; $i < $times; $i++) {
            $str .= md5(rand());
        }
        return substr($str, 0, $len);
    }
    public function postItem($id=0){


        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = array();

        $data = Comment::getById($id_hiden);
        $dataSave = array(
            'statics_id'=>array('value'=>(int)(Request::get('statics_id')),'require'=>0),
            'comment_web'=>array('value'=>addslashes(Request::get('comment_web')),'require'=>0),
            'comment_name'=>array('value'=>addslashes(Request::get('comment_name')),'require'=>0),
            'comment_email'=>array('value'=>addslashes(Request::get('comment_email')),'require'=>0),
            'comment_detail'=>array('value'=>addslashes(Request::get('comment_detail')),'require'=>0),
            'comment_status'=>array('value'=>(int)(Request::get('comment_status')),'require'=>0),
        );
        $this->error = ValidForm::validInputData($dataSave);
        if($this->error == ''){
            $id = ($id == 0) ? $id_hiden : $id;
            Comment::saveData($id, $dataSave);
            return Redirect::route('admin.comment');
        }else{
            foreach($dataSave as $key=>$val){
                $data[$key] = $val['value'];
            }
        }

        $optionStatus = Utility::getOption($this->arrStatus, isset($data['comment_status'])? $data['comment_status'] : -1);


        return view('Admin::comment.add',[
            'id'=>$id,
            'data'=>$data,
            'optionStatus'=>$optionStatus,
            'error'=>$this->error,
        ]);
    }
    public function delete(){

        $listId = Request::get('checkItem', array());

        $token = Request::get('_token', '');
        if(Session::token() === $token){
            if(!empty($listId) && is_array($listId)){
                foreach($listId as $id){
                    Comment::deleteId($id);
                }
                Utility::messages('messages', 'Xóa thành công!', 'success');
            }
        }
        return Redirect::route('admin.comment_delete');
    }

}