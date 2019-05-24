<?php

namespace App\Tools\Filter;

use App\Contracts\Filter\IFilter;
use Illuminate\Database\Eloquent\Builder;

class LHSBracketsFilter implements IFilter
{

    /**
     * Filter constructor.
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function filter($query, $filters)
    {

        foreach ($filters as $attribute => $filter) {
            if (is_array($filter)) {

                foreach ($filter as $sub_filter_key => $sub_filter) {
                    [$comparator, $value] = $this->getFilterComparator($sub_filter_key, $sub_filter);

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

    private function getFilterComparator($textual_comparator, $filter)
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
