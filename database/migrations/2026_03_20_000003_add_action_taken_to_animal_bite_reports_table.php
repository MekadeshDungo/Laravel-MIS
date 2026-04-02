<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('animal_bite_reports', function (Blueprint $table) {
            $table->text('action_taken')->nullable()->after('status');
            $table->string('bite_severity')->nullable()->after('bite_location');
            $table->string('bite_category')->nullable()->after('bite_severity');
            $table->text('bite_description')->nullable()->after('bite_category');
            $table->string('animal_vaccination_status')->nullable()->after('animal_type');
            $table->string('reporter_name')->nullable()->after('user_id');
            $table->string('reporter_contact')->nullable()->after('reporter_name');
            $table->renameColumn('patient_name', 'victim_name');
            $table->renameColumn('patient_age', 'victim_age');
            $table->renameColumn('patient_sex', 'victim_gender');
            $table->renameColumn('patient_address', 'victim_address');
            $table->renameColumn('animal_ownership', 'animal_owner_name');
            $table->renameColumn('owner_address', 'animal_owner_address');
            $table->renameColumn('treatment_given', 'notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animal_bite_reports', function (Blueprint $table) {
            $table->dropColumn([
                'action_taken',
                'bite_severity',
                'bite_category',
                'bite_description',
                'animal_vaccination_status',
                'reporter_name',
                'reporter_contact',
            ]);
            $table->renameColumn('victim_name', 'patient_name');
            $table->renameColumn('victim_age', 'patient_age');
            $table->renameColumn('victim_gender', 'patient_sex');
            $table->renameColumn('victim_address', 'patient_address');
            $table->renameColumn('animal_owner_name', 'animal_ownership');
            $table->renameColumn('animal_owner_address', 'owner_address');
            $table->renameColumn('notes', 'treatment_given');
        });
    }
};
