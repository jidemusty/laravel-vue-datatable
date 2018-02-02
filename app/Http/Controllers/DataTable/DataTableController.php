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

    public function index(Request $request)
    {
        return response()->json([
            'data' => [
                'table' => $this->builder->getModel()->getTable(),
                'displayable' => array_values($this->getDisplayableColumns()),
                'records' => $this->getRecords($request),
            ]
        ]);
    }

    protected function getRecords(Request $request)
    {
        return $this->builder->limit($request->limit)->get($this->getDisplayableColumns());
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
