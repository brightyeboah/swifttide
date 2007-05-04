<?
//*
// admin_speak.php
// Admin Section
// Display and Manage Speaking Hours Table
//*
//Version 1 2007-04-26 Helmut
//Check if admin is logged in
session_start();
if(!session_is_registered('UserId') || $_SESSION['UserType'] != "A")
  {
    header ("Location: index.php?action=notauth");
	exit;
}


//Include global functions
include_once "common.php";
//Initiate database functions
include_once "ez_sql.php";
//Include paging class
include_once "ez_results.php";
// config
include_once "configuration.php";

//Get current year
$cyear=$_SESSION['CurrentYear'];
$year=$db->get_var("SELECT school_years_desc FROM school_years WHERE school_years_id=$cyear");

//Get list of school names
$sSQL="SELECT * FROM school_names ORDER BY school_names_id";
$schoolnames=$db->get_results($sSQL);
//get list of days
$sSQL="SELECT * FROM tbl_days ORDER BY days_id";
$days=$db->get_results($sSQL);
//get list of teachers
$sSQL="SELECT * FROM teachers ORDER BY teachers_id";
$teachers=$db->get_results($sSQL);

//Check what we have to do
$action=get_param("action");
$id=get_param("id");
$teacherid=get_param("teacherid");
$day=get_param("day");
$period=get_param("period");

if (!strlen($action))
	$action="none";
//Add or Remove speaking hours according to admin choice
switch ($action){
	case "remove":
		$sSQL="DELETE FROM speak WHERE speak_id='$id'";
		$db->query($sSQL);
		break;
	case "add":
		//Check for duplicates
		$sSQL="SELECT COUNT(*) FROM speak WHERE speak_teacherid='$teacherid'";
		$tot=$db->get_var($sSQL);
		if($tot>0){
			$msgFormErr=_ADMIN_SPEAK_DUP;
			}else{
		$sSQL="INSERT INTO speak (speak_teacherid, speak_day, speak_period) 
		VALUES ('$teacherid', '$day', '$period')"; 
		$db->query($sSQL);
		};
		break;
	case "edit":
		$sSQL="SELECT COUNT(*) FROM speak WHERE speak_teacherid='$teacherid'";
		$tot=$db->get_var($sSQL);
		if($tot>0){
			$msgFormErr=_ADMIN_SPEAK_DUP;
			}else{
		$sSQL="SELECT * FROM speak WHERE speak_id='$id'";
		$editspeak = $db->get_row($sSQL);
		};
		break;
	case "update":
		$sSQL="UPDATE speak SET speak_teacherid='$teacherid', speak_day='$day', speak_period='$period' 
		       WHERE speak_id='$id'";
		$db->query($sSQL);
		break;

};


