<?php
error_reporting(E_ALL);
$DB_HOST='';
$DB_DATABASE='';
$DB_USERNAME='';
$DB_PASSWORD='';
$DB_PORT='';


$index_file = "../m/ini.txt";

foreach(file($index_file) as $line) 
{
	if((strpos($line, 'DB_HOST') !== false)) $DB_HOST = trim(str_replace("DB_HOST=","",$line));
	else if((strpos($line, 'DB_DATABASE') !== false)) $DB_DATABASE =  trim(str_replace("DB_DATABASE=","",$line));
	else if((strpos($line, 'DB_USERNAME') !== false)) $DB_USERNAME =  trim(str_replace("DB_USERNAME=","",$line));
	else if((strpos($line, 'DB_PASSWORD') !== false)) $DB_PASSWORD =  trim(str_replace("DB_PASSWORD=","",$line));
	else if((strpos($line, 'DB_PORT') !== false)) $DB_PORT =  trim(str_replace("DB_PORT=","",$line));
}

$dbo            =   [
    'char'      =>  'utf8',
    'user'      =>  $DB_USERNAME,
    'pass'      =>  $DB_PASSWORD,
    'host'      =>  $DB_HOST,
    'port'      =>  $DB_PORT,
    'dbna'      =>  $DB_DATABASE
];
 

list(
    'char'      =>  $char,
    'user'      =>  $user,
    'pass'      =>  $pass,
    'host'      =>  $host,
    'port'      =>  $port,
    'dbna'      =>  $dbna
) = $dbo;
 
$opts           =   [
    PDO::ATTR_ERRMODE               =>  PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_TIMEOUT               =>  60,
    PDO::ATTR_EMULATE_PREPARES      =>  false,
    PDO::ATTR_DEFAULT_FETCH_MODE    =>  PDO::FETCH_OBJ
];
 

$dsn = "mysql:host=$host;port=$port;dbname=$dbna;charset=$char";
 
try
{
    $pdo         =   new \PDO( $dsn, $user, $pass );
 
    if ( isset( $opts ) && ! empty( $opts ) )
    {
        foreach ( $opts as $k => $v )
        {
            $pdo->setAttribute( $k, $v );
        }
    }
}
catch ( \PDOException $e )
{
    echo "Error: " . $e->getMessage();
	exit;
}
 
if ($pdo)
{
   //echo 'DB Connected.<br />';
}
else
{
    echo 'DB Connection Error!';
}

?>