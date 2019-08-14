<?php

namespace App\Presenters;

use App\Helpers\Helper;

class CategorizePresenter extends Presenter
{
    public static function dataTableLayout()
    {
        $layout = [
            [
                "field" => "id",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.id'),
                "visible" => false
            ], [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.name'),
                "visible" => true
            ],[
                "field" => "description",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.description'),
                "visible" => true
            ],[
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "categorizeActionsFormatter",
            ]
        ];

        // dd($layout);

        return json_encode($layout);
    }
}
