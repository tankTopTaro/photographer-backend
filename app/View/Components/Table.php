<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public $table;
    public $columns;
    public $tableName;

    /**
     * Create a new component instance.
     */
    public function __construct($table, $tableName = null)
    {
        $this->table = $table;
        $this->tableName = $tableName;

        // Dynamically get the columns from the first item in the collection
        $firstItem = $table->first();
        $this->columns = $firstItem ? array_keys($firstItem->getAttributes()) : [];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
