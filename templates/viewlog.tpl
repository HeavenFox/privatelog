<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Admin Logs</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="stylesheets/viewlog.css" type="text/css" />
<script type="text/javascript">
function confirmClick()
{
    return confirm("Do you really want to do this? \n It is NOT recoverable!");
}
</script>
</head>
<body>
<h1>ADMIN LOGS</h1>
<h2>ADMINISTRATION LOGS</h2>
<table cellspacing="0">
    <thead>
        <tr><td>ID</td><td>Action</td><td>Post</td><td>IP</td><td>Time</td></tr>
    </thead>
    <tbody>
        <?php
        $db = Database::Get();
        $db->query("SELECT * FROM `pl_adminlog`");
        while ($r = $db->fetch('num'))
        {
            echo "<tr><td>{$r[0]}</td><td>{$r[1]}</td><td>{$r[2]}</td><td><a href='http://wq.apnic.net/apnic-bin/whois.pl?searchtext={$r[3]}'>{$r[3]}</a></td><td>".date('r',$r[4])."</td></tr>";
        }
        ?>
    </tbody>
</table>
<a href="index.php?act=viewlog&do=clear&what=admin" onclick="return confirmClick()">Clear</a>
<h2>LOGIN ATTEMPTS</h2>
<table cellspacing="0">
    <thead>
        <tr><td>ID</td><td>Username</td><td>Password</td><td>IP</td><td>Time</td></tr>
    </thead>
    <tbody>
        <?php
        $db = Database::Get();
        $db->query("SELECT * FROM `pl_loginattempt`");
        while ($r = $db->fetch('num'))
        {
            echo "<tr><td>{$r[0]}</td><td>{$r[1]}</td><td>{$r[2]}</td><td><a href='http://wq.apnic.net/apnic-bin/whois.pl?searchtext={$r[3]}'>{$r[3]}</a></td><td>".date('r',$r[4])."</td></tr>";
        }
        ?>
    </tbody>
</table>
<a href="index.php?act=viewlog&do=clear&what=attempt" onclick="return confirmClick()">Clear</a>
<div id="nav"><a href="index.php">BACK TO HOMEPAGE</a></div>
</body>
</html>
