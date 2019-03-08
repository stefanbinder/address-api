<?php

namespace App\Jobs\ProcessingSteps;

use Illuminate\Database\Eloquent\Builder;

class Filter
{

    /**
     * Filter constructor.
     * @param Builder $query
     * @param $filterable
     * @param $filters
     * @return Builder
     */
    static public function filter($query, $filterable, $filters)
    {
        $filters = array_only($filters, $filterable);

        foreach ($filters as $attribute => $filter) {
            if (is_array($filter)) {

                foreach ($filter as $sub_filter_key => $sub_filter) {
                    [$comparator, $value] = self::getFilterComparator($sub_filter_key, $sub_filter);

                    if ($comparator === 'in') {
                        $query->whereIn($attribute, $value);
                    } else {
                        $query->where($attribute, $comparator, $value);
                    }

                }

            } else {
                $query->where($attribute, "=", $filter);
            }
        }

        return $query;
    }

    static private function getFilterComparator($textual_comparator, $filter)
    {
        $comparator = '=';

        switch ($textual_comparator) {
            case 'contains':
                $comparator = 'LIKE';
                $filter     = "%$filter%";
                break;
            case 'starts_with':
                $comparator = 'LIKE';
                $filter     = "$filter%";
                break;
            case 'ends_with':
                $comparator = 'LIKE';
                $filter     = "%$filter";
                break;
            case 'gt':
                $comparator = '>';
                break;
            case 'gte':
                $comparator = '>=';
                break;
            case 'lt':
                $comparator = '<';
                break;
            case 'lte':
                $comparator = '<=';
                break;
            case 'in':
                $comparator = 'in';
                $filter     = explode(",", $filter);
                break;
        }

        return [
            $comparator, $filter
        ];

    }

}
