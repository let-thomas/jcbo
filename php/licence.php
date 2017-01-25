<!DOCTYPE head PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>1JCBO - Přehled licenčních známek</title>
 <meta charset="UTF-8">
</head>
<body>
<form action="licence.php" method="post" >
<select name="licence">
<option value="err_date" <?= $_POST["licence"]=="err_date" ? "selected" :"" ?>>spatne datum, jmeno,...</option>
<option value="neni" <?= $_POST["licence"]=="neni" ? "selected" :"" ?>>nema licencku</option>
<option value="ok" <?= $_POST["licence"]=="ok" ? "selected" :"" ?>>ma licencku</option>
</select>
<select name="kat">
<option value="all" <?= $_POST["kat"]=="all" ? "selected" :"" ?>>vsichni</option>
<option value="U11" <?= $_POST["kat"]=="U11" ? "selected" :"" ?>>nejmladsi</option>
<option value="U13" <?= $_POST["kat"]=="U13" ? "selected" :"" ?>>U13 - mladsi zaci</option>
<option value="U15" <?= $_POST["kat"]=="U15" ? "selected" :"" ?>>U15 - starsi zaci</option>
<!-- option>U18 - dorci</option> -->
<option value="starsi" <?= $_POST["kat"]=="starsi" ? "selected" :"" ?>>starsi</option>
</select>
<button type="submit">go</button>
</form>
<?php
include 'dbc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	echo "inparam: " . $_POST["kat"] . "<br/>\n";
	switch ($_POST["kat"])
	{
		case "all":
			$kat_from=123;
			$kat_to=0;
			break;
		case "U11":
			$kat_from=10;
			$kat_to=0;
			break;
		case "U13":
			$kat_from=12;
			$kat_to=11;
			break;
		case "U15":
			$kat_from=14;
			$kat_to=13;
			break;
		case "starsi":
			$kat_from=123;
			$kat_to=15;
			break;
	}
	$lic = "";
	switch ($_POST["licence"])
	{
		case "ok":
			$lic = " and status='A' and csjuid is not null";
			break;
		case "neni":
			$lic = " and status<>'A' and csjuid is not null";
			break;
		case "err_date":
			$lic = " and csjuid is null";
			break;
	}
$query="select * from judoka  where year(narozen) between (year(curdate())-".$kat_from.") and (year(curdate())-".$kat_to.") ".$lic." order by prijmeni, jmeno";
echo "<!-- ".$query." -->\n";

$result_res = $SQL->query($query) or die("Query failed: " . $SQL->error);
?>
<table>
<tr>
<th>Jmeno</th>
<th>Prijmeni</th>
<th>CSJUid</th>
<th>Status</th>
<th>link</th>
</tr>
<?php 
while ($row = $result_res->fetch_array()) {
	echo "<tr><td>" . $row["jmeno"]. "</td><td>" . $row["prijmeni"] . "</td><td>".$row["csjuid"]."</td><td>".$row["status"];
	#https://evidence.czechjudo.org/EasyUserDetail.aspx?id=46925
	echo "<td>";
	if ($row["csjuid"]) echo"<a href='https://evidence.czechjudo.org/EasyUserDetail.aspx?id=".$row["csjuid"]."' target='_blank'>Evid karta</a>";
	echo "</td><tr>\n";
}

}
$$result_res->close();
$SQL->close();
?>
</table>
</body>
</html>
