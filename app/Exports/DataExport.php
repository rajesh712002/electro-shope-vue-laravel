<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection,WithHeadings
{
    protected $model;
    protected $columns;
    protected $conditions;

    public function __construct($model, $columns, $conditions)
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->conditions = $conditions;
    }

    public function collection()
    {
        $query =  $this->model::select($this->columns);
        if (!empty($this->conditions)) {
            foreach ($this->conditions as $column => $value) {
                if (!is_null($value)) {
                    $query->where($column, $value);
                }
            }
        }

        return $query->get();
    }

    public function headings(): array
    {
        return $this->columns;
    }
}
