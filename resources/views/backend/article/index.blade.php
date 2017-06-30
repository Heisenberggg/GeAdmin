@extends("backend.layout.main")

@inject("articlePresenter","App\Presenters\ArticlePresenter")
<link type="text/css" rel="stylesheet" href="/assets/backend/css/bootstrap.min.css"/>
@section("content")

    @include('backend.components.handle',$handle = $articlePresenter->getHandle())
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">文章列表</h3>

                    {{--<div class="box-tools">{!! $data->render() !!}</div>--}}
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>文章编号</th>
                            <th>文章作者</th>
                            <th>文章标题</th>
                            <th>发表时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td><a href="{{route('backend.article.show',['id'=>$item->id])}}">{{$item->title}}</a></td>
                                <td>{{$item->created_at}}</td>
                                <td>
                                    @if(Auth::user()->id == $item->user_id)
                                        <a href="{{route('backend.user.edit',['id'=>$item->id])}}" class="btn btn-primary btn-flat">编辑</a>
                                        <button class="btn btn-danger btn-flat"
                                                data-url="{{URL::to('backend/article/'.$item->id)}}"
                                                data-toggle="modal"
                                                data-target="#delete-modal"
                                        >
                                            删除
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>
            <ul class="pagination" id="paginator"></ul>
        </div>
    </div>

    <script type="text/javascript" src="/assets/backend/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/assets/backend/js/jqPaginator.min.js"></script>
    <script>
        //分页
        var pageSize = 10;
        var totalCounts = {{$num}};
        var currentPage = {{$page}};
        $('#paginator').jqPaginator({
            totalCounts:totalCounts,
            pageSize:pageSize,
            currentPage:1,
            first: '<li class="prev"><a href="javascript:;">首页</a></li>',
            prev: '<li class="prev"><a href="javascript:;">上一页</a></li>',
            next: '<li class="next"><a href="javascript:;">下一页</a></li>',
            last: '<li class="prev"><a href="javascript:;">末页</a></li>',
            page: '<li class="page"><a href="javascript:;">@{{page}}</a></li>',
            onPageChange: function (num, type) {
                if(type != 'init'){
                    window.location.href = "http://www.october.com/backend/article?page="+num;

                }
            }

        });

        $('#paginator').jqPaginator('option', {
            currentPage:currentPage,
        });
    </script>

@endsection
@section("after.js")
    @include('backend.components.modal.delete',['title'=>'操作提示','content'=>'你确定要删除这篇文章吗?'])
@endsection
