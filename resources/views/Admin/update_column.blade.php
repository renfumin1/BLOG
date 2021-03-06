@extends('admin.common.index')
@section('title', '文章页')
@section('left')
  @parent
@stop
@section('content')
      <h1 class="page-header">修改栏目</h1>
      <form action="{{url('admin/column',[$c_info->column_id])}}" method="post">
        {{--put提交--}}
        <input type="hidden" name="_method" value="put"/>
        <div class="form-group">
          <label for="category-name">栏目名称</label>
          <input type="text" id="category-name" name="column_name" value="{{$c_info->column_name}}" class="form-control" placeholder="在此处输入栏目名称" required autocomplete="off">
          <span class="prompt-text">这将是它在站点上显示的名字。</span> </div>
        <div class="form-group">
          <label for="category-alias">栏目别名</label>
          <input type="text" id="category-alias" name="column_alias" value="{{$c_info->column_alias}}" class="form-control" placeholder="在此处输入栏目别名" required autocomplete="off">
          <span class="prompt-text">“别名”是在URL中使用的别称，它可以令URL更美观。通常使用小写，只能包含字母，数字和连字符（-）。</span> </div>
        <div class="form-group">
          <label for="category-fname">父节点</label>
          <select id="category-fname" class="form-control" name="pid">
            <option value="0">无</option>
            @foreach($column as $v)
              <option value="{{$v->column_id}}"
              @if($v->column_id==$c_info->pid)
                selected
              @endif
              >{{$v->column_name}}</option>
            @endforeach
          </select>
          <span class="prompt-text">栏目是有层级关系的，您可以有一个“音乐”分类目录，在这个目录下可以有叫做“流行”和“古典”的子目录。</span> </div>
        <div class="form-group">
          <label for="category-keywords">关键字</label>
          <input type="text" id="category-keywords" name="column_keywords" value="{{$c_info->column_keywords}}" class="form-control" placeholder="在此处输入栏目关键字" autocomplete="off">
          <span class="prompt-text">关键字会出现在网页的keywords属性中。</span> </div>
        <div class="form-group">
          <label for="category-describe">描述</label>
          <textarea class="form-control" id="category-describe" name="column_describe" rows="4" autocomplete="off">{{$c_info->column_describe}}</textarea>
          <span class="prompt-text">描述会出现在网页的description属性中。</span> </div>
        {{csrf_field()}}
        <button class="btn btn-primary" type="submit" >更新</button>
          @if(count($errors))
            @foreach($errors->all() as $v)
            <span style="color:red">{{$v}}</span>
            @endforeach
          @endif
      </form>
@stop