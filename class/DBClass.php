<?php
class DB{

    private static $pdo;

    private static string $dbConnPath = SITE_DIR . "/init/include/dbconn.php";
    private static string $dbFuncCheckKeys = SITE_DIR . "/func/checkKeysInArr.php";

    //PDOStatement or bool
    public static $result;

    private static function AuthorizeDB()
    {
        if (file_exists(self::$dbFuncCheckKeys)){
            require_once self::$dbFuncCheckKeys;
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
            $dsn = "mysql:dbname=" . $dbConnData['database'] . ";host=" . $dbConnData['hostname'];
            $user = $dbConnData['username'];
            $password = $dbConnData['password'];
            self::$pdo = new PDO($dsn, $user, $password);

            if (!self::$pdo){
                return false;
            }
            return true;
        }
    }

    private static function SendQuery(string $query)
    {
        self::$result = self::$pdo->query($query);

        if (is_bool(self::$result)){
            echo $query;
            return self::$pdo->errorInfo();
        } else {
            return self::$result;
        }
    }

    public static function GetList(array $params, string $fromTable)
    {
        if (!self::AuthorizeDB()){
            return false;
        }
        //обязательные

        $select = $params['select'];
        $from = $fromTable;

        //необязательные

        $where = $params['where'];
        $groupBy = $params['groupBy'];
        $having = $params['having'];
        $orderBy = $params['orderBy'];

        if ($select == "*") $query = "SELECT " . $select . " FROM `" . $from . "`";
        else $query = "SELECT `" . $select . "` FROM `" . $from . "`";


        if (is_array($where['cond1']) and count($where) > 1){
            $where = array_unique($where, SORT_REGULAR);
            $query = $query . " WHERE (";
            foreach ($where as $cond){
                $query = $query . "`" . $cond['field'] . "`" . $cond['cond'] . $cond['value'];
                if ($cond != end($where)){
                    if (!$cond['nextCond']) $cond['nextCond'] = "AND";
                    $query = $query . " " . $cond['nextCond'] . " ";
                } else {
                    $query = $query . ")";
                }
            }

        } else {
            $query = $query . " WHERE `" . $where['field'] . "` " . $where['cond'] . $where['value'];
        }


        if ($groupBy)
            $query = $query . " GROUP BY `" . $groupBy . "`";
        if ($having)
            $query = $query . " HAVING `" . $having . "`";
        if ($orderBy)
            $query = $query . " ORDER BY `" . $orderBy . "`";

        return self::SendQuery($query);
        //return $query;
    }

    public static function AddItem(array $params, string $fromTable, array $needle)
    {
        if (!self::AuthorizeDB() or !checkKeysInArr($params, $needle)){
            return false;
        }

        foreach ($params as $key => $value){
            $listKeys[] = "`" . $key . "`";

            if (!$value){
                return false;
            }

            if (is_bool($value) and $value){
                $listVals[] = 1;
            } elseif (is_bool($value) and !$value){
                $listVals[] = 0;
            } elseif (is_numeric($value)){
                $listVals[] = $value;
            } else {
                $listVals[] = "'" . $value . "'";
            }
        }
        $query = "INSERT INTO `" . $fromTable . "`(" . implode(", ", $listKeys) . ") VALUES (" . implode(", ", $listVals) . ");";

        return self::SendQuery($query);
        //return $query;
    }

    public static function DeleteItem(array $params, string $fromTable, array $needle = ["where"])
    {
        if (!self::AuthorizeDB() or !checkKeysInArr($params, $needle)){
            return false;
        }
        //обязательные
        $where = $params['where'];

        $query = "DELETE FROM `" . $fromTable . "` WHERE ";

        if (is_array($where['cond1']) and count($where) > 1){
            $where = array_unique($where, SORT_REGULAR);
            $query = $query . "(";
            foreach ($where as $cond){
                $query = $query . "`" . $cond['field'] . "`" . $cond['cond'] . $cond['value'];
                if ($cond != end($where)){
                    if (!$cond['nextCond']) $cond['nextCond'] = "AND";
                    $query = $query . " " . $cond['nextCond'] . " ";
                } else {
                    $query = $query . ")";
                }
            }

        } elseif (is_array($where)) {
            $query = $query . "`" . $where['field'] . "` " . $where['cond'] . $where['value'];
        } else {
            return false;
        }

        return self::SendQuery($query);
        //return $query;
    }

    public static function UpdateItem(array $params, string $fromTable, array $needle = ["update", "where"])
    {
        if (!self::AuthorizeDB() or !checkKeysInArr($params, $needle)){
            return false;
        }
        $query = "UPDATE `" . $fromTable . "` SET ";
        $update = $params['update'];
        $where = $params['where'];
        foreach ($update as $key => $value){
            $query = $query . "`" . $key . "`=" . $value;
            if ($value != end($params['update'])) {
                $query = $query . ", ";
            }
        }

        return self::SendQuery($query);
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