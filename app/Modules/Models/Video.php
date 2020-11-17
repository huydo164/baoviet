<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/
namespace App\Modules\Models;

use App\Library\PHPDev\CDatabase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Library\PHPDev\CGlobal;
use App\Library\PHPDev\Memcache;
use App\Library\PHPDev\Utility;
use PDOException;

class Video extends Model {

    protected $table = CDatabase::video;
    protected $primaryKey = 'video_id';
    public  $timestamps = false;

    protected $fillable = array(
        'video_id', 'video_catid', 'video_cat_name', 'video_cat_alias', 'video_title', 'video_intro', 'video_content', 'video_view_num', 'video_path',
        'video_image', 'video_image_other', 'video_created', 'video_order_no', 'video_focus', 'video_status', 'video_word', 'meta_title', 'meta_keywords', 'meta_description', 'video_tag', 'video_youtube', 'author_name');

    public static function searchByCondition($dataSearch=array(), $limit=0, $offset=0, &$total){
        try{

            $query = Video::where('video_id','>',0);

            if (isset($dataSearch['video_title']) && $dataSearch['video_title'] != '') {
                $query->where('video_title','LIKE', '%' . $dataSearch['video_title'] . '%');
            }
            if (isset($dataSearch['video_status']) && $dataSearch['video_status'] != -1) {
                $query->where('video_status', $dataSearch['video_status']);
            }

            if(isset($dataSearch['video_catid']) && $dataSearch['video_catid'] != -1){
                $catid = $dataSearch['video_catid'];
                $arrCat = array($catid);
                Category::makeListCatId($catid, 0, $arrCat);
                if(is_array($arrCat) && !empty($arrCat)){
                    $query->whereIn('video_catid', $arrCat);
                }
            }

            if (isset($dataSearch['video_id'])) {
                if(is_array($dataSearch['video_id']) && !empty($dataSearch['video_id'])){
                    $query->whereIn('video_id', $dataSearch['video_id']);
                }else{
                    if($dataSearch['video_id'] > 0){
                        $query->where('video_id', $dataSearch['video_id']);
                    }
                }
            }

            $total = $query->count(['video_id']);
            $query->orderBy('video_id', 'asc');

            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
            if(!empty($fields)){
                $result = $query->take($limit)->skip($offset)->get($fields);
            }else{
                $result = $query->take($limit)->skip($offset)->get();
            }
            return $result;

        }catch (PDOException $e){
            throw new PDOException();
        }
    }

    public static function getById($id=0){

        $result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_VIDEO_ID.$id) : array();
        try {
            if(empty($result)){
                $result = Video::where('video_id', $id)->first();
                if($result && Memcache::CACHE_ON){
                    Cache::put(Memcache::CACHE_VIDEO_ID.$id, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
                }
            }
        } catch (PDOException $e) {
            throw new PDOException();
        }

        return $result;
    }

    public static function updateData($id=0, $dataInput=array()){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = Video::getById($id);
            if($id > 0 && !empty($dataInput)){
                $data->update($dataInput);
                if(isset($data->video_id) && $data->video_id > 0){
                    self::removeCacheId($data->video_id);
                    self::removeCacheCatId($data->video_catid);
                }
            }
            DB::connection()->getPdo()->commit();
            return $id;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function addData($dataInput=array()){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new Video();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if($data->video_id && Memcache::CACHE_ON){
                    Video::removeCacheId($data->video_id);
                    self::removeCacheCatId($data->video_catid);
                }
                return $data->video_id;
            }
            DB::connection()->getPdo()->commit();
            return false;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function saveData($id=0, $data=array()){
        $data_post = array();
        if(!empty($data)){
            foreach($data as $key=>$val){
                $data_post[$key] = $val['value'];
            }
        }
        if($id > 0){
            $id = Video::updateData($id, $data_post);
            Utility::messages('messages', 'Cập nhật thành công!');
        }else{
            $id = Video::addData($data_post);
            Utility::messages('messages', 'Thêm mới thành công!');
        }
        return $id;
    }

    public static function deleteId($id=0){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = Video::find($id);
            if($data != null){

                //Remove Img
                $video_image_other = ($data->video_image_other != '') ? unserialize($data->video_image_other) : array();
                if(is_array($video_image_other) && !empty($video_image_other)){
                    $path = Config::get('config.DIR_ROOT').'uploads/'.CGlobal::FOLDER_VIDEO.'/'.$id;
                    foreach($video_image_other as $v){
                        if(is_file($path.'/'.$v)){
                            @unlink($path.'/'.$v);
                        }
                    }
                    if(is_dir($path)) {
                        @rmdir($path);
                    }
                }
                //End Remove Img
                $data->delete();
                if(isset($data->video_id) && $data->video_id > 0){
                    self::removeCacheId($data->video_id);
                    self::removeCacheCatId($data->video_catid);
                }
                DB::connection()->getPdo()->commit();
            }
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function removeCacheId($id=0){
        if($id>0){
            Cache::forget(Memcache::CACHE_VIDEO_ID.$id);
        }
        Cache::forget(Memcache::CACHE_VIDEO_FOCUS);
    }

    public static function removeCacheCatId($catid=0){
        if($catid>0){
            Cache::forget(Memcache::CACHE_VIDEO_CAT_ID.$catid);
        }
    }

    public static function getFocus($dataSearch=array(), $limit=10){
        $result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_VIDEO_FOCUS) : array();
        try{
            if (empty($result)){
                if($limit > 0){
                    $query = Video::where('video_id','>', 0);
                    $query->where('video_focus', CGlobal::status_show);
                    $query->where('video_status', CGlobal::status_show);


                    if(isset($dataSearch['video_catid']) && $dataSearch['video_catid'] != 0){
                        $query->where('video_catid', $dataSearch['video_catid']);
                    }

                    if(isset($dataSearch['video_order_no']) && $dataSearch['video_order_no'] == 'asc'){
                        $query->orderBy('video_order_no', 'asc');
                    }else{
                        $query->orderBy('video_id', 'desc');
                    }

                    $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
                    if(!empty($fields)){
                        $result = $query->take($limit)->get($fields);
                    }else{
                        $result = $query->take($limit)->get();
                    }

                }
                if($result && Memcache::CACHE_ON){
                    Cache::put(Memcache::CACHE_VIDEO_FOCUS,$result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
                }
            }
        }catch (PDOException $e){
            throw new PDOException();
        }
        return $result;
    }

    public static function getSameData($id, $catId, $limit=10, $dataSearch=array()){
        $result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_VIDEO_SAME) : array();
        try{
            if (empty($result)){
                if($limit > 0){
                    $query = video::where('video_id','>', 0);
                    $query->where('video_status', CGlobal::status_show);
                    $query->where('video_id','<>', $id);
                    $query->where('video_catid', $catId);
                    $query->orderBy('video_id', 'asc');
                    $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
                    $result = $query->take($limit)->get($fields);
                }
                if ($result && Memcache::CACHE_ON){
                    Cache::put(Memcache::CACHE_VIDEO_SAME,$result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
                }
            }
        }catch (PDOException $e){
            throw new PDOException();
        }
        return $result;
    }
}
