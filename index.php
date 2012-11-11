<?php

include 'config/db.php';

mysql_connect($hostname_DB,$username_DB,$password_DB);
@mysql_select_db($database_DB) or die( "Unable to select database");

if (!empty($_POST) && !empty($_REQUEST['name']) && !empty($_REQUEST['comment'])) {
  $query = sprintf("INSERT INTO comments (name,comment) VALUES('%s', '%s')", mysql_escape_string($_REQUEST['name']), mysql_escape_string($_REQUEST['comment']));
  $result=mysql_query($query);
}

$query="SELECT * FROM comments";
$result=mysql_query($query);
$num=mysql_numrows($result);

mysql_close();

$ipaddr_for_hostname = 'socket';

if(!preg_match('/^:/', $hostname_DB)) {
  $ipaddr_for_hostname = gethostbyname($hostname_DB);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
   
<!-- # Copyright 2010 RightScale, Inc. All rights reserved.  -->

   
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Simple DB Read/Write</title>
  <style>
    label {
      vertical-align: top;
      width: 100px;
    }

    #id, textarea {
      width: 250px;
    }
  </style>
</head>

<body>
<div class="code_container">
<div class="code">

<H1>Database Connection Test</H1>

<?php echo "<b><center> Database($database_DB) Output From Host($hostname_DB:$ipaddr_for_hostname)</center></b><br><br>"; ?>

<form method="POST">
  <fieldset>
    <label>Name</label>
    <input type="text" name="name" id="name" />
    </br>

    <label>Comment</label>
    <textarea rows="5" cols="10" id="comment" name="comment"></textarea>
    </br>

    <input type="submit" value="Submit" />
  </fieldset>
</form>

<table>
  <thead>
    <tr>
      <td>ID</td>
      <td>Name</td>
      <td>Comment</td>
      <td>Created At</td>
    </tr>
  </thead>
  <tbody>
<?php

$i=0;
while ($i < $num) {

  $id=mysql_result($result,$i,"id");
  $name=mysql_result($result,$i,"name");
  $comment=mysql_result($result,$i,"comment");
  $created_at=mysql_result($result,$i,"created_at");

  print <<<EOF
    <tr>
      <td>$id</td>
      <td>$name</td>
      <td>$comment</td>
      <td>$created_at</td>
    </tr>
EOF;


  $i++;
}

?>
  </tbody>
</table>

</div>
</div>

</body>
</html>
