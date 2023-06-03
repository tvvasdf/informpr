<?php

class DB{

    private static string $username;
    private static string $password;
    private static string $database;
    private static string $hostname;


    private static string $dbConnPath = SITE_DIR . "init/dbconn.php";
    private static string $dbFuncCheckKeys = SITE_DIR . "func/checkKeysInArr.php";

    public static mysqli_result $result;

    private static function AuthorizeDB()
    {
        if (file_exists(self::$dbFuncCheckKeys)){
            require self::$dbFuncCheckKeys;
        } else {
            echo "Class DBResult - Ошибка: Отсутствует файл " . self::$dbFuncCheckKeys;
        }

        if (file_exists(self::$dbConnPath)){
            require self::$dbConnPath;
        } else {
            echo "Class DBResult - Ошибка: Отсутствует файл " . self::$dbConnPath;
        }

        $needleKeys = [
            'hostname',
            'username',
            'password',
            'database',
        ];

        if (!$dbConnData or !checkKeysInArr($dbConnData, $needleKeys)){
            echo "Class DBResult - Ошибка: Файл " . self::$dbConnPath . " отсутствует или поврежден";
            return false;
        } else {
            self::$hostname = $dbConnData['hostname'];
            self::$username = $dbConnData['username'];
            self::$password = $dbConnData['password'];
            self::$database = $dbConnData['database'];
            return true;
        }
    }

    public static function GetList(array $params)
    {
        if (!self::AuthorizeDB()){
            return false;
        }

        $mysqli = mysqli_connect(self::$hostname, self::$username, self::$password, self::$database);

        if (!$mysqli){
            return false;
        }
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
        self::$result = mysqli_query($mysqli, $query, $resultMode);
        return self::$result;
        //return $query;
    }

    public static function Fetch(string $fetch = "all")
    {
        switch ($fetch){
            case "all":
                mysqli_fetch_all(self::$result);
                break;

            case "array":
                mysqli_fetch_array(self::$result);
                break;

            case "assoc":
                mysqli_fetch_assoc(self::$result);
                break;

            case "row":
                mysqli_fetch_row(self::$result);
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