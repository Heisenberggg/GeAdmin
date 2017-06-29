<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\Form\ArticleCreateForm;
use App\Services\UploadService;
use App\Models\File;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $page = $request['page']?:1;
        $limit = 10;
        $skip = ($page-1) * $limit;

        $data = DB::table('article')->Join("users",'article.user_id','=','users.id')
                                    ->select('users.name','article.*')
                                    ->orderBy('id','desc')
                                    ->limit($limit)
                                    ->skip($skip)
                                    ->get();
  /*      $queries = DB::getQueryLog();
        dd($queries);die;*/
        $num = Article::count();
        return view("backend.article.index",compact('data','num','page'));
    }

    public function destroy($id)
    {
        try {
            if(Article::destroy($id)){
                return $this->successBackTo('删除文章成功');
            }
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    public function create()
    {
        return view("backend.article.create");
    }

    public function show($id)
    {
        $data = Article::findOrFail($id);
        return view("backend.article.show",compact('data'));
    }

    public function store(ArticleCreateForm $request)
    {
        $file = $request->file('file');

        try {
            $article = new Article();
            $article->title = $request['title'];
            $article->details = $request['details'];
            $article->user_id = \Auth::id();

            if($file){
                $uploadService = new UploadService($file, config('cowcat.uploads'));
                $result = $uploadService->upload();
                $article->files = $result['data']['url'];
                $article->filename = $file->getClientOriginalName();
                if($result['status'] == 0){
                    return $this->responseJson($result);
                }
            }

            if($article->save());
             return $this->successRoutTo('backend.article.index', '新增文章成功');
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    public function uploadImg(Request $request)
    {
        $file = $request->file('file');

        $uploadService = new UploadService($file, config('cowcat.uploads'));

        try {
            $result = $uploadService->upload();

            if($result['status'] == 0){
               return $this->responseJson($result);
            }

            if(File::create($result['data'])){
                $url = $result['data']['url'];
                $arr = array();
                $arr['errno'] = 0;
                $arr['data'] = array($url);

                return $this->responseJson($arr);
            } else {
                throw new Exception("文件记录失败...");
            }
        }
        catch (\Exception $e) {
            return $this->responseJson($e->getMessage());
        }
    }

    public function uploadFile(Request $request)
    {

    }

}
