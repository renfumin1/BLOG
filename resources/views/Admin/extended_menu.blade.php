@extends('admin.common.index')
@section('title','栏目页面')
@section('header')
  @parent
@stop
@section('left')
  @parent
@stop
@section('content')
  <div class="row">
        <div class="col-md-5">
          <h1 class="page-header">添加</h1>
          <form action="{{url('admin/menu')}}" method="post" autocomplete="off">
            <div class="form-group">
              <label for="category-name">名称</label>
              <input type="text" id="category-name" name="name" class="form-control" placeholder="在此处输入栏目名称" required autocomplete="off">
              <span class="prompt-text">这将是它在站点上显示的名字。</span> </div>
            <div class="form-group">
              <label for="category-alias">链接地址</label>
              <input type="text" id="category-alias" name="name_url" class="form-control" placeholder="在此处输入栏目别名" required autocomplete="off">
              <span class="prompt-text">URL设置须知：前面不带 /  顶级栏目#</span> </div>
            <div class="form-group">
              <label for="category-fname">父节点</label>
              <select id="category-fname" class="form-control" name="pid">
                <option value="0" selected>无</option>
                @foreach($menu_list as $v)
                <option value="{{$v->id}}">{{$v->lev>=1?str_repeat('|——',$v->lev).$v->name:$v->name}}</option>
                @endforeach
              </select>
              <span class="prompt-text">栏目是有层级关系的，您可以有一个“音乐”分类目录，在这个目录下可以有叫做“流行”和“古典”的子目录。</span> </div>
              {{csrf_field()}}
            <button class="btn btn-primary" type="submit">添加新菜单</button>
          </form>
        </div>
        <div class="col-md-7">
          <h1 class="page-header">管理 <span class="badge">3</span></h1>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th><span class="glyphicon glyphicon-paperclip"></span> <span class="visible-lg">级别</span></th>
                  <th><span class="glyphicon glyphicon-file"></span> <span class="visible-lg">名称</span></th>
                  <th><span class="glyphicon glyphicon-list-alt"></span> <span class="visible-lg">url</span></th>
                  <th><span class="glyphicon glyphicon-pencil"></span> <span class="visible-lg">操作</span></th>
                </tr>
              </thead>
              <tbody>
              @foreach($menu_list as $v)
                <tr>
                  <td>{{$v->lev}}</td>
                  <td>{{str_repeat('|——',$v->lev).$v->name}}</td>
                  <td>{{$v->name_url}}</td>
                  <td><a href="{{url('admin/menu/'.$v->id.'/edit')}}">修改</a> <a rel="{{$v->id}}">删除</a></td>
                </tr>
              @endforeach
              </tbody>
            </table>
            <span class="prompt-text"><strong>注：</strong>删除一个主菜单下面的子菜单进会变为主菜单,请谨慎删除!</span>
          </div>
            @if(count($errors))
                @foreach($errors->all() as $v)
                    <div><span class="prompt-text" style="color:red"><strong>注：</strong>{{$v}}</span></div>
                @endforeach
            @endif
        </div>
      </div>
@stop
@section('javascript')
 <script>
//是否确认删除
$(function(){
	$("#main table tbody tr td a").click(function(){
		var name = $(this);
		var id = name.attr("rel"); //对应id
		if (event.srcElement.outerText === "删除")
		{
			if(window.confirm("此操作不可逆，是否确认？"))
			{
				$.ajax({
					type: "POST",
					url: "{{url('admin/menu')}}"+'/'+id,
					data: {'_method':'delete','_token':"{{csrf_token()}}"},
					cache: false, //不缓存此页面
                    dataType:'json',
					success: function (data) {
					    if(data.code==200){
						    window.location.reload();
                        }else{
					        alert(data.message);
                        }
					}
				});
			};
		};
	});
});
</script>
@stop
