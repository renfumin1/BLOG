<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Column;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
class ColumnController extends Controller
{
//| GET|HEAD                       | admin/column               | column.index      | App\Http\Controllers\Admin\ColumnController@index        | web,admin.login |
//|        | POST                           | admin/column               | column.store      | App\Http\Controllers\Admin\ColumnController@store        | web,admin.login |
//|        | GET|HEAD                       | admin/column/create        | column.create     | App\Http\Controllers\Admin\ColumnController@create       | web,admin.login |
//|        | DELETE                         | admin/column/{column}      | column.destroy    | App\Http\Controllers\Admin\ColumnController@destroy      | web,admin.login |
//|        | PUT|PATCH                      | admin/column/{column}      | column.update     | App\Http\Controllers\Admin\ColumnController@update       | web,admin.login |
//|        | GET|HEAD                       | admin/column/{column}      | column.show       | App\Http\Controllers\Admin\ColumnController@show         | web,admin.login |
//|        | GET|HEAD                       | admin/column/{column}/edit | column.edit       | App\Http\Controllers\Admin\ColumnController@edit         | web,admin.login |

    //get
    public function index(){
        $clist = Column::all();
        return view('Admin.column',['clist'=>$clist]);
    }
    //post添加栏目
    public function store(){
            $info = Input::except('_token');//除去csrf_token之外的所有数据
            $validator = Validator::make($info,[
                'column_name'=>'required|min:2',
                'column_alias'=>'required|min:2',
            ],[
                'required'=>':attribute 此字段为必填字段',
                'min'=>':attribute 不能少于2个字符'
            ],[
                'column_name'=>'栏目名称',
                'column_alias'=>'栏目别名',
            ]);
            $info['user_id']=session('user')['id'];
            $info['create_time']=time();
            if($validator->passes()){
                if(Column::create(array_filter($info))){
                    return redirect('admin/column');
                }else{
                    return redirect()->back()->withErrors('数据添加失败-0--稍后继续');
                }
            }else{
                return redirect()->back()->withErrors($validator);
            }
    }
    //delete删除栏目  | DELETE                         | admin/column/{column}
    public function destroy($column_id){
        $is = Column::where('column_id',$column_id)->delete();
        if($is){
            Column::where('pid',$column_id)->update(['pid'=>0]);
            $data=['message'=>'删除成功','code'=>200];
        }else{
            $data=['message'=>'删除失败','code'=>500];
        }
        return $data;
    }
    //admin/column/{column}/edit 修该页面
    public function edit($column_id){
        $c_info = Column::find($column_id);
        $column = Column::where('pid',0)->get();//获取顶级分类
        return view('Admin.update_column',['c_info'=>$c_info,'column'=>$column]);
    }
    //修改栏目的方法| PUT|PATCH                      | admin/column/{column}
    public function update($column_id){
        $uc_info = Input::except(['_token','_method']);
        $uc_info['update_time']=time();
        $uc_info['user_id']=session('user')['id'];
        $bol = Column::where('column_id',$column_id)->update($uc_info);
        if($bol){
            return redirect('admin/column');
        }else{
            return redirect()->back()->withErrors('更新失败');
        }
    }
}
