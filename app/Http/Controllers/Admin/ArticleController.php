<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Column;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends CommonController
{
    public function article(){
        $article = Article::paginate(5);
        $count = Article::count();
        return view('admin.article',['article'=>$article,'count'=>$count]);
    }
    //添加文章的页面
    public function add_article(Request $request)
    {
        $moxing = new Article();
        //添加文章的方法判断是否是post
        if($request->isMethod('POST')){
            //控制器验证
//            $this->validate($request,
//                [
//                    'article.title'=>'required|min:2|max:50',//必填字段最小2最大50
//                    'article.content'=>'required',
//                    'article.label'=>'required|integer',
//                ],
//                [
//                    'required'=>':attribute 为必填项',
//                    'min'=>':attribute 长度不符合',
//                    'integer'=>':attribute 为整型',
//                ],
//                [
//                    'article.title'=>'标题',
//                    'article.content'=>'内容',
//                    'article.label'=>'标签',
//                ]
//            );//错误信息在session中
            //validate 类验证
            $validator=\Validator::make($request->input(),
                [
                    'article.title'=>'required|min:2|max:50',//必填字段最小2最大50
                    'article.content'=>'required',
                    'article.clumn'=>'required|integer',
                ],
                [
                    'required'=>':attribute 为必填项',
                    'min'=>':attribute 长度不符合',
                    'integer'=>':attribute 为整型',
                ],
                [
                    'article.title'=>'标题',
                    'article.content'=>'内容',
                    'article.clumn'=>'栏目',
                ]);//return redirect()->back()->withErrors($validator);//放回上一个请求页面
            //如果有错误重定性  ->withInput()//数据保持
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();//放回上一个请求页面
            }
            $info = array_filter($request->input('article'));
            $info['user_id']=session('user')['id'];
            $info['updated_at']=time();
            $info['created_at']=time();
            if(Article::Create($info)){
                return redirect('admin/article')->with('success','添加成功');//session暂存
            }else{
                return redirect()->back();//放回上一个请求页面
            }
        }
        $clist = Column::all(['column_name','column_id']);
        return view('Admin.add_article',['Article'=>$moxing,'clist'=>$clist]);
    }
    //修改
    public function up_article(Request $request,$id)
    {
        $article = Article::find($id);
        if($request->isMethod('POST')){
            $data= $request->input('article');
            $validator=\Validator::make($request->input(),
                [
                    'article.title'=>'required|min:2|max:50',//必填字段最小2最大50
                    'article.content'=>'required',
                    'article.clumn'=>'required|integer',
                ],
                [
                    'required'=>':attribute 为必填项',
                    'min'=>':attribute 长度不符合',
                    'integer'=>':attribute 为整型',
                ],
                [
                    'article.title'=>'标题',
                    'article.content'=>'内容',
                    'article.clumn'=>'栏目',
                ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();//放回上一个请求页面
            }
            $data['updated_at']=time();
            if(Article::where('id',$id)->update($data)){
                return redirect('admin/article')->with('success','修改成功');
            }
        }
        $clist = Column::all(['column_name','column_id']);
        return view('admin.up_article',['Article'=>$article,'clist'=>$clist]);
    }
    //删除
    public function del_article(Request $request)
    {
        $arr = $request->input();
        //彻底删除
        if(array_key_exists('detl',$arr)){
            $flight = Article::find($arr['id']);
            if ($flight->delete()) {
                echo 200;
            }
        }elseif(array_key_exists('checkbox',$arr)){
            if(Article::whereIn('id',$arr['checkbox'])->update(['is_del'=>1])){
                return redirect('admin/article');
            }
        }else{
            if(Article::where('id',$arr['id'])->update(['is_del'=>$arr['type']])){
                echo 200;
            }
        }
    }
}
