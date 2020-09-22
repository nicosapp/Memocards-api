<?php

namespace App\Scoping\Scopes;

use Illuminate\Database\Eloquent\Builder;

class TagScope
{
    public function apply(Builder $builder, $value)
    {
        if(is_array($values = explode(',',$value))){
            foreach($values as $v){
                $builder->whereHas('tags', function($builder) use ($v){
                    $builder->where('tags.id', $v);
                });
            }
        }
        return $builder;
    }
}