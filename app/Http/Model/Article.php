<?php
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;

class Article extends Model{
    const publics=0;//0公开
    const privates=1;//1未公开加密
    public function zhuanhuan($key=null){
        $arr=[
            self::publics=>'公开',
            self::privates=>'加密',
        ];
        if($key!=null){
            return $arr[$key];
        }
        return $arr;
    }
    //指定表名
    protected  $table='article';
    //指定key
    protected $primaryKey='id';
    //使用模型添加数据 时间关闭
    public $timestamps=false;
    //create 方法新添数据需要指定允许批量添加
    protected $fillable=['user_id','title','content','keywords','describe','clumn','label','comment','title_pic','visibility','updated_at','created_at','is_del'];
}