<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Services\TagService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use League\CommonMark\CommonMarkConverter;

class ArticleController extends Controller
{
    //

    private $articleService;
    private $tagService;

    public function __construct(ArticleService $articleService, TagService $tagService)
    {
        $this->articleService = $articleService;
        $this->tagService = $tagService;
    }

    public function createNewArticle(Request $request)
    {
        $user = $request->user();
        $article = [];
        $rule = [
            'title',
            'content',
            'type_id',
            'status'
        ];
        foreach ($rule as $item) {
            $article[$item] = $request->input($item, "未填写");
        }
        $article['user_id'] = $user->id;
        $article['created_at'] = Carbon::now();
        $article['updated_at'] = Carbon::now();
        $article_id = $this->articleService->create($article);
        $tags = $request->input('tags', []);
        $tag_ids = $this->tagService->checkTransAndCreate($tags);
        $a_t = [];
        foreach ($tag_ids as $tag_id) {
            array_push($a_t, [
                'tag_id' => $tag_id,
                'article_id' => $article_id
            ]);
        }
        DB::table('article_tag_relations')->insert($a_t);
        return url('/article/content/'.$article_id);
    }

    public function editArticle(Request $request)
    {
        $user = $request->user();
        $article = [];
        $rule = [
            'id',
            'title',
            'content',
            'type_id',
            'status',
        ];
        foreach ($rule as $item) {
            $article[$item] = $request->input($item, "未填写");
        }
        $article['user_id'] = $user->id;
        $article_id = $article['id'];
        $tags = $request->input('tags', []);
        $tag_ids = $this->tagService->checkTransAndCreate($tags);
        $a_t = [];
        foreach ($tag_ids as $tag_id) {
            array_push($a_t, [
                'tag_id' => $tag_id,
                'article_id' => $article_id
            ]);
        }
        DB::table('article_tag_relations')->where('article_id',$article_id)->delete();
        DB::table('article_tag_relations')->insert($a_t);

        $this->articleService->edit($article['id'], $article);
        return url('/article/content/'.$article_id);
    }

    public function showArticlesByType($typeId, Request $request)
    {
        $articles = $this->articleService->searchByType($typeId, $request->user()->id ?? -1);
        return view('home', [
            'articles' => $articles
        ]);
    }

    public function showArticlesByTag($tagId, Request $request)
    {
        $articles = $this->articleService->searchByTag($tagId, $request->user()->id ?? -1);
        return view('home', [
            'articles' => $articles
        ]);
    }

    public function showArticleById($articleId, Request $request)
    {
        $article = $this->articleService->showById($articleId, $request->user()->id ?? -1);
        $paser = new CommonMarkConverter(['html_input'=>'escape']);
        $article->content = $paser->convertToHtml($article->content);
        return view('article', [
            'article' => $article
        ]);
    }

    public function editView($articleId, Request $request)
    {
        $article = $this->articleService->showById($articleId, $request->user()->id ?? -1);

        return view('article.create', [
            'article' => $article,
            'do' => 'edit'
        ]);
    }

    public function getTag()
    {
        return response()->json([

        ]);
    }

    public function deleteArticle($articleId){
        $this->articleService->delete($articleId);
        return back();
    }

}
