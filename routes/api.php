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
 * @license    http://opensource.org/licenses/MIT MIT
 * @author     Bob Bloom
 * @email      bob.bloom@lasallesoftware.ca
 * @link       https://lasallesoftware.ca
 * @link       https://packagist.org/packages/lasallesoftware/lsv2-contactformbackend-pkg
 * @link       https://github.com/LaSalleSoftware/lsv2-contactformbackend-pkg
 *
 */


Route::middleware(['jwt_auth'], 'throttle:60,1')
    ->group(function () {
        Route::get('/api/v1/contactform/createdatabaserecord', 'Lasallesoftware\Contactformbackend\Http\Controllers\CreateDatabaseRecordController@HandleCreateDatabaseRecord');
    }
);