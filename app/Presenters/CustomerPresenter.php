<?php
namespace App\Presenters;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;

/**
 * Class AccessoryPresenter
 * @package App\Presenters
 */
class CustomerPresenter extends Presenter
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
                "formatter" => "customersLinkFormatter"
            ],
            [
                "field" => "phone",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.phone'),
                "visible" => true,
                "formatter"    => "customersPhoneFormatter",
            ],
            [
                "field" => "address",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.address'),
                "visible" => true,
                "formatter"    => "customersAddressFormatter",
            ],
            [
                "field" => "city",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.city'),
                "visible" => true,
                "formatter"    => "customersCityFormatter",
            ],
            [
                "field" => "state",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.state'),
                "visible" => true,
                "formatter"    => "customersStateFormatter",
            ],
            [
                "field" => "country",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.country'),
                "visible" => true,
                "formatter"    => "customersCountryFormatter",
            ],
            [
                "field" => "zip",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.zip'),
                "visible" => true,
                "formatter"    => "customersZipFormatter",
            ],
            [
                "field" => "taxcode",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.taxcode'),
                "visible" => true,
                "formatter"    => "customersTaxcodeFormatter",
            ],
            [
                "field" => "email",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.email'),
                "visible" => true,
                "formatter" => "customersEmailFormatter"
            ],
            [
                "field" => "change",
                "searchable" => false,
                "sortable" => false,
                "visible" => true,
                "title" => trans('general.change'),
                "visible" => true,
                "formatter" => "customersInOutFormatter",
            ], 
            [
                "field" => "change",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('general.actions'),
                "visible" => true,
                "formatter" => "customersActionsFormatter",
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
