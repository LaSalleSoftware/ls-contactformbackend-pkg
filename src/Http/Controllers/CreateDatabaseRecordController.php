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

namespace Lasallesoftware\Contactformbackend\Http\Controllers;

// LaSalle Software
use Lasallesoftware\Contactformbackend\Models\Contact_form;
use Lasallesoftware\Librarybackend\Common\Http\Controllers\CommonController;
use Lasallesoftware\Librarybackend\UniversallyUniqueIDentifiers\UuidGenerator;

// Laravel
use Illuminate\Support\Facades\Request;

// Third party class
use Carbon\Carbon;

/**
 * Class CreateDatabaseRecordController
 *
 * @package Lasallesoftware\Contactformbackend\Http\Controllers\CreateDatabaseRecordController
 */
class CreateDatabaseRecordController extends CommonController
{
    /**
     * Uuidgenerator class
     *
     * @var Lasallesoftware\Librarybackend\UniversallyUniqueIDentifiers\UuidGenerator
     */
    protected $uuidgenerator;
    

    /**
     * Create a new CreateDatabaseRecordController instance
     *
     * @param  Lasallesoftware\Librarybackend\UniversallyUniqueIDentifiers\UuidGenerator  $uuidgenerator
     * @return void
     */
    public function __construct(UuidGenerator $uuidgenerator)
    {
        $this->uuidgenerator = $uuidgenerator;
    }

    public function HandleCreateDatabaseRecord(Contact_form $contact_form)
    {
        // Create a UUID
        $comment = 'Lasallesoftware\Contactformbackend\Http\Controllers\HandleCreateDatabaseRecordInsert - insert the contact form submission data into the database.';
        $uuid = $this->uuidgenerator->createUuid(11, $comment, 1);

        $postData['installed_domain_id'] = $_POST["installed_domain_id"];

        // The method that gets the personbydomain_id, Lasallesoftware\Contactformfrontend\Http\Controllers::getPersonbydomainId(),
        // returns 0 when no personbydomain_id is found. The reason is that an actual value must be transmitted via the post request. 
        // A null value, or a blank value, does not transmit. So I use the value "0" to denote a null value.

        $postData['personbydomain_id']   = ($_POST["personbydomain_id"] == 0) ? null : $_POST["personbydomain_id"];
        $postData['first_name']          = $_POST["first_name"];
        $postData['surname']             = $_POST["surname"];
        $postData['email']               = $_POST["email"];
        $postData['message']             = $_POST["comment"];
        $postData['uuid']                = $uuid;
        $postData['created_at']          = Carbon::now(null);

        $result = $contact_form->createNewContactformRecord($postData);

        return response()->json([
            'result' => $result,
        ], 200);
    }
}