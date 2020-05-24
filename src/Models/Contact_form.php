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

namespace Lasallesoftware\Contactformbackend\Models;

// LaSalle Software
use Lasallesoftware\Library\Common\Models\CommonModel;

// Third party class
use Carbon\Carbon;


class Contact_form extends CommonModel
{
    ///////////////////////////////////////////////////////////////////
    //////////////          PROPERTIES              ///////////////////
    ///////////////////////////////////////////////////////////////////

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'contact_form';

    /**
     * Which fields may be mass assigned
     * @var array
     */
    protected $fillable = ['*'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * LaSalle Software handles the created_at and updated_at fields, so false.
     *
     * @var bool
     */
    public $timestamps = false;


    ///////////////////////////////////////////////////////////////////
    //////////////        RELATIONSHIPS             ///////////////////
    ///////////////////////////////////////////////////////////////////

    /*
     * One to one relationship with personbydomains.
     *
     * Method name must be:
     *    * the model name,
     *    * NOT the table name,
     *    * singular;
     *    * lowercase.
     *
     * @return Eloquent
     */
    public function personbydomain()
    {
        return $this->belongsTo('Lasallesoftware\Library\Authentication\Models\Personbydomain', 'personbydomain_id', 'id');
    }


    ///////////////////////////////////////////////////////////////////
    //////////////         CRUD ACTIONS             ///////////////////
    ///////////////////////////////////////////////////////////////////

    /**
     * Create a new contact_form database table record.
     * 
     * Called from Lasallesoftware\Contactformbackend\Http\Controllers\CreateDatabaseRecordController.
     *
     * @param  array $data
     * @return mixed
     */
    public function createNewContactformRecord($data)
    {
        $contactform = new Contact_form;

        $contactform->installed_domain_id = $data['installed_domain_id'];
        $contactform->personbydomain_id   = $data['personbydomain_id'];
        $contactform->first_name          = $data['first_name'];
        $contactform->surname             = $data['surname'];
        $contactform->email               = $data['email'];
        $contactform->message             = $data['message'];
        $contactform->uuid                = $data['uuid'] ?: null;
        $contactform->created_at          = Carbon::now(null);

        if ($contactform->save()) {
            // Return the new ID
            return $contactform->id;
        }
        return false;
    }
}