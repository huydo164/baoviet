<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/
namespace App\Modules\Admin\Controllers;

use App\Modules\Models\Author;
use App\Modules\Models\Trash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\Loader;
use App\Library\PHPDev\Pagging;
use App\Library\PHPDev\Utility;
use App\Library\PHPDev\ValidForm;

class AuthorController extends BaseAdminController{

    private $arrStatus = array(-1 => 'Chọn', CGlobal::status_hide => 'Chưa duyệt', CGlobal::status_show => 'Đã duyệt');
    private $arrType = array(-1 => 'Chọn', CGlobal::status_int_1 => 'Form liên hệ', CGlobal::status_int_2 => 'Form đăng ký khóa học');
    private $error = '';
    public function __construct(){
        parent::__construct();
        Loader::loadJS('backend/js/admin.js', CGlobal::$postEnd);
        Loader::loadCSS('libs/jAlert/jquery.alerts.css', CGlobal::$postHead);
        Loader::loadJS('libs/jAlert/jquery.alerts.js', CGlobal::$postEnd);
    }
    public function listView(){

        //Config Page
        $pageNo = (int) Request::get('page', 1);
        $pageScroll = CGlobal::num_scroll_page;
        $limit = CGlobal::num_record_per_page;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['author_type'] = (int)Request::get('author_type', -1);
        $search['author_title'] = addslashes(Request::get('author_title', ''));
        $search['author_status'] = (int)Request::get('author_status', -1);
        $search['submit'] = (int)Request::get('submit', 0);
        $search['field_get'] = '';

        $dataSearch = author::searchByCondition($search, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getPager($pageScroll, $pageNo, $total, $limit, $search) : '';

        $optionStatus = Utility::getOption($this->arrStatus, $search['author_status']);
        $optionType = Utility::getOption($this->arrType, $search['author_type']);

        $messages = Utility::messages('messages');

        return view('Admin::author.list',[
            'data'=>$dataSearch,
            'total'=>$total,
            'paging'=>$paging,
            'arrStatus'=>$this->arrStatus,
            'optionStatus'=>$optionStatus,
            'optionType'=>$optionType,
            'arrType'=>$this->arrType,
            'search'=>$search,
            'messages'=>$messages,
        ]);
    }
    public function getItem($id=0){

        Loader::loadJS('libs/ckeditor/ckeditor.js', CGlobal::$postHead);

        $data = array();
        if($id > 0) {
            $data = Author::getById($id);
        }
        $optionStatus = Utility::getOption($this->arrStatus, isset($data['author_status'])? $data['author_status'] : CGlobal::status_show);
        $optionType = Utility::getOption($this->arrType, isset($data['author_type'])? $data['author_type'] : CGlobal::status_hide);

        return view('Admin::author.add',[
            'id'=>$id,
            'data'=>$data,
            'optionStatus'=>$optionStatus,
            'optionType'=>$optionType,
            'error'=>$this->error,
        ]);

    }
    public function postItem($id=0){

        Loader::loadJS('libs/ckeditor/ckeditor.js', CGlobal::$postHead);

        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = array();

        $dataSave = array(
            'author_name'=>array('value'=>addslashes(Request::get('author_name')),'require'=>0),
            'author_image'=>array('value'=>addslashes(Request::get('author_image')),'require'=>0),
        );

        if($id > 0){
            unset($dataSave['author_created']);
        }

        $this->error = ValidForm::validInputData($dataSave);
        if($this->error == ''){
            $id = ($id == 0) ? $id_hiden : $id;
            author::saveData($id, $dataSave);
            return Redirect::route('admin.author');
        }else{
            foreach($dataSave as $key=>$val){
                $data[$key] = $val['value'];
            }
        }

   

        return view('Admin::author.add',[
            'id'=>$id,
            'data'=>$data,
        ]);
    }
    public function delete(){

        $listId = Request::get('checkItem', array());
        $token = Request::get('_token', '');
        if(Session::token() === $token){
            if(!empty($listId) && is_array($listId)){
                foreach($listId as $id){
                    Trash::addItem($id, 'author', '', 'author_id', 'author_title', '', '');
                    author::deleteId($id);
                }
                Utility::messages('messages', 'Xóa thành công!', 'success');
            }
        }
        return Redirect::route('admin.author');
    }
}