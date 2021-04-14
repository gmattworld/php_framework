<?php


    namespace app\core;


    abstract class DBModel extends Model
    {
        abstract public static function tableName(): string;

        public function primaryKey(): string
        {
            return 'id';
        }

        public static function prepare($sql): \PDOStatement
        {
            return Application::$app->db->prepare($sql);
        }

        public static function find($where)
        {
            $tableName = static::tableName();
            $attributes = array_keys($where);
            $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
            $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
            foreach ($where as $key => $item) {
                $statement->bindValue(":$key", $item);
            }
            $statement->execute();
            return $statement->fetchObject(static::class);
        }

        public function save()
        {
            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $params = array_map(fn($attr) => ":$attr", $attributes);
            $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") VALUES (" . implode(",", $params) . ")");
            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }
            $statement->execute();
            return true;
        }

        public function update()
        {
            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $params = array_map(fn($attr) => ":$attr", $attributes);
            $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") VALUES (" . implode(",", $params) . ")");
            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }
            $statement->execute();
            return true;
        }

        public function getAll()
        {
            $tableName = $this->tableName();
//            $attributes = $this->attributes();
//            $statement = self::prepare("SELECT " . implode(",", $attributes) . " FROM $tableName");
            $statement = self::prepare("SELECT * FROM $tableName");
            $statement->execute();
            return $statement->fetchObject(static::class);
        }
    }