@extends('Admin.common.index')
@section('title','用户列表')
@section('header')
  @parent
@stop
@section('left')
  @parent
@stop
@section('content')
        <h1 class="page-header">操作</h1>
        <ol class="breadcrumb">
          <li>
              <a data-toggle="modal" data-target="#addUser">增加用户</a>
          </li>
          @if(count($errors))
                <li>
                    <a style="color:orange">操作失败</a>
                </li>
              @foreach($errors->all() as $v)
                <li>
                    <a style="color:red">{{$v}}</a>
                </li>
              @endforeach
          @endif
        </ol>
        <h1 class="page-header">管理 <span class="badge">2</span></h1>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th><span class="glyphicon glyphicon-th-large"></span> <span class="visible-lg">ID</span></th>
                <th><span class="glyphicon glyphicon-user"></span> <span class="visible-lg">用户名</span></th>
                <th><span class="glyphicon glyphicon-bookmark"></span> <span class="visible-lg">姓名</span></th>
                <th><span class="glyphicon glyphicon-pushpin"></span> <span class="visible-lg">文章</span></th>
                <th><span class="glyphicon glyphicon-time"></span> <span class="visible-lg">上次登录时间</span></th>
                <th><span class="glyphicon glyphicon-pencil"></span> <span class="visible-lg">操作</span></th>
              </tr>
            </thead>
            <tbody>
              @foreach($user_list as $v)
              <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->user_name}}</td>
                <td>{{$v->real_name}}</td>
                <td>4</td>
                <td>{{date('Y-m-d H:i:s',$v->last_login_time)}}</td>
                <td>
                    <a rel="{{$v->id}}" name="see"  data-toggle="modal" data-target="#seeUser">修改</a>
                    <a rel="{{$v->id}}" name="delete">删除</a> <a href="{{url('admin/user/'.$v->id.'-'.$v->type.'/edit')}}">{{$v->type?'启用':'禁用'}}</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
@stop
@section('layer')
    @parent
  <!--增加用户模态框-->
  <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel">
    <div class="modal-dialog" role="document" style="max-width:450px;">
      <form action="{{url('admin/user')}}" method="post" autocomplete="off" draggable="false">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" >增加用户</h4>
          </div>
          <div class="modal-body">
            <table class="table" style="margin-bottom:0px;">
              <thead>
              <tr> </tr>
              </thead>
              <tbody>
              <tr>
                <td wdith="20%">姓名:</td>
                <td width="80%"><input type="text" value="" class="form-control" name="real_name" maxlength="10" autocomplete="off" /></td>
              </tr>
              <tr>
                <td wdith="20%">用户名:</td>
                <td width="80%"><input type="text" value="" class="form-control" name="user_name" maxlength="10" autocomplete="off" /></td>
              </tr>
              <tr>
                <td wdith="20%">电话:</td>
                <td width="80%"><input type="text" value="" class="form-control" name="usertel" maxlength="13" autocomplete="off" /></td>
              </tr>
              <tr>
                <td wdith="20%">新密码:</td>
                <td width="80%"><input type="password" class="form-control" name="password" maxlength="18" autocomplete="off" /></td>
              </tr>
              <tr>
                <td wdith="20%">确认密码:</td>
                <td width="80%"><input type="password" class="form-control" name="password_confirmation" maxlength="18" autocomplete="off" /></td>
              </tr>
              </tbody>
              <tfoot>
              <tr></tr>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">提交</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--用户信息模态框-->
  <div class="modal fade" id="seeUser" tabindex="-1" role="dialog" aria-labelledby="seeUserModalLabel">
    <div class="modal-dialog" role="document" style="max-width:450px;">
      <form id="user_update" action="" method="post" autocomplete="off" draggable="false">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">修改用户</h4>
          </div>
          <div class="modal-body">
            <table class="table" style="margin-bottom:0px;">
              <thead>
              <tr></tr>
              </thead>
              <tbody>
              <tr>
                <td wdith="20%">姓名:</td>
                <td width="80%"><input type="text" value="" class="form-control" id="truename" name="real_name" maxlength="10" autocomplete="off" /></td>
              </tr>
              <tr>
                <td wdith="20%">用户名:</td>
                <td width="80%"><input type="text" value="" class="form-control" id="username" name="user_name" maxlength="10" autocomplete="off" /></td>
              </tr>
              <tr>
                <td wdith="20%">电话:</td>
                <td width="80%"><input type="text" value="" class="form-control" id="usertel" name="usertel" maxlength="13" autocomplete="off" /></td>
              </tr>
              <tr>
                <td wdith="20%">旧密码:</td>
                <td width="80%"><input type="password" class="form-control" name="old_password" maxlength="18" autocomplete="off" /></td>
              </tr>
              <tr>
                <td wdith="20%">新密码:</td>
                <td width="80%"><input type="password" class="form-control" name="password" maxlength="18" autocomplete="off" /></td>
              </tr>
              <tr>
                <td wdith="20%">确认密码:</td>
                <td width="80%"><input type="password" class="form-control" name="password_confirmation" maxlength="18" autocomplete="off" /></td>
              </tr>
              </tbody>
              <tfoot>
              <tr></tr>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">提交</button>
          </div>
        </div>
          <input type="hidden" value="PUT" name="_method">
          {{csrf_field()}}
      </form>
    </div>
  </div>
@stop
@section('javascript')
<script>
$(function () {
    $("#main table tbody tr td a").click(function () {
        var name = $(this);
        var id = name.attr("rel"); //对应id
        if (name.attr("name") === "see") {
            $.ajax({
                type: "GET",
                url: "{{url('admin/user')}}"+'/'+id,
                cache: false, //不缓存此页面
                dataType:'json',
                success: function (data) {
					$('#truename').val(data.real_name);
					$('#username').val(data.user_name);
					$('#usertel').val(data.usertel);
					$('#user_update').attr('action',data.url);
                    $('#seeUser').modal('show');
                }
            });
        } else if (name.attr("name") === "delete") {
            if (window.confirm("此操作不可逆，是否确认？")) {
                $.ajax({
                    type: "POST",
                    url: "{{url('admin/user')}}"+'/'+id,
                    data: {'_method':'delete','_token':'{{csrf_token()}}'},
                    cache: false, //不缓存此页面
                    success: function (data) {
                        if(data.code==200){
                          window.location.reload();
                        }else{
                            alert('删除失败了');
                        }
                    }
                });
            };
        };
    });
});
</script>
@stop
