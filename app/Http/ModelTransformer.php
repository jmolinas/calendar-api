<?php

namespace App\Http;

use Illuminate\Support\Collection;
use App\Transformers\TransformerInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * ModelTransformer
 */
trait ModelTransformer
{
    /**
     * Transform Model
     *
     * @param Model $model,
     * @param TransformerInterface $transformer
     *
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function transform($model, TransformerInterface $transformer, $type = null, $url = null)
    {
        if ($url) {
            $data = ['links' => ['self' => $url]];
        }

        if ($model instanceof Collection) {
            $collection = $this->transformCollection($model, $transformer, $type);
            return $collection;
        }

        if ($model instanceof LengthAwarePaginator) {
            $collection = $this->transformCollection($model->getCollection(), $transformer, $type);
            $model->setCollection($collection);
            return $model;
        }
        $data['data'] = $transformer->transform($model, $type)->getData();
        return $data;
    }

    /**
     * Transform Collection
     *
     * @param Collection $model,
     * @param TransformerInterface $transformer
     *
     * @return Collection
     */
    public function transformCollection(Collection $collection, TransformerInterface $transformer, $type = null)
    {
        $collection
            ->transform(
                function ($item) use ($transformer, $type) {
                    return $transformer->transform($item, $type)->getData();
                }
            );
        return $collection;
    }
}
