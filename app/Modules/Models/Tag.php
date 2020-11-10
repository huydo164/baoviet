<?php

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

class Tag extends Model{
    protected $table = CDatabase::tag;
    protected $primaryKey = 'tag_id';
    public $timestamps = false;

    protected $fillable = array(
        'tag_id', 'tag_title'
    );

    public static function searchByCondition($dataSearch=array(), $limit=0, $offset=0, &$total){
        try{

            $query = Tag::where('tag_id','>',0);

            if (isset($dataSearch['tag_title']) && $dataSearch['tag_title'] != '') {
                $query->where('tag_title','LIKE', '%' . $dataSearch['tag_title'] . '%');
            }

            $total = $query->count(['tag_id']);
            $query->orderBy('tag_id', 'asc');

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
        $result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_TAG_ID.$id) : array();
        try {
            if(empty($result)){
                $result = Tag::where('tag_id', $id)->first();
                if($result && Memcache::CACHE_ON){
                    Cache::put(Memcache::CACHE_TAG_ID.$id, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
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
            $data = Tag::getById($id);
            if($id > 0 && !empty($dataInput)){
                $data->update($dataInput);
                if(isset($data->tag_id) && $data->tag_id > 0){
                    self::removeCacheId($data->tag_id);
                }
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function addData($dataInput=array()){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new Tag();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if($data->tag_id && Memcache::CACHE_ON){
                    Tag::removeCacheId($data->tag_id);
                }
                return $data->tag_id;
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
            Tag::updateData($id, $data_post);
            Utility::messages('messages', 'Cập nhật thành công!');
        }else{
            Tag::addData($data_post);
            Utility::messages('messages', 'Thêm mới thành công!');
        }

    }

    public static function deleteId($id=0){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = Tag::find($id);
            if($data != null){
                $data->delete();
                if(isset($data->type_id) && $data->type_id > 0){
                    self::removeCacheId($data->type_id);
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
            Cache::forget(Memcache::CACHE_TAG_ID.$id);
        }
    }

    public static function getAllTag($data = array(), $limit = 0){
        try{
            $result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_ALL_TAG) : array();

            if (empty($result)){
                $query = Tag::where('tag_id', '>', 0);
                $fields = (isset($data['field_get']) && trim($data['field_get']) != '') ? explode(',',trim($data['field_get'])): array();

                if($limit > 0){
                    $query->take($limit);
                }

                if(!empty($fields)){
                    $result = $query->get($fields);
                }else{
                    $result = $query->get();
                }
                if($result && Memcache::CACHE_ON){
                    Cache::put(Memcache::CACHE_ALL_TAG, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
                }
            }
        }
        catch (PDOException $e){
            throw new PDOException();
        }

        return $result;
    }
}