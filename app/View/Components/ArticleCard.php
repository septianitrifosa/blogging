<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArticleCard extends Component
{

    public $article;

    public function __construct($article)
    {
        $this->article = $article;
    }

    public function render(): View|Closure|string
    {

        return view('components.article-card');
    }
}
