<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TypeService{

    public function create($data){
        DB::table('types')->insert($data);
    }
    
    public function isTypeNameExist(string $type_name){
        $res = DB::table('types')->where('name',$type_name)->first();
        return isTrue($res);
    }

    public function edit($type_id,$type_info){
        DB::table('types')
            ->where('id',$type_id)
            ->update($type_info);
    }

    public function delete($type_id){
        DB::transaction(function ()use ($type_id){
            DB::table('types')
                ->where('id',$type_id)
                ->delete();
            // 將该分类下的文章归类到未分类中
            DB::table('articles')
                ->where('type_id',$type_id)
                ->update([
                    'type_id'=>0
                ]);
        });

    }

    public function showTypes(){
        return DB::table('types')->orderBy('id')->get();
    }
}