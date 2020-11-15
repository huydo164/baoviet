<?php
/*
* @Created by: DUYNX
* @Author    : duynx@peacesoft.net / nguyenduypt86@gmail.com
* @Date      : 08/2019
* @Version   : 1.0
*/

namespace App\Modules\Admin\Controllers;

use App\Modules\Models\Banner;
use App\Modules\Models\Category;
use App\Library\PHPDev\ThumbImg;
use App\Library\PHPDev\Upload;
use App\Modules\Models\Statics;
use App\Modules\Models\Video;
use Illuminate\Support\Facades\Request;
use App\Modules\Models\Info;
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\FuncLib;
use App\Modules\Models\Author;
use Illuminate\Support\Facades\Auth;

class AjaxUploadController extends BaseAdminController
{
    function upload()
    {
        $action = addslashes(Request::get('act', ''));
        switch ($action) {
            case 'upload_image':
                $this->upload_image();
                break;
            case 'remove_image':
                $this->remove_image();
                break;
            case 'remove_video':
                $this->remove_video();
                break;
            case 'get_image_insert_content' :
                $this->get_image_insert_content();
                break;
            default:
                $this->nothing();
                break;
        }
    }
    //Default
    function nothing()
    {
        die("Nothing to do...");
    }
    //Upload
    function upload_image()
    {
        $id_hiden =  Request::get('id', 0);
        $type = Request::get('type', 1);
        $pos = Request::get('pos', -1);
        $dataImg = $_FILES["multipleFile"];
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Data not exists!";
        switch ($type) {
            case 1: //Img Banner
                $aryData = $this->uploadImageToFolderOnce($dataImg, $id_hiden, CGlobal::FOLDER_BANNER, $type);
                break;
            case 2: //Img category
                $aryData = $this->uploadImageToFolderOnce($dataImg, $id_hiden, CGlobal::FOLDER_CATEGORY, $type);
                break;
            case 3: //Img author
                $aryData = $this->uploadImageToFolderOnce($dataImg, $id_hiden, CGlobal::FOLDER_AUTHOR, $type);
                break;
            case 5: //Img Info
                $aryData = $this->uploadImageToFolderOnce($dataImg, $id_hiden, CGlobal::FOLDER_INFO, $type);
                break;
            case 6: //Img Statics
                $aryData = $this->uploadImageToFolder($dataImg, $id_hiden, CGlobal::FOLDER_STATICS, $type);
                break;
            case 7 ://Img Video
                $aryData = $this->uploadImageToFolder($dataImg, $id_hiden, CGlobal::FOLDER_VIDEO, $type);
                break;
            case 8 ://Video
                $aryData = $this->uploadVideoToFolder($dataImg, $id_hiden, CGlobal::FOLDER_VIDEO_1, $type);
                break;
            default:
                break;
        }
        echo json_encode($aryData);
        exit();
    }
    function uploadImageToFolderOnce($dataImg, $id_hiden, $folder, $type, $pos = -1)
    {
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Upload Img!";
        $item_id = 0;
        if (!empty($dataImg)) {
            if ($id_hiden == 0) {
                switch ($type) {
                    case 1: //Img Banner
                        $new_row['banner_create_time'] = time();
                        $new_row['banner_status'] = CGlobal::IMAGE_ERROR;
                        $item_id = Banner::addData($new_row);
                        break;
                    case 2: //Img category
                        $new_row['category_created'] = time();
                        $new_row['category_status'] = CGlobal::IMAGE_ERROR;
                        $item_id = Category::addData($new_row);
                        break;
                    case 3: //Img category
                        $new_row['author_created'] = time();
                        $item_id = Author::addData($new_row);
                        break;
                    case 5: //Img Info
                        $new_row['info_created'] = time();
                        $new_row['info_status'] = CGlobal::IMAGE_ERROR;
                        $item_id = Info::addData($new_row);
                        break;
                    default:
                        break;
                }
            } elseif ($id_hiden > 0) {
                $item_id = $id_hiden;
            }
            if ($item_id > 0) {
                $aryError = $tmpImg = array();
                $file_name = Upload::uploadFile(
                    'multipleFile',
                    $_file_ext = 'jpg,jpeg,png,gif',
                    $_max_file_size = 50 * 1024 * 1024 * 8,
                    $_folder = $folder . '/' . $item_id,
                    $type_json = 0
                );
                if ($file_name != '' && empty($aryError)) {
                    $tmpImg['name_img'] = $file_name;
                    $tmpImg['id_key'] = rand(10000, 99999);
                    switch ($type) {
                        case 1: //Img Banner
                            $result = Banner::getById($item_id);
                            if ($result != null) {
                                $path_image = ($result->banner_image != '') ? $result->banner_image : '';
                                if ($path_image != '') {
                                    $folder_image = 'uploads/' . $folder;
                                    $this->unlinkFileAndFolder($path_image, $item_id, $folder_image, 0);
                                }
                                $path_image = $file_name;
                                $new_row['banner_image'] = $path_image;
                                Banner::updateData($item_id, $new_row);
                                $arrSize = CGlobal::$arrSizeImg;
                                if (isset($arrSize['4'])) {
                                    $size = explode('x', $arrSize['4']);
                                    if (!empty($size)) {
                                        $x = (int)$size[0];
                                        $y = (int)$size[1];
                                    } else {
                                        $x = $y = 400;
                                    }
                                }
                                $url_thumb = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_BANNER, $item_id, $file_name, $x, $y, '', true, true);
                                $tmpImg['src'] = $url_thumb;
                            }
                            break;
                        case 2: //Img Category
                            $result = Category::getById($item_id);
                            if ($result != null) {
                                $path_image = ($result->category_image != '') ? $result->category_image : '';
                                if ($path_image != '') {
                                    $folder_image = 'uploads/' . $folder;
                                    $this->unlinkFileAndFolder($path_image, $item_id, $folder_image, 0);
                                }
                                $path_image = $file_name;
                                $new_row['category_image'] = $path_image;
                                Category::updateData($item_id, $new_row);
                                $arrSize = CGlobal::$arrSizeImg;
                                if (isset($arrSize['4'])) {
                                    $size = explode('x', $arrSize['4']);
                                    if (!empty($size)) {
                                        $x = (int)$size[0];
                                        $y = (int)$size[1];
                                    } else {
                                        $x = $y = 400;
                                    }
                                }
                                $url_thumb = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_CATEGORY, $item_id, $file_name, $x, $y, '', true, true);
                                $tmpImg['src'] = $url_thumb;
                            }
                            break;


                        case 3: //Img Category
                            $result = Author::getById($item_id);
                            if ($result != null) {
                                $path_image = ($result->author_image != '') ? $result->author_image : '';
                                if ($path_image != '') {
                                    $folder_image = 'uploads/' . $folder;
                                    $this->unlinkFileAndFolder($path_image, $item_id, $folder_image, 0);
                                }
                                $path_image = $file_name;
                                $new_row['author_image'] = $path_image;
                                Author::updateData($item_id, $new_row);
                                $arrSize = CGlobal::$arrSizeImg;
                                if (isset($arrSize['4'])) {
                                    $size = explode('x', $arrSize['4']);
                                    if (!empty($size)) {
                                        $x = (int)$size[0];
                                        $y = (int)$size[1];
                                    } else {
                                        $x = $y = 400;
                                    }
                                }
                                $url_thumb = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_AUTHOR, $item_id, $file_name, $x, $y, '', true, true);
                                $tmpImg['src'] = $url_thumb;
                            }
                            break;
                        case 5: //Img Info
                            $result = Info::getById($item_id);
                            if ($result != null) {
                                $path_image = ($result->info_img != '') ? $result->info_img : '';
                                if ($path_image != '') {
                                    $folder_image = 'uploads/' . $folder;
                                    $this->unlinkFileAndFolder($path_image, $item_id, $folder_image, 0);
                                }
                                $path_image = $file_name;
                                $new_row['info_img'] = $path_image;
                                Info::updateData($item_id, $new_row);
                                $arrSize = CGlobal::$arrSizeImg;
                                if (isset($arrSize['4'])) {
                                    $size = explode('x', $arrSize['4']);
                                    if (!empty($size)) {
                                        $x = (int)$size[0];
                                        $y = (int)$size[1];
                                    } else {
                                        $x = $y = 400;
                                    }
                                }
                                $url_thumb = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_INFO, $item_id, $file_name, $x, $y, '', true, true);
                                $tmpImg['src'] = $url_thumb;
                            }
                            break;
                        default:
                            break;
                    }
                    $aryData['intIsOK'] = 1;
                    $aryData['id_item'] = $item_id;
                    $aryData['info'] = $tmpImg;
                }
            }
        }
        return $aryData;
    }
    function uploadImageToFolder($dataImg, $id_hiden, $folder, $type)
    {

        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Upload Img!";
        $item_id = 0;

        if (!empty($dataImg)) {

            if ($id_hiden == 0) {
                switch ($type) {
                    case 6: //Img Statics
                        $new_row['statics_created'] = time();
                        $new_row['statics_status'] = CGlobal::IMAGE_ERROR;
                        $item_id = Statics::addData($new_row);
                        break;
                    case 7://Img Video
                        $new_row['video_created'] = time();
                        $new_row['video_status'] = CGlobal::IMAGE_ERROR;
                        $item_id = Video::addData($new_row);
                        break;
                    default:
                        break;
                }
            } elseif ($id_hiden > 0) {
                $item_id = $id_hiden;
            }

            if ($item_id > 0) {
                $aryError = $tmpImg = array();

                $file_name = Upload::uploadFile(
                    'multipleFile',
                    $_file_ext = 'jpg,jpeg,png,gif',
                    $_max_file_size = 10 * 1024 * 1024,
                    $_folder = $folder . '/' . $item_id,
                    $type_json = 0
                );

                if ($file_name != '' && empty($aryError)) {

                    $tmpImg['name_img'] = $file_name;
                    $tmpImg['id_key'] = rand(10000, 99999);

                    switch ($type) {
                        case 6: //Img Statics
                            $result = Statics::getById($item_id);
                            if ($result != null) {
                                $aryTempImages = ($result->statics_image_other != '') ? unserialize($result->statics_image_other) : array();

                                $aryTempImages[] = $file_name;

                                $new_row['statics_image_other'] = serialize($aryTempImages);
                                Statics::updateData($item_id, $new_row);

                                $path_image = $file_name;

                                $arrSize = CGlobal::$arrSizeImg;
                                if (isset($arrSize['4'])) {
                                    $size = explode('x', $arrSize['4']);
                                    if (!empty($size)) {
                                        $x = (int)$size[0];
                                        $y = (int)$size[1];
                                    } else {
                                        $x = $y = 400;
                                    }
                                }
                                $url_thumb = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_STATICS, $item_id, $file_name, $x, $y, '', true, true);
                                $tmpImg['src'] = $url_thumb;
                            }
                            break;
                        case 7://Img Video
                            $result = Video::getById($item_id);
                            if($result != null){
                                $aryTempImages = ($result->video_image_other != '') ? unserialize($result->video_image_other) : array();

                                $aryTempImages[] = $file_name;

                                $new_row['video_image_other'] = serialize($aryTempImages);
                                Video::updateData($item_id, $new_row);

                                $path_image = $file_name;

                                $arrSize = CGlobal::$arrSizeImg;
                                if(isset($arrSize['4'])){
                                    $size = explode('x', $arrSize['4']);
                                    if(!empty($size)){
                                        $x = (int)$size[0];
                                        $y = (int)$size[1];
                                    }else{
                                        $x = $y = 400;
                                    }
                                }
                                $url_thumb = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_VIDEO, $item_id, $file_name, $x, $y, '', true, true);
                                $tmpImg['src'] = $url_thumb;
                            }
                            break;
                        default:
                            break;
                    }

                    $aryData['intIsOK'] = 1;
                    $aryData['id_item'] = $item_id;
                    $aryData['info'] = $tmpImg;
                }
            }
        }
        return $aryData;
    }
    public function  uploadVideoToFolder($dataImg, $id_hiden, $folder, $type){
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Upload Video!";
        $item_id = 0;

        if (!empty($dataImg)) {

            if($id_hiden == 0){
                switch($type){
                    case 8://Video
                        $new_row['video_created'] = time();
                        $new_row['video_status'] = CGlobal::IMAGE_ERROR;
                        $item_id = Video::addData($new_row);
                        break;
                    default:
                        break;
                }
            }elseif($id_hiden > 0){
                $item_id = $id_hiden;
            }

            if($item_id > 0){
                $aryError = $tmpImg = array();

                $file_name = Upload::uploadFile('multipleFile',
                    $_file_ext = 'mp4,flv,mov',
                    $_max_file_size = 10*1024*1024*1080,
                    $_folder = $folder.'/'.$item_id,
                    $type_json=0);

                if ($file_name != '' && empty($aryError)){

                    $tmpImg['name_img'] = $file_name;
                    $tmpImg['id_key'] = rand(10000, 99999);

                    switch($type){
                        case 8://Video
                            $result = Video::getById($item_id);
                            if($result != null){
                                $new_row['video_path'] = $file_name;
                                Video::updateData($item_id, $new_row);
                                $tmpImg['src'] = FuncLib::getBaseUrl().'uploads/'.CGlobal::FOLDER_VIDEO_1.'/'.$item_id.'/'.$file_name;
                            }
                            break;
                        default:
                            break;
                    }

                    $aryData['intIsOK'] = 1;
                    $aryData['id_item'] = $item_id;
                    $aryData['info'] = $tmpImg;
                }
            }
        }
        return $aryData;
    }
    function remove_image(){
        $id = (int)Request::get('id', 0);
        $nameImage = Request::get('nameImage', '');
        $type = (int)Request::get('type', 1);
        $pos = Request::get('pos', -1);
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Remove Img!";
        $aryData['nameImage'] = $nameImage;
        switch ($type) {
            case 2: //File Category
                $folder_image = 'uploads/' . CGlobal::FOLDER_CATEGORY;
                if ($id > 0 && $nameImage != '' && $folder_image != '') {
                    $delete_action = $this->delete_image_item($id, $nameImage, $folder_image, $type);
                    if ($delete_action == 1) {
                        $aryData['intIsOK'] = 1;
                        $aryData['msg'] = "Remove Img!";
                    }
                }
                break;
            case 6: //Img Statics
                $folder_image = 'uploads/' . CGlobal::FOLDER_STATICS;

                if ($id > 0 && $nameImage != '' && $folder_image != '') {
                    $delete_action = $this->delete_image_item($id, $nameImage, $folder_image, $type);
                    if ($delete_action == 1) {
                        if ($delete_action == 1) {
                            $aryData['intIsOK'] = 1;
                            $aryData['msg'] = "Remove Img!";
                        }
                    }
                }
                break;
            case 7://Img Video
                $folder_image = 'uploads/'.CGlobal::FOLDER_VIDEO;

                if($id > 0 && $nameImage != '' && $folder_image != ''){
                    $delete_action = $this->delete_image_item($id, $nameImage, $folder_image, $type);

                    if($delete_action == 1){

                        $aryData['intIsOK'] = 1;
                        $aryData['msg'] = "Remove Img!";
                    }
                }
                break;
            default:
                break;
        }
        echo json_encode($aryData);
        exit();
    }
    function remove_video(){
        $id = (int)Request::get('id', 0);
        $nameVideo = Request::get('nameVideo', '');
        $type = (int)Request::get('type', 1);
        $pos = Request::get('pos', -1);
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Remove Video!";
        $aryData['nameVideo'] = $nameVideo;
        switch( $type ){
            case 8:// Video
                $folder_video = 'uploads/'.CGlobal::FOLDER_VIDEO_1;

                if($id > 0 && $nameVideo != '' && $folder_video != ''){
                    $delete_action = $this->delete_video_item($id, $nameVideo, $folder_video, $type);

                    if($delete_action == 1){
                        $aryData['intIsOK'] = 1;
                        $aryData['msg'] = "Remove Video!";
                    }
                }
                break;
            default:
                break;
        }
        echo json_encode($aryData);
        exit();
    }
    function delete_image_item($id, $nameImage, $folder_image, $type){
        $delete_action = 0;
        $aryImages  = array();
        switch ($type) {
            case 2: //File category
                $result = Category::getById($id);
                if ($result != null) {
                    $aryImages[] = $result->category_image;
                }
                break;
            case 3: //File category
                $result = Author::getById($id);
                if ($result != null) {
                    $aryImages[] = $result->author_image;
                }
                break;    
                
            case 6: //Img Statics
                $result = Statics::getById($id);
                if ($result != null) {
                    $aryImages = unserialize($result->statics_image_other);
                }
                break;
            case 7://Img Training
                $result = Video::getById($id);
                if($result != null){
                    $aryImages = unserialize($result->video_image_other);
                }
                break;
            
            default:
                $folder_image = '';
                break;
        }
        if (is_array($aryImages) && count($aryImages) > 0) {
            foreach ($aryImages as $k => $v) {
                if ($v === $nameImage) {
                    $this->unlinkFileAndFolder($nameImage, $id, $folder_image, true);
                    unset($aryImages[$k]);
                    if (!empty($aryImages)) {
                        $aryImages = serialize($aryImages);
                    } else {
                        $aryImages = '';
                    }
                    switch ($type) {
                        case 2: //File category
                            $new_row['category_image'] = '';
                            Category::updateData($id, $new_row);
                            break;
                        case 3: //File category
                            $new_row['author_image'] = '';
                            Author::updateData($id, $new_row);
                            break;    
                        case 6: //Img Statics
                            $new_row['statics_image_other'] = $aryImages;
                            Statics::updateData($id, $new_row);
                            break;
                        case 7://Img Video
                            $new_row['video_image_other'] = $aryImages;
                            Video::updateData($id, $new_row);
                            break;
                        default:
                            $folder_image = '';
                            break;
                    }
                    $delete_action = 1;
                    break;
                }
            }
        }
        //xoa khi chua update vao db, anh moi up load
        if ($delete_action == 0) {
            $this->unlinkFileAndFolder($nameImage, $id, $folder_image, true);
            $delete_action = 1;
        }
        return $delete_action;
    }
    function delete_video_item($id, $nameVideo, $folder_video, $type){
        $delete_action = 0;
        $aryVideo  = array();
        switch( $type ){
            case 8://Video
                $result = Video::getById($id);
                if($result != null){
                    $aryVideo = unserialize($result->video_path);
                }
                break;
            default:
                $folder_video = '';
                break;
        }
        if(is_array($aryVideo) && count($aryVideo) > 0) {
            foreach ($aryVideo as $k => $v) {
                if($v === $nameVideo){
                    $this->unlinkFileAndFolder($nameVideo, $id, $folder_video, true);
                    unset($aryVideo[$k]);
                    if(!empty($aryVideo)){
                        $aryVideo = serialize($aryVideo);
                    }else{
                        $aryVideo = '';
                    }
                    switch( $type ){
                        case 7://Img Video
                            $new_row['video_path'] = $aryVideo;
                            Video::updateData($id, $new_row);
                            break;
                        default:
                            $folder_video = '';
                            break;
                    }
                    $delete_action = 1;
                    break;
                }
            }
        }
        //xoa khi chua update vao db, anh moi up load
        if($delete_action == 0){
            $this->unlinkFileAndFolder($nameVideo, $id, $folder_video, true);
            $delete_action = 1;
        }
        return $delete_action;
    }
    function unlinkFileAndFolder($file_name = '', $id = 0, $folder = '', $is_delDir = 0){
        if($file_name != '') {
            //Remove Img In Database
            $paths = '';
            if ($folder != '' && $id > 0) {
                $path = FuncLib::getRootPath() . '/' . $folder . '/' . $id;
            }
            if ($file_name != '') {
                if ($path != '') {
                    if (is_file($path . '/' . $file_name)) {
                        @unlink($path . '/' . $file_name);
                    }
                }
            }
            //Remove Folder Empty
            if ($is_delDir) {
                if ($path != '') {
                    if (is_dir($path)) {
                        @rmdir($path);
                    }
                }
            }
        }
    }
    //Get Img Content
    function get_image_insert_content()
    {

        $id_hiden = (int)Request::get('id_hiden', 0);
        $type = (int)Request::get('type', 1);
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Data not exists!";

        if ($id_hiden > 0) {
            switch ($type) {
                case 6: //Img Statics
                    $aryData = $this->getImgContent($id_hiden, CGlobal::FOLDER_STATICS, $type);
                    break;
                case 7://Img Training
                    $aryData = $this->getImgContent($id_hiden, CGlobal::FOLDER_VIDEO, $type);
                    break;
                default:
                    break;
            }
        }
        echo json_encode($aryData);
        exit();
    }
    function getImgContent($id_hiden, $folder, $type)
    {

        $aryImages = array();
        $aryData = array();

        switch ($type) {
            case 6: //Img Statics
                $result = Statics::getById($id_hiden);
                if ($result != null) {
                    $aryImages = ($result->statics_image_other != '') ? unserialize($result->statics_image_other) : array();
                }
                if($result != null){
                    $aryImages = ($result->statics_image_other != '') ? unserialize($result->statics_image_other) : array();
                }
                break;
            case 7://Img Video
                $result = Video::getById($id_hiden);
                if($result != null){
                    $aryImages = ($result->video_image_other != '') ? unserialize($result->video_image_other) : array();
                }
                break;
           
            default:
                break;
        }

        if (is_array($aryImages) && !empty($aryImages)) {
            foreach ($aryImages as $k => $item) {
                $aryData['item'][$k]['large'] = ThumbImg::thumbBaseNormal($folder, $id_hiden, $item, 800, 800, '', true, true);
                $aryData['item'][$k]['small'] = ThumbImg::thumbBaseNormal($folder, $id_hiden, $item, 400, 400, '', true, true);
            }
        }

        $aryData['intIsOK'] = 1;
        $aryData['msg'] = "Data exists!";
        return $aryData;
    }
}
