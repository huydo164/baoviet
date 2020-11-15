<?php
/*
* @Created by: DUYNX
* @Author    : duynx@peacesoft.net / nguyenduypt86@gmail.com
* @Date      : 08/2019
* @Version   : 1.0
*/
$namespace = '\App\Modules\Statics\Controllers';

Route::group(['middleware' => ['web'], 'prefix' => '/', 'namespace' => $namespace], function(){
    Route::get('403', array('as' => 'page.403','uses' => 'BaseStaticsController@page403'));
    Route::get('404', array('as' => 'page.404','uses' => 'BaseStaticsController@page404'));

    Route::get('{name}-{id}.html',array('as' => 'site.actionRouter','uses' =>'StaticsController@actionRouter', 'permission_name'=>'Tin tức'))->where('name', '[A-Z0-9a-z)_\-]+')->where('id', '[0-9]+');

    Route::get('/', array('as' => 'SIndex','uses' => 'StaticsController@index'));
    Route::get('author', array('as' => 'page.Author','uses' => 'StaticsController@author'));

    Route::get('danh-muc/{name}-{id}.html', array('as' => 'page.danhmuc','uses' => 'StaticsController@danhmuc'))->where('name', '[A-Z0-9a-z_\-]+')->where('id', '[0-9]+');;
    Route::get('chi-tiet-bai-viet/{name}-{id}.html', array('as' => 'site.pageStaticsDetail','uses' => 'StaticsController@StaticDetail'))->where('name', '[A-Z0-9a-z_\-]+')->where('id', '[0-9]+');
    Route::get('tac-gia/{name}-{id}.html', array('as' => 'site.pageAuthor','uses' => 'StaticsController@pageAuthor'))->where('name', '[A-Z0-9a-z_\-]+')->where('id', '[0-9]+');
    Route::post('binh-luan', array('as' => 'page.binhluan','uses' => 'StaticsController@binhluan'));

    Route::get('danh-muc/{name}-{id}.html', array('as' => 'page.danhmuc','uses' => 'StaticsController@danhmuc'))->where('name', '[A-Z0-9a-z_\-]+')->where('id', '[0-9]+');
    Route::get('chi-tiet-bai-viet/{name}-{id}.html', array('as' => 'site.pageStaticsDetail','uses' => 'StaticsController@StaticDetail'))->where('name', '[A-Z0-9a-z_\-]+')->where('id', '[0-9]+');

    Route::get('cate-2', array('as' => 'page.Cate-2','uses' => 'StaticsController@cate2'));
    Route::get('cate-3', array('as' => 'page.Cate-3','uses' => 'StaticsController@cate3'));
    Route::get('contact', array('as' => 'page.contact','uses' => 'StaticsController@contact'));
    Route::post('contactPost', array('as' => 'page.contactPost','uses' => 'StaticsController@contactPost'));
    Route::get('static', array('as' => 'page.static','uses' => 'StaticsController@static'));

    Route::get('video-{id}.html', array('as' => 'site.video', 'uses' => 'StaticsController@pageVideo'));
    Route::get('Chi-tiet-bai-viet/{name}-{id}.html', array('as' => 'site.detailVideo', 'uses' => 'StaticsController@videoDetail'))->where('name', '[A-Z0-9a-z_\-]+')->where('id', '[0-9]+');

});