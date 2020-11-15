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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Library\PHPDev\Memcache;
use App\Library\PHPDev\Utility;
use PDOException;

class Author extends Model {

    protected $table = 'author';
    protected $primaryKey = 'author_id';
    public  $timestamps = false;

    protected $fillable = array(
        'author_id', 'user_id', 'author_name', 'author_image', 'author_content');

    public static function searchByCondition($dataSearch=array(), $limit=0, $offset=0, &$total){
        try{

            $query = author::where('author_id','>',0);

            if (isset($dataSearch['author_name']) && $dataSearch['author_name'] != '') {
                $query->where('author_name','LIKE', '%' . $dataSearch['author_name'] . '%');
            }
            

            $total = $query->count();
            $query->orderBy('author_id', 'desc');

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
        $result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_AUTHOR_ID.$id) : array();
        try {
            if(empty($result)){
                $result = Author::where('author_id', $id)->first();
                if($result && Memcache::CACHE_ON){
                    Cache::put(Memcache::CACHE_AUTHOR_ID.$id, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
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
            $data = Author::find($id);
            if($id > 0 && !empty($dataInput)){
                $data->update($dataInput);
                if(isset($data->author_id) && $data->author_id > 0){
                    self::removeCacheId($data->author_id);
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
            $data = new Author();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if($data->author_id && Memcache::CACHE_ON){
                    author::removeCacheId($data->author_id);
                }
                return $data->author_id;
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
            author::updateData($id, $data_post);
            Utility::messages('messages', 'Cập nhật thành công!');
        }else{
            author::addData($data_post);
            Utility::messages('messages', 'Thêm mới thành công!');
        }

    }

    public static function deleteId($id=0){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = Author::find($id);
            if($data != null){
                $data->delete();
                if(isset($data->author_id) && $data->author_id > 0){
                    self::removeCacheId($data->author_id);
                }
                DB::connection()->getPdo()->commit();
            }
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function getName($id=0){
        $result = Author::find($id);
        $name = $result->author_name;
        return $name;
    }

    public static function removeCacheId($id=0){
        if($id>0){
            Cache::forget(Memcache::CACHE_AUTHOR_ID.$id);
        }
    }
}
