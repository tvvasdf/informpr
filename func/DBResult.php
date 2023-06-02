<?php

class DBResult{
    private string $hostname;
    private string $password;
    private string $username;
    private string $database;

    public mysqli_result $result;

    private string $dbConnPath = SITE_DIR . "init/dbconn.php";
    function __construct()
    {
        if (file_exists($this->dbConnPath)){
            require $this->dbConnPath;
        } else {
            echo "Ошибка: Отсутствует файл " . $this->dbConnPath;
        }

        if (!$dbConnData or !$this->checkDBConnData($dbConnData)){
            echo "Ошибка: Файл " . $this->dbConnPath . " отсутствует или поврежден";
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
/*
 * mysqli_result::fetch_all — Выбирает все строки из результирующего набора и помещает их в ассоциативный массив, обычный массив или в оба
mysqli_result::fetch_array — Выбирает следующую строку из набора результатов и помещает её в ассоциативный массив, обычный массив или в оба
mysqli_result::fetch_assoc — Выбирает следующую строку из набора результатов и помещает её в ассоциативный массив
mysqli_result::fetch_column — Получает один столбец из следующей строки набора результатов
mysqli_result::fetch_field_direct — Получение метаданных конкретного поля
mysqli_result::fetch_field — Возвращает следующее поле результирующего набора
mysqli_result::fetch_fields — Возвращает массив объектов, представляющих поля результирующего набора
mysqli_result::fetch_object — Выбирает следующую строку из набора результатов в виде объекта
mysqli_result::fetch_row
 */
    private function checkDBConnData(array $array):bool
    {
        $needleArrKeys = [
            "hostname",
            "password",
            "username",
            "database",
        ];
        foreach ($needleArrKeys as $key){
            if (!array_key_exists($key, $array)) return false;
        }

        return true;
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