<div class="row">
    <form action="" method="post" class="add-article-form">
        <div class="col-md-9">
            <h1 class="page-header">撰写新文章</h1>
            @if(count($errors))
                <div>
                    @foreach($errors->all() as $errors)
                        <li style="color:red">{{$errors}}</li>
                    @endforeach
                </div>
            @endif
            <div class="form-group">
                <label for="article-title" class="sr-only">标题</label>
                <input value='{{old('article')['title']?old('article')['title']:$Article->title}}' type="text" id="article-title" name="article[title]" class="form-control" placeholder="在此处输入标题" autofocus autocomplete="off">
            </div>
            <div class="form-group">
                <label for="article-content" class="sr-only">内容</label>
                <script id="article-content" name="article[content]" type="text/plain">{{old('article')['content']?old('article')['content']:$Article->content}}</script>
            </div>
            <div class="add-article-box">
                <h2 class="add-article-box-title"><span>关键字</span></h2>
                <div class="add-article-box-content">
                    <input type="text" value='{{old('article')['keywords']?old('article')['keywords']:$Article->keywords}}' class="form-control" placeholder="请输入关键字" name="article[keywords]" autocomplete="off">
                    <span class="prompt-text">多个标签请用英文逗号,隔开。</span>
                </div>
            </div>
            <div class="add-article-box">
                <h2 class="add-article-box-title"><span>描述</span></h2>
                <div class="add-article-box-content">
                    <textarea  class="form-control" name="article[describe]" autocomplete="off">{{old('article')['describe']?old('article')['describe']:$Article->describe}}</textarea>
                    <span class="prompt-text">描述是可选的手工创建的内容总结，并可以在网页描述中使用</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <h1 class="page-header">操作</h1>
            <div class="add-article-box">
                <h2 class="add-article-box-title"><span>栏目</span></h2>
                <div class="add-article-box-content">
                    <ul class="category-list">
                        @foreach($clist as $key=>$v)
                        <li>
                            <label>
                                <input name="article[clumn]" type="radio" value="{{$v->column_id}}" {{$Article->clumn==$v->column_id || $key==0?'checked':''}}>
                                {{$v->column_name}}
                                <em class="hidden-md">( 栏目ID: <span>{{$v->column_id}}</span> )</em></label>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="add-article-box">
                <h2 class="add-article-box-title"><span>标签</span></h2>
                <div class="add-article-box-content">
                    <input type="text" value='{{old('article')['label']?old('article')['label']:$Article->label}}' class="form-control" placeholder="输入新标签" name="article[label]" autocomplete="off">
                    <span class="prompt-text">多个标签请用英文逗号,隔开</span> </div>
            </div>
            <div class="add-article-box">
                <h2 class="add-article-box-title"><span>标题图片</span></h2>
                <div class="add-article-box-content">
                    <input value='{{old('article')['title_pic']?old('article')['title_pic']:$Article->title_pic}}' type="text" class="form-control" placeholder="点击按钮选择图片" id="pictureUpload" name="article[title_pic]" autocomplete="off">
                </div>
                <div class="add-article-box-footer">
                    <button class="btn btn-default" type="button" ID="upImage">选择</button>
                </div>
            </div>
            <div class="add-article-box">
                <h2 class="add-article-box-title"><span>发布</span></h2>
                <div class="add-article-box-content">
                    <p><label>状态：</label><span class="article-status-display">未发布</span></p>
                    <p><label>是否公开：</label>
                        @foreach($Article->zhuanhuan() as $key=>$v)
                            <input type="radio" name="article[visibility]" value="{{$key}}" {{$Article->visibility==$key?'checked':''}}/>
                            {{$v}}
                        @endforeach
                    </p>

                </div>


                <div class="add-article-box-footer">

                    <button class="btn btn-primary" type="submit" name="submit">发布</button>
                </div>
            </div>
        </div>
        {{csrf_field()}}
    </form>
</div>