//Set paging appearence
$ezr->query_mysql("SELECT speak_id, days_desc, speak_period, teachers_fname, teachers_lname, speak_teacherid 
FROM ((speak 
INNER JOIN teachers ON teachers_id = speak_teacherid) 
INNER JOIN tbl_days ON days_id = speak_day) 
ORDER BY teachers_lname, speak_day, speak_period");
$ezr->results_open = "<table width=80% cellpadding=2 cellspacing=0 border=1>";
$ezr->results_close = "</table>";
$ezr->results_heading = "<tr class=tblhead>
<td width=20%>" . _ADMIN_SPEAK_TEACHER . "</td>
<td width=20%>" . _ADMIN_SPEAK_DAY . "</td>
<td width=20%>" . _ADMIN_SPEAK_PERIOD . "</td>
<td width=20%>&nbsp;</td>
<td width=20%>&nbsp;</td>
</tr>";
$ezr->results_row = "<tr>
<td class=paging width=20%>COL5 COL4</td>
<td class=paging width=20% align=center>COL2</td>
<td class=paging width=20% align=center>COL3</td>
<td class=paging width=20% align=center>
  <a href=admin_speak.php?action=edit&id=COL1 class=aform>&nbsp;" . _ADMIN_SPEAK_EDIT . "</a></td>
<td class=paging width=20% align=center>
  <a name=href_remove href=# onclick=cnfremove(COL1); class=aform>&nbsp;" . _ADMIN_SPEAK_REMOVE . "</a></td>
</tr>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title><?echo _BROWSER_TITLE?></title>
<style type="text/css" media="all">@import "student.css";</style>
<SCRIPT language="JavaScript">
/* Javascript function to submit form and check if field is empty */
function submitform(fldName)
{
  var f = document.forms[1];
  var t = f.elements[fldName]; 
  if (t.value!="") 
    f.submit();
  else
    alert("<? echo _ENTER_VALUE?>");
}
/* Javascript function to ask confirmation before removing record */
function cnfremove(id) {
	var answer;	
	answer = window.confirm("<? echo _ADMIN_SPEAK_SURE?>");
	if (answer == 1) {
		var url;
		url = "admin_speak.php?action=remove&id=" + id;
		window.location = url; // other browsers
		href_remove.href = url; // explorer 
	}
	return false;
}

</SCRIPT>
<link rel="icon" href="favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<script type="text/javascript" language="JavaScript" src="sms.js"></script>
</head>

<body><img src="images/<? echo _LOGO?>" border="0">

<div id="Header">
<table width="100%">
  <tr>
    <td width="50%" align="left"><font size="2">&nbsp;&nbsp;<? echo date(_DATE_FORMAT); ?></font></td>
    <td width="50%"><? echo _ADMIN_SPEAK_ADMIN_AREA?></td>
  </tr>
</table>
</div>

<div id="Content">
	<h1><? echo _ADMIN_SPEAK_TITLE?></h1>
	<br>
	<?
	if ($action!="edit"){
		//Dislay results with paging options
		$ezr->display();
		?>
		<br>
		<form name="addspeak" method="post" action="admin_speak.php">
		<p class="pform"><? echo _ADMIN_SUBJECTS_ADD_NEW?><br>
		<table border="0" cellpadding="0" cellspacing="5"><tr>
		<td><? echo _ADMIN_SPEAK_DAY?>:</td>
		<td class="tdinput">
        	  <select name="day">
        	  <? //Display teachers from table
        	  foreach($days as $day){
        	  ?>
        	    <option value="<? echo $day->days_id; ?>">
		    <? echo $day->days_desc ?></option>
		  <? }; ?>
        	  </select>
		</td>
		<td>&nbsp;<? echo _ADMIN_SPEAK_PERIOD?>:</td>
		<td class="tdinput">
		  <select name="period">
		  <? for ($i=1; $i<=10; $i++) { ?>
		    <option value="<? echo $i; ?>">
		    <? echo $i; ?>
		  <? }; ?>
		  </select>
		</td>
		<td>&nbsp;<? echo _ADMIN_SPEAK_TEACHER?>:</td>
		<td class="tdinput">
        	  <select name="teacherid">
        	  <? //Display teachers from table
        	  foreach($teachers as $teach){
        	  ?>
        	    <option value="<? echo $teach->teachers_id; ?>" <?
		    if ($teach->teachers_id==$teachers->teacherid){echo
		    "selected=selected";};?>><? echo $teach->teachers_fname . " " . $teach->teachers_lname; ?></option>
		  <? }; ?>
        	  </select>
		</td>
		<td>
		  &nbsp;<input type=submit value="<? echo _ADMIN_SPEAK_ADD?>">
		</td>
		</tr></table>
		<input type="hidden" name="action" value="add">
		<input type="hidden" name="id" value="<? echo $id; ?>">
		</p>
		</form>
	<?
	}else{
	?>
	<br>

        <form name="editspeak" method="post" action="admin_speak.php">
	<p class="pform"><? echo _ADMIN_SPEAK_UPDATE_SUBJECT?><br>
	<table border="0" cellpadding="0" cellspacing="5"><tr>
	<td><? echo _ADMIN_SPEAK_DAY?>:</td>
	<td class="tdinput">
	  <select name="day">
	  <? //Display teachers from table
	  foreach($days as $day){
	  ?>
	    <option value="<? echo $day->days_id; ?>"
	    <? if ($day->days_id==$editspeak->speak_day){echo
	    "selected=selected";};?>><? echo $day->days_desc ?></option>
	  <? }; ?>
	  </select>
        </td>
        <td>&nbsp;<? echo _ADMIN_SPEAK_PERIOD?>:</td>
        <td class="tdinput">
	  <select name="period">
	  <? for ($i=1; $i<=10; $i++) { ?>
            <option value="<? echo $i; ?>" <?
	    if ($i==$editspeak->speak_period) {echo
	    "selected=selected";};?>>
            <? echo $i; ?>
          <? }; ?>
          </select>
        </td>
        <td>&nbsp;<? echo _ADMIN_SPEAK_TEACHER?>:</td>
        <td class="tdinput">
          <select name="teacherid">
          <? //Display teachers from table
          foreach($teachers as $teach){
          ?>
            <option value="<? echo $teach->teachers_id; ?>" <?
            if ($teach->teachers_id==$editspeak->speak_teacherid){echo
            "selected=selected";};?>><? echo $teach->teachers_fname . " " . $teach->teachers_lname; 
?></option>
          <? }; ?>
          </select>
        </td>
        <td>
	  &nbsp;<input type=submit value="<? echo _ADMIN_SPEAK_UPDATE?>">
        </td>
        </tr></table>
        <input type="hidden" name="action" value="update">
	<input type="hidden" name="id" value="<? echo $id; ?>">
        </p>
        </form>
	<?
	};
	?>
	<h3><? echo $msgFormErr; ?></h3>
</div>
<? include "admin_menu.inc.php"; ?>
</body>

</html>
