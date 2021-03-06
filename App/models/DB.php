<?php
namespace App\models;


class DB
{
    private $connect_settings = [
        "host" => "127.0.0.1",
        "user" => "root",
        "pass" => null,
        "db_name" => "taskManager",
    ];

    private $db_connect;


    public function __construct($connect_settings = null)
    {
        if(!is_null($connect_settings))
        {
            $this->connect_settings = $connect_settings;
        }
    }


    /**
     * Соединиться с БД
     * @return bool
     * @throws \Exception
     */
    private function connect()
    {
        if($this->db_connect instanceof \mysqli && $this->db_connect->ping())
        {
            return true;
        }

        $resConnect = new \mysqli($this->connect_settings["host"], $this->connect_settings["user"], $this->connect_settings["pass"], $this->connect_settings["db_name"]);

            if($resConnect->connect_error)
            {
                throw new \Exception($resConnect->connect_error);
            }


        $this->db_connect = $resConnect;
    }

    /**
     * Закрыть соединение с БД
     */
    private function disconnect()
    {
        if($this->db_connect instanceof \mysqli && $this->db_connect->ping())
        {
            $this->db_connect->close();
        }
    }


    /**
     * Сделать запись в бд
     * @param $tableName - название для таблицы
     * @param $arrValues - массив с данными для записи [key (это название поля в таблице) => value]
     * @param bool|false $close - Закрывать ли соединение с бд
     * @return $this
     * @throws \Exception
     */
    public function insert($tableName, $arrValues, $close = false)
    {
        $this->connect();

        $cols = array_keys($arrValues);
        $sql = "INSERT INTO ".$tableName." (".implode(",", $cols).") VALUES ('".implode("','", $arrValues)."')";

        $resQuery = $this->db_connect->query($sql);
        if(!$resQuery){
            throw new \Exception($this->db_connect->error);
        }

        $insert_id = $this->db_connect->insert_id;

        if($close){
            $this->disconnect();
        }

        return $insert_id;
    }


    /**
     * Удалить запись из БД
     * @param $table - название для таблицы
     * @param $where - условие where
     * @param bool|false $close  - Закрывать ли соединение с бд
     * @return $this
     * @throws \Exception
     */
    public function delete($table, $where, $close = false)
    {
        $this->connect();

        $sql = "DELETE FROM ".$table." WHERE ".$where;

        $resQuery = $this->db_connect->query($sql);
        if(!$resQuery){
            throw new \Exception($this->db_connect->error);
        }

        if($close){
            $this->disconnect();
        }

        return $this;

    }


    /**
     * @param $tableName - название для таблицы
     * @param $arrValues - массив с данными для записи [key (это название поля в таблице) => value]
     * @param $where - условие where
     * @param bool|false $close - Закрывать ли соединение с бд
     * @return $this
     * @throws \Exception
     */
    public function update($tableName, $arrValues, $where, $close = false)
    {
        $this->connect();

        $forSql = [];
        foreach ($arrValues as $key => $value) {
            $forSql[] = $key."='".$value."'";
        }

        $sql = "UPDATE ".$tableName." SET ".implode(",", $forSql)." WHERE ".$where;

        $resQuery = $this->db_connect->query($sql);
        if(!$resQuery){
            throw new \Exception($this->db_connect->error);
        }

        if($close){
            $this->disconnect();
        }

        return $this;
    }


    /**
     * Выборка одной строки из таблицы
     * @param $sql - sql запрос
     * @param bool|false $close
     * @return bool
     * @throws \Exception
     */
    public function get_row($sql, $close = false)
    {
        $this->connect();

        $resQuery = $this->db_connect->query($sql);
        if(!$resQuery){
            throw new \Exception($this->db_connect->error);
        }

        if($resQuery->num_rows > 0)
        {
            $result = $resQuery->fetch_assoc();
            if($close){ $this->disconnect(); }
            return $result;
        }
        else{
            if($close){ $this->disconnect(); }
            return false;
        }

    }

    /**
     * Выборка нескольких строки из таблицы
     * @param $sql - sql запрос
     * @param bool|false $close
     * @return bool
     * @throws \Exception
     */
    public function get_rows($sql, $close = false)
    {
        $this->connect();

        $resQuery = $this->db_connect->query($sql);
        if(!$resQuery){
            throw new \Exception($this->db_connect->error);
        }

        if($resQuery->num_rows > 0)
        {
            $result = $resQuery->fetch_all(MYSQLI_ASSOC);
            if($close){ $this->disconnect(); }
            return $result;
        }
        else{
            if($close){ $this->disconnect(); }
            return false;
        }

    }

    public function duplicate_update($tableName, $arrValues, $close = false)
    {
        $this->connect();

        $cols = array_keys($arrValues);
        $forSql = [];
        foreach ($arrValues as $key => $value) {
            $forSql[] = $key."='".$value."'";
        }

        $sql = "INSERT INTO ".$tableName." (".implode(",", $cols).") VALUES ('".implode("','", $arrValues)."')
                ON DUPLICATE KEY UPDATE ".implode(",", $forSql);

        $resQuery = $this->db_connect->query($sql);
        if(!$resQuery){
            throw new \Exception($this->db_connect->error);
        }

        $insert_id = $this->db_connect->insert_id;

        if($close){
            $this->disconnect();
        }

        return $insert_id;
    }



    //update, delete, get_row, get_rows

}