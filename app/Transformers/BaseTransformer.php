<?php
namespace App\Transformers;

abstract class BaseTransformer
{
    public function transformerCollection($items)
    {
        return array_map([$this,'transformer'],$items);
    }
    public abstract function transformer($item);
}