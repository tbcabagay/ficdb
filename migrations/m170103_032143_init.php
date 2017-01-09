<?php

use yii\db\Migration;

class m170103_032143_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%office}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(15)->notNull(),
            'name' => $this->string(200)->notNull(),
        ]);

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'auth_key' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'last_login' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

        $this->createTable('{{%program}}', [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer()->notNull(),
            'code' => $this->string(20)->notNull(),
            'name' => $this->string(150)->notNull(),
        ]);

        $this->createTable('{{%course}}', [
            'id' => $this->primaryKey(),
            'program_id' => $this->integer()->notNull(),
            'code' => $this->string(20)->notNull(),
            'title' => $this->string(150)->notNull(),
        ]);

        $this->createTable('{{%designation}}', [
            'id' => $this->primaryKey(),
            'abbreviation' => $this->string(50)->notNull(),
            'title' => $this->string(100)->notNull(),
        ]);

        $this->createTable('{{%faculty}}', [
            'id' => $this->primaryKey(),
            'designation_id' => $this->integer()->notNull(),
            'first_name' => $this->string(50)->notNull(),
            'last_name' => $this->string(50)->notNull(),
            'middle_name' => $this->string(50)->notNull(),
            'email' => $this->string(150)->notNull(),
            'birthday' => $this->date()->notNull(),
            'tin_number' => $this->string(50)->notNull(),
            'nationality' => $this->string(150)->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%faculty_education}}', [
            'id' => $this->primaryKey(),
            'faculty_id' => $this->integer()->notNull(),
            'degree' => $this->string(100)->notNull(),
            'school' => $this->string(150)->notNull(),
            'date_graduate' => $this->string(20)->notNull(),
        ]);

        $this->createTable('{{%faculty_course}}', [
            'id' => $this->primaryKey(),
            'faculty_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('{{%template}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(50)->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('{{%notice}}', [
            'id' => $this->bigPrimaryKey(),
            'user_id' => $this->integer()->notNull(),
            'faculty_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'template_id' => $this->integer()->notNull(),
            'semester' => $this->char(1)->notNull(),
            'academic_year' => $this->char(9)->notNull(),
            'date_course_start' => $this->date()->notNull(),
            'date_final_exam' => $this->date()->notNull(),
            'date_submission' => $this->date()->notNull(),
            'reference_number' => $this->string(7)->notNull(),
        ]);

        $this->addForeignKey('fk-auth-user_id-user-id', '{{%auth}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-program-office_id-office-id', '{{%program}}', 'office_id', '{{%office}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-course-program_id-program-id', '{{%course}}', 'program_id', '{{%program}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-faculty-designation_id-designation-id', '{{%faculty}}', 'designation_id', '{{%designation}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-faculty_education-faculty_id-faculty-id', '{{%faculty_education}}', 'faculty_id', '{{%faculty}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk-faculty_course-faculty_id-faculty-id', '{{%faculty_course}}', 'faculty_id', '{{%faculty}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-faculty_course-course_id-course-id', '{{%faculty_course}}', 'course_id', '{{%course}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-template-user_id-user-id', '{{%template}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('fk-notice-user_id-user-id', '{{%notice}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-notice-faculty_id-faculty-id', '{{%notice}}', 'faculty_id', '{{%faculty}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-notice-course_id-course-id', '{{%notice}}', 'course_id', '{{%course}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-notice-template_id-template-id', '{{%notice}}', 'template_id', '{{%template}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk-auth-user_id-user-id', '{{%auth}}');
        $this->dropForeignKey('fk-program-office_id-office-id', '{{%program}}');
        $this->dropForeignKey('fk-course-program_id-program-id', '{{%course}}');
        $this->dropForeignKey('fk-faculty-designation_id-designation-id', '{{%faculty}}');
        $this->dropForeignKey('fk-faculty_education-faculty_id-faculty-id', '{{%faculty_education}}');
        $this->dropForeignKey('fk-faculty_course-faculty_id-faculty-id', '{{%faculty_course}}');
        $this->dropForeignKey('fk-faculty_course-course_id-course-id', '{{%faculty_course}}');
        $this->dropForeignKey('fk-template-user_id-user-id', '{{%template}}');
        $this->dropForeignKey('fk-notice-user_id-user-id', '{{%notice}}');
        $this->dropForeignKey('fk-notice-faculty_id-faculty-id', '{{%notice}}');
        $this->dropForeignKey('fk-notice-course_id-course-id', '{{%notice}}');
        $this->dropForeignKey('fk-notice-template_id-template-id', '{{%notice}}');

        $this->dropTable('{{%office}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%auth}}');
        $this->dropTable('{{%program}}');
        $this->dropTable('{{%course}}');
        $this->dropTable('{{%designation}}');
        $this->dropTable('{{%faculty}}');
        $this->dropTable('{{%faculty_education}}');
        $this->dropTable('{{%faculty_course}}');
        $this->dropTable('{{%template}}');
        $this->dropTable('{{%notice}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
