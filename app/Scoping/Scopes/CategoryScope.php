<?php

namespace App\Scoping\Scopes;

use Illuminate\Database\Eloquent\Builder;

class CategoryScope
{
    public function apply(Builder $builder, $value)
    {
        // return $builder->where('slug', $value);
        if(is_array($values = explode(',',$value))){
            foreach($values as $v){
                $builder->whereHas('categories', function($builder) use ($v){
                    $builder->where('categories.id', $v);
                });
            }
        }
        return $builder;
        // return $builder->whereHas('categories', function($builder) use ($value){
        //     
        // });
    }
}