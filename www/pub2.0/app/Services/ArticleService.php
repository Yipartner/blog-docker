<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ArticleService
{
    // 创建文章
    public function create($data)
    {

        return DB::table('articles')
            ->insertGetId($data);
    }

    // 改变文章的发布状态
    public function changeStatus($article_id, $status)
    {
        DB::table('articles')
            ->where('id', $article_id)
            ->update([
                'status' => $status
            ]);
    }

    public function showById($article_id,$user_id){
        $article =DB::table('articles')
            ->where([
                ['id','=',$article_id],
                ['status','=',1]
            ])
            ->orWhere([
                ['id','=',$article_id],
                ['user_id','=',$user_id]
            ])
            ->orWhere(function($query) use ($user_id,$article_id){
                $query->where('status','=',2)
                    ->where('id','=',$article_id)
                    ->whereExists(function ($que) use ($user_id){
                        $que->select(DB::raw(1))
                            ->from('article_user_sees')
                            ->whereRaw('article_user_sees.user_id = '.$user_id.' and article_user_sees.article_id = articles.id');
                    });
            })
            ->first();
        $tag_articles=DB::table('article_tag_relations')
            ->where('article_id',$article_id)
            ->join('tags','tags.id','=','article_tag_relations.tag_id')
            ->get();
        $article->tags=[];
        foreach ($tag_articles as $tag_article){
            array_push($article->tags,[
                'tag_id'=>$tag_article->tag_id,
                'name'=>$tag_article->name,
                'color'=>$tag_article->color
            ]);
        }
        return $article;
    }
    /**
     * 删除文章
     * @param $article_id
     * @return bool delete result
     */
    public function delete($article_id)
    {
        $num = DB::table('articles')
            ->where('id', $article_id)
            ->delete();
        return $num == 1;
    }

    // 编辑文章
    public function edit($article_id, $data)
    {
        $data['updated_at']=Carbon::now();
        DB::table('articles')
            ->where('id', $article_id)
            ->update($data);
    }

    public function searchByTitle(string $title){
        $articles = DB::table('articles')
            ->where('title','like','%'.$title.'%')
            ->paginate(config('article.page_size'));
        return $this->addTagInfo($articles);
    }

    public function searchByType($type_id,$user_id=-1){
        $articles =DB::table('articles')
            ->where([
                ['type_id','=',$type_id],
                ['status','=',1]
            ])
            ->orWhere([
                ['type_id','=',$type_id],
                ['user_id','=',$user_id]
            ])
            ->orWhere(function($query) use ($user_id,$type_id){
                $query->where('status','=',2)
                    ->where('type_id','=',$type_id)
                ->whereExists(function ($que) use ($user_id){
                   $que->select(DB::raw(1))
                   ->from('article_user_sees')
                   ->whereRaw('article_user_sees.user_id = '.$user_id.' and article_user_sees.article_id = articles.id');
                });
            })
            ->orderBy('articles.created_at','desc')
            ->paginate(config('article.page_size'));
        return $this->addTagInfo($articles);
    }
    public function addTagInfo($articles){
        $ids=[];
        foreach ($articles as $article){
            array_push($ids,$article->id);
        }
        $tag_articles=DB::table('article_tag_relations')
            ->whereIn('article_id',$ids)
            ->join('tags','tags.id','=','article_tag_relations.tag_id')
            ->get();
        foreach ($articles as $article){
            if (mb_strlen($article->content)>100){
                $article->content = mb_substr($article->content,0,120)."....";
            }
            $article->tags=[];
            foreach ($tag_articles as $tag_article ){
                if ($tag_article->article_id == $article->id){
                    array_push($article->tags,[
                        'tag_id'=>$tag_article->tag_id,
                        'name'=>$tag_article->name,
                        'color'=>$tag_article->color
                    ]);
                }
            }
        }
        return $articles;
    }
    public function searchByTag($tag_id,$user_id = -1){
        $articles = DB::table('article_tag_relations')
            ->where([
                ['tag_id','=',$tag_id],
                ['articles.status','=',1]
            ])
            ->orWhere([
                ['tag_id','=',$tag_id],
                ['articles.user_id','=',$user_id]
            ])
            ->orWhere(function($query) use ($tag_id,$user_id){
                $query->where('articles.status','=',2)
                    ->whereExists(function ($que) use ($user_id){
                        $que->select(DB::raw(1))
                            ->from('article_user_sees')
                            ->whereRaw('article_user_sees.user_id = '.$user_id.' and article_user_sees.article_id = articles.id');
                    });
            })
            ->join('articles','article_id','=','articles.id')
            ->select('articles.*')
            ->orderBy('articles.created_at','desc')
            ->paginate(config('article.page_size'));
        return $this->addTagInfo($articles);
    }


    // TODO 根据文章内容搜索
    // TODO 分享
    // TODO 下载

}