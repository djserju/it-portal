<?php
# Database class handles creating and returning a single PDO connection to the MySQL database.
class Database {
    # Private properties to store database credentials loaded from config.php
    private string $host;
    private string $dbName;
    private string $username;
    private string $password;
    private ?PDO $pdo = null; # Holds the active PDO instance once connected
    
    # Constructor initializes connection details from global constants
    public function __construct() {
        $this->host = DB_HOST;
        $this->dbName = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;
    }
    
    # Creates and returns a PDO database connection with exceptions enabled.
    # Reuses the existing connection if already established.
    public function getConnection(): PDO {
        if ($this->pdo === null) {
            # Data source name specifying driver, host and database name
            $dsn = "mysql:host={$this->host};dbname={$this->dbName}";
        
            # Configures PDO to throw exceptions on errors and returns associative arrays
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false, # Enforces true prepared statements
            ];
        
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        }
    
        return $this->pdo;
        
    }
}