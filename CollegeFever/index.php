<?php
session_start();
$_SESSION['ragamid'] = "RID1001";

?>
<html><body>
<form method="POST" action="sendPayment.php">
<input type="hidden" name="ProgramName" value="Main Event Registration">
<input type="submit" name="click">
</form>
</body></html>
