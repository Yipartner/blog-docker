<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TagService
{

    public function create($data)
    {
        DB::table('tags')->insert($data);
    }

    public function edit($tag_id, $tag_info)
    {
        DB::table('tags')
            ->where('id', $tag_id)
            ->update($tag_info);
    }

    public function delete($tag_id)
    {
        DB::transaction(function () use ($tag_id) {
            DB::table('tags')
                ->where('id', $tag_id)
                ->delete();
            DB::table('article_tag_relations')
                ->where('tag_id', $tag_id)
                ->delete();
        });
    }

    public function getTagByNotSureName($name)
    {
        $tag = DB::table('tags')
            ->where('name', 'like', '%' . $name . '%')
            ->orWhere('name', '=', $name)
            ->get();
        return $tag;
    }

    public function showTagList()
    {
        $tags = DB::table('tags')->get();
        return $tags;
    }

    public function getTagNameToTagId()
    {
        $tags = $this->showTagList();
        $ntags = [];
        foreach ($tags as $tag) {
            $ntags= array_merge($ntags, [$tag->name => $tag->id]);
        }
        return $ntags;
    }

    public function checkTransAndCreate(array $tags)
    {
        if ($tags == []) {
            return [];
        }
        $ntags = $this->getTagNameToTagId();
        $tags_ids = [];
        foreach ($tags as $tag) {
            if (isset($ntags[$tag])) {
                array_push($tags_ids, $ntags[$tag]);
            } else {
                try {
                    array_push($tags_ids, DB::table('tags')->insertGetId([
                        'name' => $tag,
                        'color' => '#337ab7'
                    ]));
                } catch (\PDOException $exception) {

                }
            }
        }
        return $tags_ids;
    }
}