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

        DB::statement('DROP PROCEDURE IF EXISTS migrate_adoption_pets');
        DB::statement('CREATE PROCEDURE migrate_adoption_pets() 
        BEGIN
            DECLARE done INT DEFAULT FALSE;
            DECLARE v_adoption_id BIGINT;
            DECLARE v_pet_name VARCHAR(255);
            DECLARE v_species VARCHAR(100);
            DECLARE v_gender VARCHAR(20);
            DECLARE v_calculated_age INT;
            DECLARE v_breed VARCHAR(255);
            DECLARE v_description TEXT;
            DECLARE v_weight DECIMAL(5,2);
            DECLARE v_image VARCHAR(500);
            DECLARE v_date_of_birth DATE;
            DECLARE v_created_at TIMESTAMP;
            DECLARE v_updated_at TIMESTAMP;
            DECLARE v_pet_id BIGINT;

            DECLARE cur CURSOR FOR 
                SELECT adoption_id, pet_name, species, gender, breed, description, 
                       weight, image, date_of_birth, created_at, updated_at
                FROM adoption_pets;

            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

            OPEN cur;
            read_loop: LOOP
                FETCH cur INTO v_adoption_id, v_pet_name, v_species, v_gender, 
                              v_breed, v_description, v_weight, v_image, v_date_of_birth, 
                              v_created_at, v_updated_at;

                IF done THEN
                    LEAVE read_loop;
                END IF;

                IF v_image IS NOT NULL AND TRIM(v_image) != "" THEN
                    SELECT pet_id INTO v_pet_id FROM pets 
                    WHERE TRIM(LOWER(pet_image)) = TRIM(LOWER(v_image)) LIMIT 1;

                    IF v_pet_id IS NOT NULL THEN
                        UPDATE pets SET 
                            pet_name = COALESCE(NULLIF(pet_name, ""), v_pet_name),
                            species = COALESCE(NULLIF(species, ""), v_species),
                            breed = COALESCE(NULLIF(breed, ""), v_breed),
                            sex = COALESCE(NULLIF(sex, ""), v_gender),
                            pet_weight = COALESCE(pet_weight, v_weight),
                            birthdate = COALESCE(birthdate, v_date_of_birth),
                            pet_image = COALESCE(NULLIF(pet_image, ""), v_image),
                            notes = CONCAT(IFNULL(notes, ""), COALESCE(CONCAT("\n", v_description), "")),
                            source_module = "adoption_pets",
                            source_module_id = v_adoption_id,
                            consolidated_at = NOW()
                        WHERE pet_id = v_pet_id;

                        SET v_pet_id = NULL;
                        ITERATE read_loop;
                    END IF;
                END IF;

                IF v_pet_name IS NOT NULL AND TRIM(v_pet_name) != "" AND v_date_of_birth IS NOT NULL THEN
                    SELECT pet_id INTO v_pet_id FROM pets 
                    WHERE TRIM(LOWER(pet_name)) = TRIM(LOWER(v_pet_name)) 
                      AND DATE(birthdate) = v_date_of_birth
                      AND (source_module IS NULL OR source_module != "adoption_pets")
                    LIMIT 1;

                    IF v_pet_id IS NOT NULL THEN
                        UPDATE pets SET 
                            species = COALESCE(NULLIF(species, ""), v_species),
                            breed = COALESCE(NULLIF(breed, ""), v_breed),
                            sex = COALESCE(NULLIF(sex, ""), v_gender),
                            pet_weight = COALESCE(pet_weight, v_weight),
                            pet_image = COALESCE(NULLIF(pet_image, ""), v_image),
                            notes = CONCAT(IFNULL(notes, ""), COALESCE(CONCAT("\n", v_description), "")),
                            source_module = "adoption_pets",
                            source_module_id = v_adoption_id,
                            consolidated_at = NOW()
                        WHERE pet_id = v_pet_id;

                        SET v_pet_id = NULL;
                        ITERATE read_loop;
                    END IF;
                END IF;

                INSERT INTO pets (
                    owner_id, barangay_id, pet_name, species, breed, sex, 
                    pet_weight, notes, pet_image, birthdate, is_neutered, 
                    created_at, updated_at, source_module, source_module_id, 
                    consolidated_at
                ) VALUES (
                    NULL, NULL, v_pet_name, v_species, v_breed, v_gender,
                    v_weight, v_description, v_image, v_date_of_birth, 0,
                    v_created_at, v_updated_at, "adoption_pets", v_adoption_id,
                    NOW()
                );

                SET v_pet_id = NULL;
            END LOOP;

            CLOSE cur;
        END');

        DB::statement('CALL migrate_adoption_pets()');
        DB::statement('DROP PROCEDURE IF EXISTS migrate_adoption_pets');
    }

    public function down(): void
    {
        DB::update('UPDATE pets SET source_module = NULL, source_module_id = NULL, 
            consolidated_at = NULL WHERE source_module = "adoption_pets"');
    }
};