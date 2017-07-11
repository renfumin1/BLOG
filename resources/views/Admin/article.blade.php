@extends('admin.common.index')
@section('title', '文章页')
@section('left')
    @parent
@stop
@section('content')
    <form action="{{route('admin/del_article')}}" method="post" >
        <h1 class="page-header">操作</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin/add_article')}}">增加文章</a></li>
        </ol>
        <h1 class="page-header">管理 <span class="badge"
            @if(Session::has('success'))
            style="background-color:#3399CC"
            @elseif(Session::has('error'))
            style="background-color:red"
            @endif>{{$count}}</span>
        </h1>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th><span class="glyphicon glyphicon-th-large"></span> <span class="visible-lg">选择</span></th>
                    <th><span class="glyphicon glyphicon-file"></span> <span class="visible-lg">标题</span></th>
                    <th><span class="glyphicon glyphicon-list"></span> <span class="visible-lg">栏目</span></th>
                    <th class="hidden-sm"><span class="glyphicon glyphicon-tag"></span> <span class="visible-lg">标签</span></th>
                    <th class="hidden-sm"><span class="glyphicon glyphicon-comment"></span> <span class="visible-lg">评论</span></th>
                    <th class="hidden-sm"><span class="glyphicon glyphicon-pencil"></span> <span class="visible-lg">是否公开</span></th>
                    <th><span class="glyphicon glyphicon-time"></span> <span class="visible-lg">是否删除</span></th>
                    <th><span class="glyphicon glyphicon-time"></span> <span class="visible-lg">日期</span></th>
                    <th><span class="glyphicon glyphicon-pencil"></span> <span class="visible-lg">操作</span></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($article as $v)
                <tr>
                    <td><input type="checkbox" class="input-control" name="checkbox[]" value="{{$v->id}}" /></td>
                    <td class="article-title">{{$v->title}}</td>
                    <td>{{$v->clumn}}</td>
                    <td class="hidden-sm">{{$v->label}}</td>
                    <td class="hidden-sm">{{$v->comment}}</td>
                    <td class="hidden-sm detl" val="{{$v->visibility}}">{{$v->zhuanhuan($v->visibility)}}</td>
                    <td>{{$v->is_del?'已删除':'未删除'}}</td>
                    <td>{{date('Y-m-d H:i:s',$v->created_at)}}</td>
                    <td><a href="{{route('admin/up_article',['id'=>$v->id])}}">修改</a> <a type="{{$v->is_del=='0'?1:0}}" rel="{{$v->id}}">{{$v->is_del?'恢复':'删除'}}</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <footer class="message_footer">
            <nav>
                <div class="btn-toolbar operation" role="toolbar">
                    <div class="btn-group" role="group"> <a class="btn btn-default" onClick="select()">全选</a> <a class="btn btn-default" onClick="reverse()">反选</a> <a class="btn btn-default" onClick="noselect()">不选</a> </div>
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="删除全部选中" name="checkbox_delete">删除</button>
                    </div>
                </div>
                <ul class="pagination pagenav">
                    {{$article->render()}}
                </ul>
            </nav>
        </footer>
        {{csrf_field()}}
    </form>
@stop
@section('javascript')
    <script>
        //是否确认删除
        $(function(){
            $("#main table tbody tr td a").click(function(){
                var name = $(this);
                var id = name.attr("rel"); //对应id
                var type = name.attr("type"); //类型
                var _token=$('input[name="_token"]').val();
                var detl = $('.detl').attr('val');
                if(detl==1 && type==1){
                    if(window.confirm("此操作不可逆，是否确认？"))
                    {
                        $.ajax({
                            type: "POST",
                            url: "{{route('admin/del_article')}}",
                            data: {"id":id,"detl":detl,"type":type,'_token':_token},
                            cache: false, //不缓存此页面
                            success: function (data) {
                                if(data=='200'){
                                    window.location.reload();
                                }
                            }
                        });
                    };
                }else{
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin/del_article')}}",
                        data: {"id":id,"type":type,'_token':_token},
                        cache: false, //不缓存此页面
                        success: function (data) {
                            if(data=='200'){
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        });
    </script>
 @stop
