<?php

namespace App\Models\Traits;

use App\Http\Exceptions\InvalidUrlParameterException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait Searchable
{
    /**
     * Search Builder
     *
     * @param array $search
     * @param Builder $builder
     * @param array $searchable
     *
     * @return Builder
     */
    public function search(array $search, Builder $builder)
    {
        $counter = 0;
        $model = $builder->getModel();
        $table = $model->getTable();
        $searchable = Schema::getColumnListing($model->getTable());
        foreach ($search as $key => $value) {
            if (!in_array($key, $searchable)) {
                throw new InvalidUrlParameterException('Invalid Parameter: not searchable field');
            }
            $counter++;
            $sql = "{$table}.{$key} ILIKE ?";
            if ($counter === 1) {
                $builder = $builder->whereRaw($sql, ["%{$value}%"]);
                continue;
            }
            $builder = $builder->orWhereRaw($sql, ["%{$value}%"]);
        }
        return $builder;
    }
}
