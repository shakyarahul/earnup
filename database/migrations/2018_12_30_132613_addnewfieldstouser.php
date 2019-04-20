<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addnewfieldstouser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->string('fname')->nullable($value = true);
            $table->string('lname')->nullable($value = true);
            $table->longText('location')->nullable($value = true);
            $table->string('phone')->nullable($value = true);
            $table->string('mobile')->nullable($value = true)->unique();
            $table->longText('skills')->nullable($value = true);
            $table->enum('status', ['Admin', 'Online','Offline','Disabled'])->nullable($value = true);
        });
           
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('fname');
            $table->dropColumn('lname');
            $table->dropColumn('location');
            $table->dropColumn('phone');
            $table->dropColumn('mobile');
            $table->dropColumn('skills');
            $table->dropColumn('status', ['Admin', 'Online','Offline','Disabled']);
        });
    }
}
