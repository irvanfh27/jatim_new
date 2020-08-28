<?php


namespace App\Traits;


trait SearchTrait
{
    /**
     * Method to get a Vue Datatable Query
     */
    public function scopeSearchQuery($query, $searchValue = '')
    {
        $columns = $this->searchable;
        if ($searchValue) {
            $query->where(function ($query) use ($searchValue, $columns) {

                $first = true;
                if (count($columns)) {
                    foreach ($columns as $key => $column) {
                        if ($first) {
                            if (!$column['search_relation']) {
                                $query->where($key, 'like', '%' . $searchValue . '%');
                            }
                            $first = false;
                        } elseif ($column['search_relation']) {
                            $query->orWhereHas($column['relation_name'], function ($q) use ($column, $searchValue) {
                                $q->where($column['relation_field'], 'like', '%' . $searchValue . '%');
                            });
                        } else {
                            if (!$column['search_relation']) {
                                $query->orWhere($key, 'like', '%' . $searchValue . '%');
                            }
                        }
                    }
                }
            });
        }
        return $query;
    }
}
