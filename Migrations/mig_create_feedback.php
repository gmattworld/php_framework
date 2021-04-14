<?php

//    namespace app\Migrations;
    use app\core\Application;

    class mig_create_feedback
    {
        public function up()
        {
            $db = Application::$app->db;
            $SQL = "CREATE TABLE feedbacks (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(255) NOT NULL,
                    message TEXT NOT NULL,
                    status TINYINT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )  ENGINE=INNODB;";
            $db->pdo->exec($SQL);
        }

        public function down()
        {
            $db = Application::$app->db;
            $SQL = "DROP TABLE feedbacks;";
            $db->pdo->exec($SQL);
        }
    }
