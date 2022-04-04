<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_items', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(1);
            $table->boolean('dev_2')->default(0); // 0, 1
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->longText('note')->nullable();
            $table->string('image')->nullable();
            $table->boolean('developer_1_status')->default(0); // 0- Unchecked, 1- Checked
            $table->boolean('developer_2_status')->default(0);
            $table->boolean('qc_status')->default(0);
            $table->boolean('qa_status')->default(0);
            $table->text('developer_2_comment')->nullable();
            $table->text('qc_status_comment')->nullable();
            $table->text('qa_status_comment')->nullable();
            $table->integer('position')->default(1000);
            $table->softDeletes();
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
        Schema::dropIfExists('section_items');
    }
}
