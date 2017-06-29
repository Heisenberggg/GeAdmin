@extends("backend.layout.main")

@section("content")
    <link rel="stylesheet" type="text/css" href="/assets/backend/plugins/webuploader-0.1.5/dist/webuploader.css">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{route('backend.article.store')}}" enctype="multipart/form-data">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">新增文章</h3>
                    </div>
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class="form-group">
                            <label for="title">文章标题</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="文章标题" value="{{old('title')}}">
                        </div>
                        <div class="form-group">
                            <label for="details">文章内容</label>
                            <div id="editor">
                            </div>
                         <input type="hidden" id="details" name="details">
                        </div>

                        <div class="form-group">
                            <label for="details">添加附件</label>
                            <input type="file" name="file">
                        </div>

                    </div>
                    <div class="box-footer clearfix">
                        <a href="javascript:history.back(-1);" class="btn btn-default btn-flat">
                            <i class="fa fa-arrow-left"></i>
                            返回
                        </a>
                        <button type="submit" class="btn btn-success pull-right btn-flat" id="btn1">
                            <i class="fa fa-plus"></i>
                            新 增
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <script type="text/javascript" src="/assets/backend/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/assets/backend/js/wangEditor.min.js"></script>
    <script type="text/javascript">

            var E = window.wangEditor
            var editor = new E('#editor')
            var csrf = "{{csrf_token()}}";
            // 或者 var editor = new E( document.getElementById('#editor') )
            editor.customConfig.uploadImgServer = '/backend/article/uploadImg'
            editor.customConfig.uploadImgParams = {
                _token: csrf
            }
            editor.create()

            document.getElementById('btn1').addEventListener('click', function () {
                var details = editor.txt.html();
                document.getElementById('details').value = details;
            }, false)

            var servername = "{{$_SERVER['SERVER_NAME']}}";

    </script>
@endsection