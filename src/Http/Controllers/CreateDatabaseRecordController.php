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

namespace Lasallesoftware\Contactformbackend\Http\Controllers;

// LaSalle Software
use Lasallesoftware\Contactformbackend\Models\Contact_form;
use Lasallesoftware\Library\Common\Http\Controllers\CommonController;

/**
 * Class CreateDatabaseRecordController
 *
 * @package Lasallesoftware\Contactformbackend\Http\Controllers\CreateDatabaseRecordController
 */
class CreateDatabaseRecordController extends CommonController
{
    public function HandleCreateDatabaseRecord(Contact_form $contact_form)
    {
        $data['installed_domain_id'] = 1;
        //$data['personbydomain_id'] = ;
        $data['first_name'] = 'Ed';
        $data['surname'] = 'Oliver';
        $data['email'] = 'eddie@beast.com';
        $data['message'] = 'a little message from your controller!';
        //$data[''] = ;
        //$data[''] = ;
        $result = $contact_form->createNewContactformRecord($data);

        return response()->json([
            'result' => $result,
        ], 200);


    }
}