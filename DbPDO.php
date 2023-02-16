<?php

class DbPDO
{
    private static string $server = 'localhost';
    private static string $username = 'root';
    private static string $password = '';
    private static string $database = 'workbrench';
    private static ?PDO $db = null;

    public static function connect(): ?PDO {
        if (self::$db == null){
            try {
                self::$db = new PDO("mysql:host=".self::$server.";dbname=".self::$database, self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Vous êtes connecté à la base de donné";
            }
            catch (PDOException $e) {
                echo "Erreur de la connexion à la dn : " . $e->getMessage();
                die();
            }
        }
        return self::$db;
    }
    
    public static function showInfo() {
//        $request = self::$db->prepare(
//    'SELECT username FROM user
//           UNION
//           SELECT username FROM client
//           UNION SELECT username FROM admin');

        $request = self::$db->prepare(
            'SELECT username FROM user
           UNION ALL
           SELECT username FROM client
           UNION ALL SELECT username FROM admin');

        $check = $request->execute();
        if ($check){
            echo "<pre>";
            print_r($request->fetchAll());
            echo "</pre>";
        }
        else{
            echo 'Un problème est survenu';
        }
    }
}