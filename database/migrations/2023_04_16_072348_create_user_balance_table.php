<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_balance', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->float('value')->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');
        });
        DB::unprepared("
            CREATE FUNCTION check_user_balance_value() RETURNS trigger AS $$
            BEGIN
                IF NEW.value < 0 THEN
                    RAISE EXCEPTION 'User balance value cannot be negative';
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER trigger_user_balance
                BEFORE INSERT OR UPDATE ON user_balance
                FOR EACH ROW
            EXECUTE FUNCTION check_user_balance_value();
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_balance');
        DB::unprepared("DROP FUNCTION check_user_balance_value()");
    }
};
