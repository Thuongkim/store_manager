<?php
namespace App\Presenters;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;

/**
 * Class AccessoryPresenter
 * @package App\Presenters
 */
class WarningPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                "field" => "checkbox",
                "checkbox" => true
            ],
            [
                "field" => "id",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.id'),
                "visible" => false
            ], 
            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.name'),
                "visible" => true,
                "formatter" => "warningsLinkFormatter"
            ],
            [
                "field" => "created_customer_at",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.created_customer_at'),
                "visible" => true,
                "formatter"    => "warningsLinkFormatter",
            ],
            [
                "field" => "duration",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.durations'),
                "visible" => true,
                "formatter"    => "warningsLinkFormatter",
            ],
            [
                "field" => "warning_before",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.warning_before'),
                "visible" => true,
                "formatter"    => "warningsLinkFormatter",
            ],
            [
                "field" => "hour_warning",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.hour_warning'),
                "visible" => true,
                "formatter"    => "warningsLinkFormatter",
            ],
            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('general.actions'),
                "visible" => true,
                "formatter" => "warningsActionsFormatter",
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
        return (string) link_to_route('accessories.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('accessories.show', $this->id);
    }

    public function name()
    {
        return $this->model->name;
    }
}
