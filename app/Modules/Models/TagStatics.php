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

class TagStatics extends Model{
    protected $table = CDatabase::tag_statics;
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = array(
        'id', 'tag_id', 'statics_id'
    );
}