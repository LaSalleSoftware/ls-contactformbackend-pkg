<?php

/**
 * This file is part of the Lasalle Software contact form back-end package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * 
 * ==========================================================================
 *             LARAVEL's NOVA IS A COMMERCIAL PACKAGE!
 * --------------------------------------------------------------------------
 *  NOVA is a *first*-party commercial package for the Laravel Framework, made
 *  by the Laravel Project. You have to pay for it.
 *
 *  So, yes, my LaSalle Software, as FOSS as it may be, depends on a commercial
 *  OSS package.
 * ==========================================================================
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  (c) 2019-2022 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 * @link       https://lasallesoftware.ca
 * @link       https://packagist.org/packages/lasallesoftware/ls-contactformbackend-pkg
 * @link       https://github.com/LaSalleSoftware/ls-contactformbackend-pkg
 *
 */

namespace Lasallesoftware\Contactformbackend\Nova\Resources;

// LaSalle Software classes
use Lasallesoftware\Librarybackend\Authentication\Models\Personbydomain as Personbydomainmodel;
use Lasallesoftware\Novabackend\Nova\Fields\Comments;
use Lasallesoftware\Novabackend\Nova\Fields\CreatedAt;
use Lasallesoftware\Novabackend\Nova\Resources\BaseResource;

// Laravel Nova classes
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

// Laravel Framework classes
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

// Laravel Framework facades
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Personbydomain
 *
 * @package Lasallesoftware\Contactformbackend\Nova\Resources\Contact_formResource
 */
class Contact_form extends BaseResource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Lasallesoftware\\Contactformbackend\\Models\\Contact_form';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Other';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'email';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'first_name', 'surname', 'email',
    ];

    /**
     * Determine if this resource is available for navigation.
     *
     * Only the owner role can see this resource in navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return Personbydomainmodel::find(Auth::id())->IsOwner() 
            || Personbydomainmodel::find(Auth::id())->IsSuperadministrator()
        ;
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('lasallesoftwarecontactformbackend::contactformbackend.resource_label_plural_contactform');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('lasallesoftwarecontactformbackend::contactformbackend.resource_label_singular_contactform');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('lasallesoftwarelibrarybackend::general.resource_label_singular_installed_domains'), 'installed_domain_id')
                ->displayUsing(function ($text) {
                    return DB::table('installed_domains')->where('id', $text)->pluck('title')->first();
                })
                ->sortable()
            ,

            DateTime::make(__('lasallesoftwarecontactformbackend::contactformbackend.field_name_created_at'), 'created_at')
                ->sortable()
                ->format('MMMM DD, YYYY, h:mma')
            ,

            Text::make(__('lasallesoftwarelibrarybackend::general.field_name_first_name'), 'first_name')
                ->hideFromIndex()
            ,

            Text::make(__('lasallesoftwarelibrarybackend::general.field_name_surname'), 'surname')
                ->hideFromIndex()
            ,

            Text::make(__('lasallesoftwarelibrarybackend::general.field_name_email'), 'email')
                ->sortable()
            ,

            Text::make(__('lasallesoftwarelibrarybackend::general.field_name_comments'), 'message')
                ->hideFromIndex()
            ,

            Text::make(__('lasallesoftwarelibrarybackend::general.field_name_comments'), 'message')
                ->onlyOnIndex()
                ->displayUsing(function ($text) {
                    if (strlen($text) > 30) {
                        return substr($text, 0, 30) . '...';
                    }
                    return $text;
                })
            ,

            BelongsTo::make(__('lasallesoftwarecontactformbackend::contactformbackend.field_name_personbydomain'),'personbydomain','\Lasallesoftware\Novabackend\Nova\Resources\Personbydomain')
                ->hideFromIndex()
            ,

            Text::make(__('lasallesoftwarecontactformbackend::contactformbackend.field_name_uuid'))
                ->hideFromIndex()
            ,
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Build an "index" query for the given resource.
     *
     * Overrides Laravel\Nova\Actions\ActionResource::indexQuery
     *
     * Since Laravel's policies do *NOT* include an action for the controller's INDEX action,
     * we have to override Nova's resource indexQuery method.
     *
     * So, we are going to mimick here what the "index" policy would do.
     *
     * Only owners see the index listing.
     *
     *
     * Called from a resource's indexQuery() method.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder    $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        // owners see all records
        if (auth()->user()->hasRole('owner')) {
            return $query;
        }

        // super admins see all records belonging to their domain
        if (auth()->user()->hasRole('superadministrator')) {
            return $query
                ->where('installed_domain_id', DB::table('personbydomains')->where('id', Auth::id())->pluck('installed_domain_id')->first())
            ;
        }

        // still here -- maybe still here by entering the endpoint in the browser
        return $query->where('id', 0);
    }
}
