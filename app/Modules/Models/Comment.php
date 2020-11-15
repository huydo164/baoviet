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
use App\Library\PHPDev\FuncLib;
use App\Library\PHPDev\Memcache;
use App\Library\PHPDev\Utility;
use PDOException;

class Comment extends Model {

    protected $table = 'comment_statics';
    protected $primaryKey = 'comment_id';
    public  $timestamps = false;

    protected $fillable = array('comment_id','statics_id','comment_name','comment_email','comment_detail','comment_web','comment_ip','comment_created','comment_status');

    public static function searchByCondition($dataSearch=array(), $limit=0, $offset=0, &$total){
        try{

            $query = Comment::where('comment_id','>',0);


            if (isset($dataSearch['comment_id']) && $dataSearch['comment_id'] != 0) {
                $query->where('comment_id', $dataSearch['comment_id']);
            }
            if (isset($dataSearch['comment_status']) && $dataSearch['comment_status'] != 0) {
                $query->where('comment_status', '=' ,$dataSearch['comment_status']);
            }

            $total = $query->count(['comment_id']);
            $query->orderBy('comment_id', 'asc');

            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
            if(!empty($fields)){
                $result = $query->take($total)->skip($offset)->get($fields);
            }else{
                $result = $query->take($total)->skip($offset)->get();
            }
            return $result;

        }catch (PDOException $e){
            throw new PDOException();
        }
    }

    public static function getById($id=0){

        $result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_COMMENT_ID.$id) : array();
        try {
            if(empty($result)){
                $result = Comment::where('comment_id', $id)->first();
                if($result && Memcache::CACHE_ON){
                    Cache::put(Memcache::CACHE_RATING_ID.$id, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
                }
            }
        } catch (PDOException $e) {
            throw new PDOException();
        }

        return $result;
    }
    public static function getByStaticId($id=0){
        $result = Comment::where('statics_id', $id)->get();
        return $result;
    }

    public static function checkIp($id = 0 , $ip = '')
    {
        $result = Comment::where('comment_id',$id)->where('comment_ip','LIKE',$ip)->get();
        return $result;
    }

    public static function updateData($id=0, $dataInput=array()){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = Comment::getById($id);
            if($id > 0 && !empty($dataInput)){

                $data->update($dataInput);
                if(isset($data->comment_id) && $data->comment_id > 0){
                    self::removeCacheId($data->comment_id);

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
            $data = new Comment();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }

            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if($data->comment_id && Memcache::CACHE_ON){
                    Comment::removeCacheId($data->comment_id);
                }
                return $data->comment_id;
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

            Comment::updateData($id, $data_post);
            Utility::messages('messages', 'Cập nhật thành công!');
        }else{

            Comment::addData($data_post);
            Utility::messages('messages', 'Thêm mới thành công!');
        }

    }

    public static function deleteId($id=0){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = Comment::find($id);
            if($data != null){


                $data->delete();
                if(isset($data->comment_id) && $data->comment_id > 0){
                    self::removeCacheId($data->comment_id);

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
            Cache::forget(Memcache::CACHE_COMMENT_ID.$id);
        }
    }





}
