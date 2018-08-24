<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submission_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('email_sent');
            $table->string('staff_name');
            $table->string('staff_email');
            $table->string('staff_phone')->default('not specified');
            $table->smallInteger('provider_name_fk');
            $table->string('contact_method');
            $table->smallInteger('issue_type_fk');       
            $table->string('details_field')->nullable();
            $table->text('errors')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submission_logs');
    }
}
