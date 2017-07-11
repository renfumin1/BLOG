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
          <form action="{{url('admin/column')}}" method="post" autocomplete="off">
            <div class="form-group">
              <label for="category-name">栏目名称</label>
              <input type="text" id="category-name" name="column_name" class="form-control" placeholder="在此处输入栏目名称" required autocomplete="off">
              <span class="prompt-text">这将是它在站点上显示的名字。</span> </div>
            <div class="form-group">
              <label for="category-alias">栏目别名</label>
              <input type="text" id="category-alias" name="column_alias" class="form-control" placeholder="在此处输入栏目别名" required autocomplete="off">
              <span class="prompt-text">“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）。</span> </div>
            <div class="form-group">
              <label for="category-fname">父节点</label>
              <select id="category-fname" class="form-control" name="pid">
                <option value="0" selected>无</option>
                @foreach($clist as $v)
                <option value="{{$v->column_id}}">{{$v->column_name}}</option>
                @endforeach
              </select>
              <span class="prompt-text">栏目是有层级关系的，您可以有一个“音乐”分类目录，在这个目录下可以有叫做“流行”和“古典”的子目录。</span> </div>
            <div class="form-group">
              <label for="category-keywords">关键字</label>
              <input type="text" id="category-keywords" name="column_keywords" class="form-control" placeholder="在此处输入栏目关键字" autocomplete="off">
              <span class="prompt-text">关键字会出现在网页的keywords属性中。</span> </div>
            <div class="form-group">
              <label for="category-describe">描述</label>
              <textarea class="form-control" id="category-describe" name="column_describe" rows="4" autocomplete="off"></textarea>
              <span class="prompt-text">描述会出现在网页的description属性中。</span> </div>
              {{csrf_field()}}
            <button class="btn btn-primary" type="submit">添加新栏目</button>
          </form>
        </div>
        <div class="col-md-7">
          <h1 class="page-header">管理 <span class="badge">3</span></h1>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th><span class="glyphicon glyphicon-paperclip"></span> <span class="visible-lg">ID</span></th>
                  <th><span class="glyphicon glyphicon-file"></span> <span class="visible-lg">名称</span></th>
                  <th><span class="glyphicon glyphicon-list-alt"></span> <span class="visible-lg">别名</span></th>
                  <th><span class="glyphicon glyphicon-pushpin"></span> <span class="visible-lg">总数</span></th>
                  <th><span class="glyphicon glyphicon-pencil"></span> <span class="visible-lg">操作</span></th>
                </tr>
              </thead>
              <tbody>
              @foreach($clist as $v)
                <tr>
                  <td>{{$v->column_id}}</td>
                  <td>{{$v->column_name}}</td>
                  <td>{{$v->column_alias}}</td>
                  <td>125</td>
                  <td><a href="{{url('admin/column/'.$v->column_id.'/edit')}}">修改</a> <a rel="{{$v->column_id}}">删除</a></td>
                </tr>
              @endforeach
              </tbody>
            </table>
            <span class="prompt-text" style="color:red"><strong>注：</strong>删除一个栏目也会删除栏目下的文章和子栏目,请谨慎删除!</span>
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
					url: "{{url('admin/column')}}"+'/'+id,
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
