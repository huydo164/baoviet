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

class Statics extends Model {

    protected $table = CDatabase::statics;
    protected $primaryKey = 'statics_id';
    public  $timestamps = false;

    protected $fillable = array(
        'statics_id', 'statics_catid', 'statics_cat_name', 'statics_cat_alias', 'statics_title', 'statics_intro', 'statics_content', 'statics_view_num',
        'statics_image', 'statics_image_other','author_id', 'statics_created', 'statics_order_no', 'statics_focus', 'statics_status', 'statics_word', 'meta_title', 'meta_keywords', 'meta_description', 'statics_tag');

    public static function searchByCondition($dataSearch=array(), $limit=0, $offset=0, &$total){
        try{

            $query = Statics::where('statics_id','>',0);

            if (isset($dataSearch['statics_title']) && $dataSearch['statics_title'] != '') {
                $query->where('statics_title','LIKE', '%' . $dataSearch['statics_title'] . '%');
            }
            if (isset($dataSearch['statics_status']) && $dataSearch['statics_status'] != -1) {
                $query->where('statics_status', $dataSearch['statics_status']);
            }

            if(isset($dataSearch['statics_catid']) && $dataSearch['statics_catid'] != -1){
                $catid = $dataSearch['statics_catid'];
                $arrCat = array($catid);
                Category::makeListCatId($catid, 0, $arrCat);
                if(is_array($arrCat) && !empty($arrCat)){
                    $query->whereIn('statics_catid', $arrCat);
                }
            }

            if (isset($dataSearch['statics_id'])) {
                if(is_array($dataSearch['statics_id']) && !empty($dataSearch['statics_id'])){
                    $query->whereIn('statics_id', $dataSearch['statics_id']);
                }else{
                    if($dataSearch['statics_id'] > 0){
                        $query->where('statics_id', $dataSearch['statics_id']);
                    }
                }
            }

            $total = $query->count(['statics_id']);
            $query->orderBy('statics_id', 'asc');

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

        $result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_STATICS_ID.$id) : array();
        try {
            if(empty($result)){
                $result = Statics::where('statics_id', $id)->first();
                if($result && Memcache::CACHE_ON){
                    Cache::put(Memcache::CACHE_STATICS_ID.$id, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
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
            $data = Statics::getById($id);
            if($id > 0 && !empty($dataInput)){
                $data->update($dataInput);
                if(isset($data->statics_id) && $data->statics_id > 0){
                    self::removeCacheId($data->statics_id);
                    self::removeCacheCatId($data->statics_catid);
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
            $data = new Statics();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if($data->statics_id && Memcache::CACHE_ON){
                    Statics::removeCacheId($data->statics_id);
                    self::removeCacheCatId($data->statics_catid);
                }
                return $data->statics_id;
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
            $id = Statics::updateData($id, $data_post);
            Utility::messages('messages', 'Cập nhật thành công!');
        }else{
            $id = Statics::addData($data_post);
            Utility::messages('messages', 'Thêm mới thành công!');
        }
        return $id;
    }

    public static function deleteId($id=0){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = Statics::find($id);
            if($data != null){

                //Remove Img
                $statics_image_other = ($data->statics_image_other != '') ? unserialize($data->statics_image_other) : array();
                if(is_array($statics_image_other) && !empty($statics_image_other)){
                    $path = Config::get('config.DIR_ROOT').'uploads/'.CGlobal::FOLDER_STATICS.'/'.$id;
                    foreach($statics_image_other as $v){
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
                if(isset($data->statics_id) && $data->statics_id > 0){
                    self::removeCacheId($data->statics_id);
                    self::removeCacheCatId($data->statics_catid);
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
            Cache::forget(Memcache::CACHE_STATICS_ID.$id);
        }
    }

    public static function removeCacheCatId($catid=0){
        if($catid>0){
            Cache::forget(Memcache::CACHE_STATICS_CAT_ID.$catid);
        }
    }

    public static function searchByConditionCatid($catid=0, $limit=0, $dataSearch=array()){
        $result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_STATICS_CAT_ID.$catid) : array();
        try{
            if(empty($result)){
                $query = Statics::where('statics_id','>',0);
                $query->where('statics_status','=',CGlobal::status_show);
                if($catid != -1){
                    $arrCat = array($catid);
                    Category::makeListCatId($catid, 0, $arrCat);
                    if(is_array($arrCat) && !empty($arrCat)){
                        $query->whereIn('statics_catid', $arrCat);
                    }
                }
                $query->orderBy('statics_order_no', 'asc');

                if($limit > 0){
                    $query->take($limit);
                }
                $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
                if(!empty($fields)){
                    $result = $query->take($limit)->get($fields);
                }else{
                    $result = $query->take($limit)->get();
                }

                if($result && Memcache::CACHE_ON){
                    Cache::put(Memcache::CACHE_STATICS_CAT_ID.$catid, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
                }
            }
            return $result;
        }catch (PDOException $e){
            throw new PDOException();
        }
    }

    public static function getFocus($dataSearch=array(), $limit=10){
        $result = array();
        try{
            if($limit > 0){
                $query = Statics::where('statics_id','>', 0);
                $query->where('statics_focus', CGlobal::status_show);
                $query->where('statics_status', CGlobal::status_show);


                if(isset($dataSearch['statics_catid']) && $dataSearch['statics_catid'] != 0){
                    $query->where('statics_catid', $dataSearch['statics_catid']);
                }

                if(isset($dataSearch['statics_order_no']) && $dataSearch['statics_order_no'] == 'asc'){
                    $query->orderBy('statics_order_no', 'asc');
                }else{
                    $query->orderBy('statics_id', 'desc');
                }

                $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
                if(!empty($fields)){
                    $result = $query->take($limit)->get($fields);
                }else{
                    $result = $query->take($limit)->get();
                }

            }

        }catch (PDOException $e){
            throw new PDOException();
        }
        return $result;
    }

    public static function getSameData($id, $catId, $limit=10, $dataSearch=array()){
        $result = array();
        try{
            if($limit > 0){
                $query = Statics::where('statics_id','>', 0);
                $query->where('statics_status', CGlobal::status_show);
                $query->where('statics_id','<>', $id);
                $query->where('statics_catid', $catId);
                $query->orderBy('statics_id', 'desc');
                $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
                $result = $query->take($limit)->get($fields);
            }

        }catch (PDOException $e){
            throw new PDOException();
        }
        return $result;
    }
    public static function searchByConditionOnePage($dataSearch=array(), $limit=0){
        try{

            $query = Statics::where('statics_id','>',0);

            if (isset($dataSearch['statics_title']) && $dataSearch['statics_title'] != '') {
                $query->where('statics_title','LIKE', '%' . $dataSearch['statics_title'] . '%');
            }
            if (isset($dataSearch['statics_status']) && $dataSearch['statics_status'] != -1) {
                $query->where('statics_status', $dataSearch['statics_status']);
            }
            if (isset($dataSearch['statics_focus']) && $dataSearch['statics_focus'] != -1) {
                $query->where('statics_focus', $dataSearch['statics_focus']);
            }


            if(isset($dataSearch['statics_catid']) && $dataSearch['statics_catid'] != -1){
                $catid = $dataSearch['statics_catid'];
                $arrCat = array($catid);
                Category::makeListCatId($catid, 0, $arrCat);
                if(is_array($arrCat) && !empty($arrCat)){
                    $query->whereIn('statics_catid', $arrCat);
                }
            }

            if (isset($dataSearch['statics_id'])) {
                if(is_array($dataSearch['statics_id']) && !empty($dataSearch['statics_id'])){
                    $query->whereIn('statics_id', $dataSearch['statics_id']);
                }else{
                    if($dataSearch['statics_id'] > 0){
                        $query->where('statics_id', $dataSearch['statics_id']);
                    }
                }
            }


            $query->orderBy('statics_id', 'asc');

            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
            if(!empty($fields)){
                $result = $query->take($limit)->get($fields);
            }else{
                $result = $query->take($limit)->get();
            }
            return $result;

        }catch (PDOException $e){
            throw new PDOException();
        }
    }
    public static function getPopularPost($dataSearch=array(), $limit=10){
        $result = array();
        try{
            if($limit > 0){
                $query = Statics::where('statics_id','>', 0);
                $query->where('statics_status', CGlobal::status_show);
                $query->orderBy('statics_created', 'asc')->orderBy('statics_view_num','asc');
                $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
                $result = $query->take($limit)->get($fields);
            }

        }catch (PDOException $e){
            throw new PDOException();
        }
        return $result;
    }
    public static function getByAuthor($id, $limit=10,$offset=0){
        try{

            $query = Statics::where('statics_id','>',0);

            if (isset($id) ) {
                $query = Statics::where('author_id',$id);
            }

            $total = $query->count(['statics_id']);
            $query->orderBy('statics_id', 'asc');

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
}
