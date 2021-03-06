<?php

namespace App\Http\Controllers\DataTable;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\DataTable\DataTableController;

class PersonController extends DataTableController
{
    public function builder()
    {
        return User::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id', 'name', 'email', 'created_at'
        ];
    }

    public function getUpdatableColumns()
    {
        return [
            'name', 'email', 'created_at'
        ];
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required | email'
        ]);

        $this->builder->find($id)->update($request->only($this->getUpdatableColumns()));
    }

    public function getCustomColumnNames()
    {
        return [
            'name' => 'Fullname',
            'email' => 'Email address',
        ];
    }
}
