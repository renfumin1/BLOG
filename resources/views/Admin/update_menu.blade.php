@extends('admin.common.index')
@section('title', '修改菜单')
@section('left')
  @parent
@stop
@section('content')
      <h1 class="page-header">修改菜单</h1>
      <form action="{{url('admin/menu',[$m_info->id])}}" method="post">
        {{--put提交--}}
        <input type="hidden" name="_method" value="put"/>
        <div class="form-group">
          <label for="category-name">菜单名称</label>
          <input type="text" id="category-name" name="name" value="{{$m_info->name}}" class="form-control" placeholder="在此处输入栏目名称" required autocomplete="off">
          <span class="prompt-text">这将是它在站点上显示的名字。</span> </div>
        <div class="form-group">
          <label for="category-alias">链接地址</label>
          <input type="text" id="category-alias" name="name_url" value="{{$m_info->name_url}}" class="form-control" placeholder="在此处输入栏目别名" required autocomplete="off">
          <span class="prompt-text">URL设置须知：前面不带 /  顶级栏目#</span> </div>
        <div class="form-group">
          <labeml for="category-fname">父节点</labeml>
          <select id="category-fname" class="form-control" name="pid">
            <option value="0">无</option>
            @foreach($menu_list as $v)
              <option value="{{$v->id}}"
              @if($v->id==$m_info->pid)
                selected
              @endif
              >{{$v->lev>=1?str_repeat('|——',$v->lev).$v->name:$v->name}}</option>
            @endforeach
          </select>
          <span class="prompt-text">栏目是有层级关系的，您可以有一个“音乐”分类目录，在这个目录下可以有叫做“流行”和“古典”的子目录。</span> </div>
        {{csrf_field()}}
        <button class="btn btn-primary" type="submit" >更新</button>
          @if(count($errors))
            @foreach($errors->all() as $v)
            <span style="color:red">{{$v}}</span>
            @endforeach
          @endif
      </form>
@stop