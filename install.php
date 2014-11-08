<?php
include_once(__DIR__ . '/config.php');
include_once(__DIR__ . '/lib/compatibility.php');

function getConnectionString($dbtype, $dbhost, $dbname) {
    if ($dbhost == 'localhost') $dbhost = '127.0.0.1';
    if ($dbtype == 'MySQL') return "mysql:host=$dbhost;dbname=$dbname";
    return "sqlite:db.sqlite3";
}

function testConnection($dbtype, $dbhost, $dbname, $dbuser, $dbpassword) {
    $dbh = new PDO(
        getConnectionString($dbtype, $dbhost, $dbname),
        $dbuser, $dbpassword);
    $dbh = null;
}

function initDatabase($dbtype, $dbhost, $dbname, $dbuser, $dbpassword) {
    if ($dbtype == 'SqLite') fwrite(__DIR__ . '/db.sqlite3', 'w');
    $dbh = new PDO(
        getConnectionString($dbtype, $dbhost, $dbname),
        $dbuser, $dbpassword);
    $dbh->query("drop table if exists users");
    $dbh->query("CREATE TABLE Users (
        username VARCHAR(255) NOT NULL,
        password_hash CHAR(32) NOT NULL,
        folder VARCHAR(255),
        admin TINYINT(1) NOT NULL DEFAULT 0);");
    return $dbh;
}

function createAdmin($connection, $username, $password) {
    $connection->query(
        "INSERT INTO Users
        (username, password_hash, folder, admin) 
        VALUES ('$username', '$password', '', 1);");
    $connection = null;
}

function createIni($connectionstring, $dbusername, $dbpassword) {
    if (!file_put_contents(
        __DIR__ . '/config.ini',
        "connectionstring = $connectionstring\n
        dbusername = $dbusername\n
        dbpassword = $dbpassword"))
        throw new Exception("Failed writing config.ini file");
}

function getoHomePage() {
    header('location: ' . $_GLOBALS['root_uri'] . 'login.php');
}

function getState($args) {
    /* state 0: insert db type
     * state 1: insert db name and credentials
     * state 2: insert admin user */
    $error = '';
    if (isset($args['username'])) {
        // Check if two password match
        if ($args['password'] != $args['passconf']) {
            $state = 2;
            $error = "Passwords do not match!";
        } else {
            try {
                $conn = (initDatabase(
                    $args['database'],
                    $args['dbhost'],
                    $args['dbname'],
                    $args['dbuser'],
                    $args['dbpassword']));
                createAdmin($conn, $args['username'], $args['password']);
                createIni(
                    getConnectionString(
                        $args['database'],
                        $args['dbhost'],
                        $args['dbname']),
                    $args['dbuser'],
                    $args['dbpassword']);
                $state = 3;
            } catch (Exception $e) {
                $state = 0;
                $error = $e->getMessage();
            }
        }
    } else if (isset($args['dbname'])) {
        try {
            testConnection(
                $args['database'],
                $args['dbhost'],
                $args['dbname'],
                $args['dbuser'],
                $args['dbpassword']);
            $state = 2;
        } catch (Exception $e) {
            $state = 1;
            $error = $e->getMessage();
        }
    } else if (isset($args['database'])) {
        $db = $args['database'];
        if ($db == 'MySQL') $state = 1;
        else if ($db == 'SqLite') {
            $state = 2;
        } else {
            $state = 0;
            $error = 'Invalid database type!';
        }
    } else $state = 0;
    return array(
        'state' => $state,
        'error' => $error,
        'params' => $args
    );
}

function errorDiv($error) {
    if ($error != '') return "<div class='alert alert-danger'>$error</div>";
    return '';
}


// Run this script only if connection string is empty
$ini_file = parse_ini_file('config.ini');
if (array_key_exists('database', $ini_file)) {
    header('location: ' . $GLOBALS['root_uri']);
} else {
    $state = getState($_POST);
    $error = errorDiv($state['error']);
    $args = $state['params'];
    $nstate = $state['state'];
    if ($nstate == 3) {
        header('location: ' . $GLOBALS['root_uri']);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<!-- JQuery -->
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="css/style.css" />
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" 
href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js">
</script>
</head>
<body class="main-body">
<div class="container">
  <div class="page-header">
      <h1>Media Library <small>just a media library...</small></h1>
  </div>
  <div class="panel panel-default">
    <div class=panel-body>
      <form method=POST>
<?php
switch($nstate) {
case 0:
    echo "
        <h2>Chose database type</h2>
        <select name=database class=form-control>
        <option value=MySQL>MySQL</option>
        <option value=SqLite>SqLite</option>
        </select>
        $error
        <button class='btn btn-default'>Next</button>
        ";
    break;
case 1:
    echo "
        <h2>Database type</h2>
        <input type=hidden name=database value=".$args['database'].">
        <input type=text value='".$args['database']."'
        class=form-control disabled>
        <h2>Database host</h2>
        <input type=text placeholder='Host' class=form-control
        name=dbhost value=localhost>
        <h2>Database name</h2>
        <input type=text placeholder='Database name' class=form-control
        name=dbname>
        <h2>Database credentials</h2>
        <input type=text placeholder='Database username' class=form-control
        name=dbuser>
        <input type=password placeholder='Password' class=form-control
        name=dbpassword>
        $error
        <button class='btn btn-default'>Next</button>
        ";
    break;
case 2:
    echo "
        <h2>Admin name</h2>
        <input type=hidden name=database value=".$args['database'].">
        <input type=hidden name=dbname value=".$args['dbname'].">
        <input type=hidden name=dbuser value=".$args['dbuser'].">
        <input type=hidden name=dbhost value=".$args['dbhost'].">
        <input type=hidden name=dbpassword value=".$args['dbpassword'].">
        <input type=text placeholder=Username name=username class=form-control>
        <h2>Password</h2>
        <input type=password placeholder=Password name=password
        class=form-control>
        <input type=password placeholder='Confirm password'
        name=passconf class=form-control>
        $error
        <button class='btn btn-default'>Next</button>
        ";
    break;    
}
?>
      </form>
    </div>
  </div>
</div>
</body>
