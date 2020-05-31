<?php 

    namespace MF\Model;

    use App\Connection;
    use App\Models\Usuario;
    use App\Models\Twitt;

    class Container {

        public static function getModel($model) {

            $class = 'App\\Models\\' .  ucfirst($model);

            $conn = Connection::getDb();

            $obj = new $class($conn);

            return $obj;
        }
    }

?>