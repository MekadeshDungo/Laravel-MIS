<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->down();

        DB::statement('DROP PROCEDURE IF EXISTS migrate_missing_pets');
        DB::statement('CREATE PROCEDURE migrate_missing_pets() 
        BEGIN
            DECLARE done INT DEFAULT FALSE;
            DECLARE v_missing_id BIGINT;
            DECLARE v_pet_name VARCHAR(255);
            DECLARE v_species VARCHAR(100);
            DECLARE v_gender VARCHAR(20);
            DECLARE v_age INT;
            DECLARE v_breed VARCHAR(255);
            DECLARE v_description TEXT;
            DECLARE v_weight DECIMAL(5,2);
            DECLARE v_image VARCHAR(500);
            DECLARE v_date_of_birth DATE;
            DECLARE v_missing_since DATE;
            DECLARE v_last_seen_location TEXT;
            DECLARE v_contact_info TEXT;
            DECLARE v_created_at TIMESTAMP;
            DECLARE v_updated_at TIMESTAMP;
            DECLARE v_pet_id BIGINT;
            DECLARE v_new_pet_id BIGINT;

            DECLARE cur CURSOR FOR 
                SELECT missing_id, pet_name, species, gender, age, breed, description,
                       weight, image, date_of_birth, missing_since, last_seen_location,
                       contact_info, created_at, updated_at
                FROM missing_pets;

            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

            OPEN cur;
            read_loop: LOOP
                FETCH cur INTO v_missing_id, v_pet_name, v_species, v_gender, v_age,
                              v_breed, v_description, v_weight, v_image, v_date_of_birth,
                              v_missing_since, v_last_seen_location, v_contact_info,
                              v_created_at, v_updated_at;

                IF done THEN
                    LEAVE read_loop;
                END IF;

                SET v_pet_id = NULL;

                IF v_image IS NOT NULL AND TRIM(v_image) != "" THEN
                    SELECT pet_id INTO v_pet_id FROM pets 
                    WHERE TRIM(LOWER(pet_image)) = TRIM(LOWER(v_image)) LIMIT 1;
                END IF;

                IF v_pet_id IS NULL AND v_pet_name IS NOT NULL AND TRIM(v_pet_name) != "" AND v_date_of_birth IS NOT NULL THEN
                    SELECT pet_id INTO v_pet_id FROM pets 
                    WHERE TRIM(LOWER(pet_name)) = TRIM(LOWER(v_pet_name)) 
                      AND DATE(birthdate) = v_date_of_birth
                      AND (source_module IS NULL OR source_module != "missing_pets")
                    LIMIT 1;
                END IF;

                IF v_pet_id IS NOT NULL THEN
                    UPDATE pets SET 
                        pet_name = COALESCE(NULLIF(pet_name, ""), v_pet_name),
                        breed = COALESCE(NULLIF(breed, ""), v_breed),
                        sex = COALESCE(NULLIF(sex, ""), v_gender),
                        birthdate = COALESCE(birthdate, v_date_of_birth),
                        pet_image = COALESCE(NULLIF(pet_image, ""), v_image),
                        notes = CONCAT(IFNULL(notes, ""), COALESCE(CONCAT("\n[MISSING RECORD] ", v_contact_info), "")),
                        pet_status = COALESCE(pet_status, "missing"),
                        source_module = "missing_pets",
                        source_module_id = v_missing_id,
                        consolidated_at = NOW()
                    WHERE pet_id = v_pet_id;

                    INSERT INTO missing_reports (
                        pet_id, last_seen_date, last_seen_location, contact_info, source_missing_id, created_at
                    ) VALUES (
                        v_pet_id, v_missing_since, v_last_seen_location, v_contact_info, v_missing_id, NOW()
                    );

                    SET v_pet_id = NULL;
                ELSE
                    INSERT INTO pets (
                        owner_id, barangay_id, pet_name, species, breed, sex, age,
                        weight, notes, pet_image, birthdate, is_neutered, pet_status,
                        created_at, updated_at, source_module, source_module_id, consolidated_at
                    ) VALUES (
                        NULL, NULL, v_pet_name, v_species, v_breed, v_gender, v_age,
                        v_weight, CONCAT("[MISSING] ", v_contact_info), v_image, v_date_of_birth, 0, "missing",
                        v_created_at, v_updated_at, "missing_pets", v_missing_id, NOW()
                    );

                    SET v_new_pet_id = LAST_INSERT_ID();

                    INSERT INTO missing_reports (
                        pet_id, last_seen_date, last_seen_location, contact_info, source_missing_id, created_at
                    ) VALUES (
                        v_new_pet_id, v_missing_since, v_last_seen_location, v_contact_info, v_missing_id, NOW()
                    );
                END IF;
            END LOOP;

            CLOSE cur;
        END');

        DB::statement('CALL migrate_missing_pets()');
        DB::statement('DROP PROCEDURE IF EXISTS migrate_missing_pets');
    }

    public function down(): void
    {
        DB::delete('DELETE mr FROM missing_reports mr 
            INNER JOIN pets p ON p.pet_id = mr.pet_id WHERE p.source_module = "missing_pets"');
        
        DB::delete('DELETE FROM pets WHERE source_module = "missing_pets"');
    }
};