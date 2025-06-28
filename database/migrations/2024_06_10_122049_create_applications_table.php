<?php

use App\Models\Division;
use App\Models\ExamCenter;
use App\Models\Region;
use App\Models\SubDivision;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ExamCenter::class);
            $table->foreignIdFor(Region::class)->nullable();
            $table->foreignIdFor(Division::class)->nullable();
            $table->foreignIdFor(SubDivision::class)->nullable();
            $table->foreignIdFor(User::class);
            $table->string('country')->default('Cameroon');

            // Personal info
            $table->string('name');
            $table->string('surname');
            $table->string('address')->nullable();
            $table->date('dob');
            $table->string('pob');
            $table->string('primary_language');
            $table->string('email')->unique();
            $table->string('telephone');
            $table->string('idc_number');
            $table->string('gender')->default('male');
            $table->string('bankref');
            $table->string('marital_status');
            $table->boolean('is_civil_servant')->default(false);
            $table->string('option');

            // parental info
            $table->string('mother_name');
            $table->string('mother_address')->nullable();
            $table->string('mother_contact')->nullable();

            $table->string('father_name');
            $table->string('father_address')->nullable();
            $table->string('father_contact')->nullable();

            $table->string('guardian_name');
            $table->string('guardian_address')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->date('admitted_on')->nullable();

            // Files
            $table->string('passport');
            $table->string('birthcert');
            $table->string('bankrecipt');

            $table->dateTime('validated_on')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
