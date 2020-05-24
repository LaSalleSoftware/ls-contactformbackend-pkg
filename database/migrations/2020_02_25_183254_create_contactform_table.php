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

 // LaSalle Software
use Lasallesoftware\Library\Database\Migrations\BaseMigration;

// Laravel classes
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateContactformTable extends BaseMigration
{
    /**
     * The name of the database table
     *
     * @var string
     */
    protected $tableName = "contact_form";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ((!Schema::hasTable($this->tableName)) &&
            ($this->doTheMigration(env('APP_ENV'), env('LASALLE_APP_NAME')))) {

            Schema::create($this->tableName, function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');

                $table->integer('installed_domain_id')->unsigned()->comment('The domain.');
                $table->foreign('installed_domain_id')->references('id')->on('installed_domains');

                $table->integer('personbydomain_id')->unsigned()->nullable();
                $table->foreign('personbydomain_id')->references('id')->on('personbydomains');

                $table->string('first_name')->nullable();
                $table->string('surname')->nullable();
                $table->string('email')->nullable();
                $table->text('message')->nullable();

                $table->uuid('uuid')->nullable();

                $table->timestamp('created_at')->useCurrent();        
            });
        }
    }
}