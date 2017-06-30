@extends("backend.layout.main")

@section("content")

    <div class="row">
        <div class="col-md-12">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">文章详情</h3>
                    </div>

                    <div class="box-body">

                        <div class="form-group">
                            <label for="title">文章标题:</label>
                               <h4 class="box-title">{{$data->title}}</h4>
                            <label for="title">文章详情:</label>
                            <div >
                               {!!$data->details!!}
                            </div>
                            @if($data->files!=null || $data->files!='')
                            <label for="files">附件文件 : {{$data->filename}}</label>
                            <a href="{{$data->files}}"><div >
                                   下载附件
                            </div></a>
                            @endif
                        </div>

                    </div>
                </div>

        </div>
    </div>

@endsection