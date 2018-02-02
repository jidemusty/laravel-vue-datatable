<?php

namespace App\Http\Controllers\DataTable;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

abstract class DataTableController extends Controller
{
    protected $builder;

    public function __construct()
    {
        $builder = $this->builder();

        if (!$builder instanceof Builder) {
            throw new Exception('Entity builder not instance of Builder');
        }

        $this->builder = $builder;
    }

    abstract public function builder();

    public function index()
    {
        return response()->json([
            'data' => [
                'displayable' => array_values($this->getDisplayableColumns()),
                'records' => $this->getRecords(),
            ]
        ]);
    }

    protected function getRecords()
    {
        return $this->builder->get($this->getDisplayableColumns());
    }

    public function getDisplayableColumns()
    {
        return array_diff($this->getDatabaseColumnNames(), $this->builder->getModel()->getHidden());
    }

    protected function getDatabaseColumnNames()
    {
        return Schema::getColumnListing($this->builder->getModel()->getTable());
    }
}