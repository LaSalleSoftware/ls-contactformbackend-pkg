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
 * @copyright  (c) 2019-2025 The South LaSalle Trading Corporation
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

// Laravel Facades
use Illuminate\Support\Facades\DB;
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

        $postData['installed_domain_id'] = $this->getInstalled_domain_id($_POST["lasalle_app_domain_name"]);

        $postData['personbydomain_id']   = $this->getPersonbydomainId($_POST["email"]);
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


    /**
     * Get the personbydomains' ID given an email address. 
     * 
     * @param  string  $email  
     * @return int 
     */
    public function getPersonbydomainId($email)
    {
        $result = DB::table('personbydomains')
            ->where('email', $email)
            ->get()
        ;

        return ($result->isEmpty()) ? 1 : $result[0]->id;
    }
    
    /**
     * Get the installed_domain_id from the installed_domains db table for this front-end app.  
     * 
     * @param  string  $lasalle_app_domain_name    The env('LASALLE_APP_DOMAIN_NAME) of the front-end app sending the request
     * @return mixed 
     */
    public function getInstalled_domain_id($lasalle_app_domain_name)
    {
        return DB::table('installed_domains')
            ->where('title', $lasalle_app_domain_name)
            ->pluck('id')
            ->first()
        ;
    }
}