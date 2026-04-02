<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('livestock', function (Blueprint $table) {
            if (! Schema::hasColumn('livestock', 'animal_type')) {
                $table->string('animal_type')->nullable()->after('species');
            }

            if (! Schema::hasColumn('livestock', 'quantity')) {
                $table->unsignedInteger('quantity')->default(1)->after('animal_type');
            }

            if (! Schema::hasColumn('livestock', 'farm_name')) {
                $table->string('farm_name')->nullable()->after('owner_name');
            }
        });

        Schema::table('establishments', function (Blueprint $table) {
            if (Schema::hasColumn('establishments', 'permit_no')) {
                $table->dropColumn('permit_no');
            }

            if (Schema::hasColumn('establishments', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('livestock', function (Blueprint $table) {
            if (Schema::hasColumn('livestock', 'farm_name')) {
                $table->dropColumn('farm_name');
            }

            if (Schema::hasColumn('livestock', 'quantity')) {
                $table->dropColumn('quantity');
            }

            if (Schema::hasColumn('livestock', 'animal_type')) {
                $table->dropColumn('animal_type');
            }
        });

        Schema::table('establishments', function (Blueprint $table) {
            if (! Schema::hasColumn('establishments', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('barangay_id');
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('establishments', 'permit_no')) {
                $table->string('permit_no')->nullable()->after('type');
            }
        });
    }
};
