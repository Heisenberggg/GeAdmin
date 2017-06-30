<?php

namespace App\Presenters;

class ArticlePresenter extends CommonPresenter
{
    public function getHandle()
    {
        return [
            [
                'icon'  => 'plus',
                'class' => 'success',
                'title' => '新增文章',
                'route' => 'backend.article.create',
            ],
        ];
    }
}