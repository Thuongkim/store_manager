<?php

namespace App\Presenters;

use App\Helpers\Helper;

class ContractPresenter extends Presenter
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
                "field" => "number",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.number'),
                "visible" => true
            ],[
                "field" => "sign_day",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.sign_day'),
                "visible" => true
            ],[
                "field" => "customer",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.customer')
            ],[
                "field" => "categorize",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.categorize')
            ],[
                "field" => "duration",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.duration'),
                "visible" => true
            ],[
                "field" => "renewed",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.renewed'),
                "visible" => true,
                'formatter' => 'trueFalseFormatter'
            ],[
                "field" => "value",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.value'),
                "visible" => true
            ],[
                "field" => "payment",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.payment'),
                "visible" => true
            ],[
                "field" => "day_payment",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.day_payment'),
                "visible" => true
            ],[
                "field" => "images",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.images'),
                "visible" => true,
                "formatter" => "imagesFormatter"
            ],[
                "field" => "note",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.note'),
                "visible" => true
            ],[
                "field" => "sale",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/contract/general.sale')
            ],[
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "contractActionsFormatter"
            ]
        ];

        // dd($layout);

        return json_encode($layout);
    }
    
    public function name()
    {
        return $this->model->name;
    }
    public function imageUrl()
    {
        if (!empty($this->image)) {
            return '<img src="' . url('/') . '/images/' . $this->image . '" height=50 width=50>';
        }
        return '';
    }
}
