    <?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'labtif_movie');
    class Database
    {
        public $mysqli;

        function __construct()
        {
            $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($this->mysqli->connect_errno) {
                echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
            }
        }

        function select($table, $where = null)
        {
            $sql = "SELECT * FROM $table";

            if ($where != null) {
                // $sql .= " WHERE $where";
                foreach ($where as $key => $value) {
                    $sql .= " WHERE $key = '$value'";
                }
            }

            $result = $this->mysqli->query($sql);

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function insert($table, $rows)
        {
            $row = null;
            $value = null;
            //INSERT INTO table_name (name, genre, desc,cover)
            //VALUES (value1, value2, value3, ...);
            foreach ($rows as $key => $nilai) {
                $row .= "," . $key;
                $value .= ",'" . $nilai . "'";
            }

            $sql = "INSERT INTO $table (" . substr($row, 1) . ") VALUES (" . substr($value, 1) . ")";

            $query = $this->mysqli->prepare($sql);
            $query->execute() or die($this->mysqli->error);
        }

        public function delete($table){
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "DELETE FROM $table WHERE id=$id";

                $query = $this->mysqli->prepare($sql) or die($this->mysqli->error);
                $query->execute();
            }
        }

        function update($table, $field, $where)
        {
            // $sql = "UPDATE $table SET ";
            $set = null;
            $setWhere = null;
//             UPDATE Customers
//             SET title = 'tlou', genre= 'horror', 
//             WHERE id = '1';

            foreach ($field as $key => $value) {
                $set .= ", " . $key . " = '" . $value . "'";
            }
            foreach ($where as $key => $value) {
                $setWhere = $key . "='" . $value . "'";
            }
            $sql = "UPDATE $table SET". substr($set, 1) . "WHERE $setWhere";

            $query = $this->mysqli->prepare($sql) or die($this->mysqli->error);
            $query->execute();

        }

        function __destruct()
        {
            $this->mysqli->close();
        }
    }
