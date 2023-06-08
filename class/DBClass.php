<?php
class DB{

    private static $pdo;
    private static string $dbName;

    private static string $dbConnPath = SITE_DIR . "/init/include/dbconn.php";
    private static string $dbFuncCheckKeys = SITE_DIR . "/func/checkKeysInArr.php";

    //PDOStatement or bool
    public static $result;

    private static function AuthorizeDB()
    {
        if (file_exists(self::$dbFuncCheckKeys)){
            require_once self::$dbFuncCheckKeys;
        } else {
            throw new Exception("Class DBResult - Ошибка: Отсутствует файл " . self::$dbFuncCheckKeys);
        }

        if (file_exists(self::$dbConnPath)){
            require self::$dbConnPath;
        } else {
            throw new Exception("Class DBResult - Ошибка: Отсутствует файл " . self::$dbConnPath);
        }

        $needleKeys = [
            'hostname',
            'username',
            'password',
            'database',
        ];

        if (!$dbConnData or !checkKeysInArr($dbConnData, $needleKeys)){
            throw new Exception("Class DBResult - Ошибка: Файл " . self::$dbConnPath . " отсутствует или поврежден");
        } else {
            $dsn = "mysql:dbname=" . $dbConnData['database'] . ";host=" . $dbConnData['hostname'];
            $user = $dbConnData['username'];
            $password = $dbConnData['password'];
            self::$pdo = new PDO($dsn, $user, $password);

            if (!self::$pdo){
                throw new Exception(implode(",", self::$pdo->errorInfo()));
            }
            self::$dbName = $dbConnData['database'];
            return true;
        }
    }

    private static function SendQuery(string $query)
    {
        self::$result = self::$pdo->query($query);

        if (is_bool(self::$result)){
            throw new Exception("Ошибка: " . implode("; ", self::$pdo->errorInfo()) . "<br>Запрос: " . $query);
        } else {
            return self::$result;
        }
    }

    public static function GetList(array $params, string $fromTable)
    {
        try {
            self::AuthorizeDB();
        } catch(Exception $e) {
            echo $e->getMessage();
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

        } elseif ($where) {
            $query = $query . " WHERE `" . $where['field'] . "` " . $where['cond'] . $where['value'];
        }


        if ($groupBy)
            $query = $query . " GROUP BY `" . $groupBy . "`";
        if ($having)
            $query = $query . " HAVING `" . $having . "`";
        if ($orderBy)
            $query = $query . " ORDER BY `" . $orderBy . "`";

        try {
            return self::SendQuery($query);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public static function AddItem(array $params, string $fromTable, array $needle)
    {
        try {
            self::AuthorizeDB();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        if (!checkKeysInArr($params, $needle)){
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

        try {
            return self::SendQuery($query);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public static function DeleteItem(array $params, string $fromTable, array $needle = ["where"])
    {
        try {
            self::AuthorizeDB();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        if (!checkKeysInArr($params, $needle)){
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

        try {
            return self::SendQuery($query);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public static function UpdateItem(array $params, string $fromTable, array $needle = ["update", "where"])
    {
        try {
            self::AuthorizeDB();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        if (!checkKeysInArr($params, $needle)){
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

        try {
            return self::SendQuery($query);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public static function CreateTable(array $params, array $needle = ["table_name", "rows"])
    {
        /**
         *        $params = [
         *            'table_name' => "name",
         *            'rows' => [
         *                0 => [
         *                    'name' => "rowName",
         *                    'type' => "INT",
         *                    'attributes' => [
         *                        0 => "NOT_NULL",
         *                        1 => "NOT_NULL",
         *                        ]
         *                    ]
         *                ],
         *            'table_attributes' => [
         *                0 => 'ATTR',
         *                1 => 'ATTR',
         *                ],
         *            ];
         **/

        try {
            self::AuthorizeDB();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        if (!checkKeysInArr($params, $needle)){
            return false;
        }

        $query = "CREATE TABLE `" . $params['table_name'] . "` (";

        if (is_array($params['rows']) and !$params['rows']['name']){
            foreach ($params['rows'] as $key => $row){
                if (is_array($params['rows'][$key]['attributes'])){
                    $params['rows'][$key]['attributes'] = implode (" ",$row['attributes']);
                    $params['rows'][$key]['name'] = '`' . $row['name'] . '`';
                }
                $params['rows'][$key] = implode (" ", $params['rows'][$key]);
            }
            $query = $query . implode (", ", $params['rows']);
        } else {
            $query = $query . '`' . $params['rows']['name'] . '` ' . $params['rows']['type'];
            if (is_array($params['rows']['attributes'])){
                $query = $query . ' ' . implode (" ", $params['rows']['attributes']);
            } else {
                $query = $query . ' ' . $params['rows']['attributes'];
            }
        }

        if (is_array($params['table_attributes'])){
            $query = $query . ", " . implode (" ", $params['table_attributes']) . ");";
        } else {
            if ($params['table_attributes']){
                $query = $query . ", " . $params['table_attributes'] . ");";
            } else {
                $query = $query . ");";
            }

        }

        try {
            return self::SendQuery($query);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public static function DeleteTable($tableName, $ifExists = true)
    {
        try {
            self::AuthorizeDB();
        } catch(Exception $e) {
            echo $e->getMessage();
        }

        $query = "DROP TABLE ";
        if ($ifExists){
            $query = $query . "IF EXISTS ";
        }

        if (is_array($tableName)){
            $query = $query . "`" . implode("`, `", $tableName) . "`;";
        } else {
            $query = $query . "`" .$tableName . "`;";
        }

        try {
            return self::SendQuery($query);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public static function ShowTables(string $tableName = "")
    {
        try {
            self::AuthorizeDB();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
        $query = "SHOW TABLES FROM " . self::$dbName . " LIKE '" . $tableName . "';";

        try {
            return self::SendQuery($query)->rowCount();
        } catch (Exception $e){
            echo $e->getMessage();
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