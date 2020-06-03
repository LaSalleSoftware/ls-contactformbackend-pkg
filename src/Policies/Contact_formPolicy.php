<?php

/**
 * This file is part of the Lasalle Software contact form back-end package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  (c) 2019-2020 The South LaSalle Trading Corporation
 * @license    http://opensource.org/licenses/MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 * @link       https://lasallesoftware.ca
 * @link       https://packagist.org/packages/lasallesoftware/ls-contactformbackend-pkg
 * @link       https://github.com/LaSalleSoftware/ls-contactformbackend-pkg
 *
 */

namespace Lasallesoftware\Contactformbackend\Policies;

// LaSalle Software classes
use Lasallesoftware\Contactformbackend\Models\Contact_form as Model;
use Lasallesoftware\Librarybackend\Common\Policies\CommonPolicy;
use Lasallesoftware\Librarybackend\Authentication\Models\Personbydomain as User;

// Laravel class
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class Contact_formPolicy
 *
 * @package Lasallesoftware\Contactformbackend\Policies
 */
class Contact_formPolicy extends CommonPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post details.
     *
     * @param  \Lasallesoftware\Librarybackend\Authentication\Models\Personbydomain  $user
     * @param  \Lasallesoftware\Contactformbackend\Models\Contact_form               $model
     * @return bool
     */
    public function view(User $user, Model $model)
    {
        // owner sees all!
        if ($user->hasRole('owner')) return true;

        // super admins only view posts that belong to their domain
        if (($user->hasRole('superadministrator')) && ($model->installed_domain_id == $user->installed_domain_id)) {
            return true;
        }

        // admins view posts that they authored
        if ($user->hasRole('administrator')) {
            return false;
        }

        // still here? better return false!
        return false;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @return bool
     */
    public function create()
    {
        return false;
    }

    /**
     * Determine whether the user can update the posts.
     * 
     * @return bool
     */
    public function update()
    {
        return false;
    }

    /**
     * Determine whether the user can delete the posts.
     *
     * @param  \Lasallesoftware\Librarybackend\Authentication\Models\Personbydomain  $user
     * @param  \Lasallesoftware\Contactformbackend\Models\Contact_form               $model
     * @return bool
     */
    public function delete(User $user, Model $model)
    {
        // owner can delete any post
        if ($user->hasRole('owner')) return true;

        // super admins can delete posts that belong to their domain
        if (($user->hasRole('superadministrator')) && ($model->installed_domain_id == $user->installed_domain_id)) {
            return true;
        }

        // admins can delete posts that they authored
        if ($user->hasRole('administrator'))  {
            return false;
        }

        // if still here, then this post is not deletable
        return false;
    }

    /**
     * Determine whether the user can restore the posts.
     *
     * DO NOT USE THIS FEATURE!
     *
     * @return bool
     */
    public function restore()
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the posts.
     *
     * DO NOT USE THIS FEATURE!
     *
     * @return bool
     */
    public function forceDelete()
    {
        return false;
    }
}