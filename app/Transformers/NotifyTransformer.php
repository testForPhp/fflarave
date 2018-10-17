<?php
namespace App\Transformers;

class NotifyTransformer extends BaseTransformer
{
    public function transformer($item)
    {
        return [
            'title' => $item->title,
            'content' => $item->content
        ];
    }
}