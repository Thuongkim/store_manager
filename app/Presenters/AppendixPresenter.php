<?php
namespace App\Presenters;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;

/**
 * Class AccessoryPresenter
 * @package App\Presenters
 */
class AppendixPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
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
                "field" => "sign_date",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/appendixes/general.sign_date'),
                // "formatter" => "appendixesLinkFormatter"
            ], [
                "field" => "duration",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/appendixes/general.duration'),
                // "formatter" => "emailFormatter"
            ], [
                "field" => "renewed",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/appendixes/general.renewed'),
                // "formatter" => "phoneFormatter"
            ], [
                "field" => "value",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/appendixes/general.value')
            ], [
                "field" => "payment",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/appendixes/general.payment')
            ], [
                "field" => "payment_date",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/appendixes/general.payment_date')
            ], [
                "field" => "note",
                "searchable" => false,
                "sortable" => false,
                "title" => trans('admin/appendixes/general.note')
            ], [
                "field" => "image",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/hardware/table.image'),
                "visible" => true,
                "formatter" => "imageFormatter"
            ], [
                "field" => "number_contract",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/appendixes/general.number_contract')
            ], [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "appendixesActionsFormatter",
            ]
        ];

        return json_encode($layout);
    }


    /**
     * Pregenerated link to this accessories view page.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('appendixes.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('appendixes.show', $this->id);
    }

    public function name()
    {
        return $this->model->name;
    }
}
