<?php
namespace App\Presenters;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;

/**
 * Class AccessoryPresenter
 * @package App\Presenters
 */
class SalePresenter extends Presenter
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
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.name'),
                "formatter" => "salesLinkFormatter"
            ], [
                "field" => "email",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/sales/general.email'),
                "formatter" => "emailFormatter"
            ], [
                "field" => "phone",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/sales/general.phone'),
                "formatter" => "phoneFormatter"
            ], [
                "field" => "address",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.address')
            ], [
                "field" => "gender",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/sales/general.gender')
            ], [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "salesActionsFormatter",
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
        return (string) link_to_route('sales.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('sales.show', $this->id);
    }

    public function name()
    {
        return $this->model->name;
    }
}
