 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateStoreProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $store_procedure1 = "CREATE OR REPLACE PROCEDURE store_video (IN a VARCHAR(140), IN b text)
        LANGUAGE SQL
        AS $$
        INSERT INTO videos (titulo, link_video, deleted)
        VALUES (a, b, false);
        $$;";
        DB::unprepared($store_procedure1);

        $store_procedure2 = "CREATE OR REPLACE PROCEDURE store_synopsis (IN a VARCHAR(140), IN b text)
        LANGUAGE SQL
        AS $$
        INSERT INTO synopses (titulo_video, restriccion_edad, descripcion, link_imagen, fecha_creacion,id_video,deleted)
        VALUES (a, 0, b,'no hay', '1970-12-31', 2, false);
        $$;";
        DB::unprepared($store_procedure2);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_procedure');
    }
}
