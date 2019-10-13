<?php

use yii\db\Migration;
use yii\db\Schema;
use yii\db\Transaction;
use app\models\Department;
/**
 * Class m191010_031125_create_departments
 */
class m191010_031125_create_departments extends Migration
{
  
    
        /** create table on the migration command */
        public function up()
        {
            /**creat prefix to identify the tables of project */
            $prefix="e&Y_";

            
                $this->statusTable($prefix);
                $this->departmentsTable($prefix);
                $this->rolesTable($prefix);
                $this->usersTable($prefix);
                $this->daakTable($prefix);
                $this->commentTable($prefix);
        }
    
        /**drop table when migration down */
        public function down()
        {

            $this->dropIndex(
                'idx-users-user_type',
                $prefix.'users'
            );

            $this->dropIndex(
                'idx-users-user_department',
                $prefix.'users'
            );

            $this->dropIndex(
                'idx-daak-user_department',
                $prefix.'daak'
            );

            $this->dropIndex(
                'idx-daak-user_type',
                $prefix.'daak'
            );

            $this->dropIndex(
                'idx-daak-status',
                $prefix.'daak'
            );

            $this->dropIndex(
                'idx-daak-approve_by',
                $prefix.'daak'
            );

            $this->dropIndex(
                'idx-daak-created_by',
                $prefix.'daak'
            );

            $this->dropForeignKey(
                'fk-users-user_type',
                $prefix.'users'
            );

            $this->dropForeignKey(
                'fk-users-user_department',
                $prefix.'users'
            );

            $this->dropForeignKey(
                'fk-daak-user_type',
                $prefix.'daak'
            );

            $this->dropForeignKey(
                'fk-daak-department_type',
                $prefix.'daak'
            );

            $this->dropForeignKey(
                'fk-daak-status',
                $prefix.'daak'
            );

            $this->dropForeignKey(
                'fk-daak-created_by',
                $prefix.'daak'
            );

            $this->dropForeignKey(
                'fk-daak-approve_by',
                $prefix.'daak'
            );

            $this->dropTable($prefix.'status');
            $this->dropTable($prefix.'departments');
            $this->dropTable($prefix.'roles');
            $this->dropTable($prefix.'users');
            $this->dropTable($prefix.'daak');
            $this->dropTable($prefix.'comments');
        }



        /**departments table schema */
        public function daakTable($prefix){

            /*create department table schema*/
            $this->createTable($prefix.'daak', [
                'id' => Schema::TYPE_PK,
                'subject' => Schema::TYPE_STRING . ' NOT NULL',
                'content' => Schema::TYPE_TEXT . ' NOT NULL',
                'department_type' => Schema::TYPE_INTEGER . ' NOT NULL',
                'user_type' => Schema::TYPE_INTEGER  . ' NOT NULL',
                'upload_document' => Schema::TYPE_STRING . ' NOT NULL',
                'created_by' => Schema::TYPE_INTEGER . ' NOT NULL',
                'approve_by' => Schema::TYPE_INTEGER . ' NULL',
                'status' => Schema::TYPE_INTEGER . ' NOT NULL',
                'created_at' => Schema::TYPE_DATETIME,
                'updated_at' => Schema::TYPE_DATETIME,
            ]);

            /**create index  */
            $this->createIndex(
                'idx-daak-user_type',
                $prefix.'daak',
                'user_type'
            );

            $this->createIndex(
                'idx-daak-department_type',
                $prefix.'daak',
                'department_type'
            );

            $this->createIndex(
                'idx-daak-created_by',
                $prefix.'daak',
                'created_by'
            );

            $this->createIndex(
                'idx-daak-approve_by',
                $prefix.'daak',
                'approve_by'
            );

            $this->createIndex(
                'idx-daak-status',
                $prefix.'daak',
                'status'
            );

            /**add foreign key */
            $this->addForeignKey(
                'fk-daak-user_type',
                $prefix.'daak',
                'user_type',
                $prefix.'roles',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-daak-department_type',
                $prefix.'daak',
                'department_type',
                $prefix.'departments',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-daak-status',
                $prefix.'daak',
                'status',
                $prefix.'status',
                'id',
                'CASCADE'
            );
            
            $this->addForeignKey(
                'fk-daak-created_by',
                $prefix.'daak',
                'created_by',
                $prefix.'users',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'fk-daak-approve_by',
                $prefix.'daak',
                'approve_by',
                $prefix.'users',
                'id',
                'CASCADE'
            );
    }



