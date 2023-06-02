<?php

class DBResult{
    private string $hostname;
    private string $password;
    private string $username;
    private string $database;

    private string $dbConnPath = SITE_DIR . "init/dbconn.php";
    private string $dbFuncCheckKeys = SITE_DIR . "func/checkKeysInArr.php";

    public mysqli_result $result;

    function __construct()
    {
        if (file_exists($this->dbFuncCheckKeys)){
            require $this->dbFuncCheckKeys;
        } else {
            echo "Class DBResult - Ошибка: Отсутствует файл " . $this->dbFuncCheckKeys;
        }

        if (file_exists($this->dbConnPath)){
            require $this->dbConnPath;
        } else {
            echo "Class DBResult - Ошибка: Отсутствует файл " . $this->dbConnPath;
        }

        $needleKeys = [
            'hostname',
            'username',
            'password',
            'database',
        ];

        if (!$dbConnData or checkKeysInArr($dbConnData, $needleKeys)){
            echo "Class DBResult - Ошибка: Файл " . $this->dbConnPath . " отсутствует или поврежден";
        } else {
            $this->hostname = $dbConnData['hostname'];
            $this->username = $dbConnData['username'];
            $this->password = $dbConnData['password'];
            $this->database = $dbConnData['database'];
        }
    }

    private function mysqliConn()
    {
        return mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
    }

    public function GetList(array $params)
    {
        $mysqli = $this->mysqliConn();

        //обязательные

        $select = $params['select'];
        $from = $params['from'];

        //необязательные

        $where = $params['where'];
        $groupBy = $params['groupBy'];
        $having = $params['having'];
        $orderBy = $params['orderBy'];

        $resultMode = $params['RESULT_MODE'];

        if ($select == "*") $query = "SELECT " . $select . " FROM `" . $from . "`";
        else $query = "SELECT `" . $select . "` FROM `" . $from . "`";

        if ($where)
            $query=+" WHERE `" . $where . "`";
        if ($groupBy)
            $query=+" GROUP BY `" . $groupBy . "`";
        if ($having)
            $query=+" HAVING `" . $having . "`";
        if ($orderBy)
            $query=+" ORDER BY `" . $orderBy . "`";

        $query = mysqli_real_escape_string($mysqli, $query);
        $this->result = mysqli_query($mysqli, $query, $resultMode);

        return $this->result;
        //return $query;
    }

    public function Fetch(string $fetch = "all")
    {
        switch ($fetch){
            case "all":
                mysqli_fetch_all($this->result);
                break;

            case "array":
                mysqli_fetch_array($this->result);
                break;

            case "assoc":
                mysqli_fetch_assoc($this->result);
                break;

            case "row":
                mysqli_fetch_row($this->result);
                break;
        }
    }
}

/*
            SELECT ('столбцы или * для выбора всех столбцов; обязательно')
            FROM ('таблица; обязательно')
            WHERE ('условие/фильтрация, например, city = 'Moscow'; необязательно')
            GROUP BY ('столбец, по которому хотим сгруппировать данные; необязательно')
            HAVING ('условие/фильтрация на уровне сгруппированных данных; необязательно')
            ORDER BY ('столбец, по которому хотим отсортировать вывод; необязательно')
 */