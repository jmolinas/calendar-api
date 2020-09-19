<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;

interface TransformerInterface
{
    /**
     * Transform
     *
     * @param Model $item
     * @param mixed $key
     * @param string $type
     *
     * @return callable
     */
    public function transform(Model $item, $type = null);
}