            /**departments table schema */
            public function commentTable($prefix){

                /*create department table schema*/
                $this->createTable($prefix.'comments', [
                    'id' => Schema::TYPE_PK,
                    'message' => Schema::TYPE_TEXT . ' NOT NULL',
                    'message_by' => Schema::TYPE_INTEGER . ' NOT NULL',
                    'daak' => Schema::TYPE_INTEGER . ' NOT NULL',
                    'created_at' => Schema::TYPE_DATETIME,
                ]);

                /**create index  */
                $this->createIndex(
                    'idx-comment-message_by',
                    $prefix.'comments',
                    'message_by'
                );

                $this->createIndex(
                    'idx-comment-daak',
                    $prefix.'comments',
                    'daak'
                );
                
                /**add foreign key */
                $this->addForeignKey(
                    'fk-comment-message_by',
                    $prefix.'comments',
                    'message_by',
                    $prefix.'users',
                    'id',
                    'CASCADE'
                );


                $this->addForeignKey(
                    'fk-comment-daak',
                    $prefix.'comments',
                    'daak',
                    $prefix.'daak',
                    'id',
                    'CASCADE'
                );
        }


        /**Status table schema */
        public function statusTable($prefix){
            /*create department table schema*/
            $this->createTable($prefix.'status', [
                'id' => Schema::TYPE_PK,
                'status_type' => Schema::TYPE_STRING . ' NOT NULL',
                'created_at' => Schema::TYPE_DATETIME,
                'updated_at' => Schema::TYPE_DATETIME,
            ]);
            
        }



        /**departments table schema */
        public function departmentsTable($prefix){

            /*create department table schema*/
            $this->createTable($prefix.'departments', [
                'id' => Schema::TYPE_PK,
                'department' => Schema::TYPE_STRING . ' NOT NULL',
                'created_at' => Schema::TYPE_DATETIME,
                'updated_at' => Schema::TYPE_DATETIME,
            ]);
            
        }

           

        /**departments table schema */
        public function rolesTable($prefix){

                    /*create role table schema*/
                    $this->createTable($prefix.'roles', [
                        'id' => Schema::TYPE_PK,
                        'role' => Schema::TYPE_STRING . ' NOT NULL',
                        'role_alias' => Schema::TYPE_STRING . ' NOT NULL',
                        'created_at' => Schema::TYPE_DATETIME,
                        'updated_at' => Schema::TYPE_DATETIME,
                    ]);
            
        }



        /**user table schema */
        public function usersTable($prefix)
        {

                    /*create department table schema*/
                    $this->createTable($prefix.'users', [
                        'id' => Schema::TYPE_PK,
                        'username' => Schema::TYPE_STRING . ' NOT NULL',
                        'password' => Schema::TYPE_STRING . ' NOT NULL',
                        'user_email' => Schema::TYPE_STRING . ' NOT NULL',
                        'user_type' => Schema::TYPE_INTEGER . ' NOT NULL',
                        'user_department' => Schema::TYPE_INTEGER . ' NULL',
                        'authKey' => Schema::TYPE_STRING . '  NULL',
                        'accessToken' => Schema::TYPE_STRING . '  NULL',
                        'created_at' => Schema::TYPE_DATETIME,
                        'updated_at' => Schema::TYPE_DATETIME,
                    ]);


                        /**create index for the user type */
                        $this->createIndex(
                            'idx-users-user_type',
                            $prefix.'users',
                            'user_type'
                        );

                        $this->createIndex(
                            'idx-users-user_department',
                            $prefix.'users',
                            'user_department'
                        );



                        /**add foreign key for user type index for the user type */
                        $this->addForeignKey(
                            'fk-users-user_type',
                            $prefix.'users',
                            'user_type',
                            $prefix.'roles',
                            'id',
                            'CASCADE'
                        );

                        $this->addForeignKey(
                            'fk-users-user_department',
                            $prefix.'users',
                            'user_department',
                            $prefix.'departments',
                            'id',
                            'CASCADE'
                        );                 
        }
    
}
