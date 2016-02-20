<?php # index.php for lesson 5
		/* This is the main page.
		 * It includes the config.inc.php file, the templates,
		 * and any content-specific modules.
		 * This is the "bootstrap" file.  All activity routes thru this file.
		 * It is the only file that is ever loaded in the web browser.
		 */

	require('includes/database.php');	


/* Determine which page to show.
	 * 'p' is passed as a parameter in the URL from <a> links in header.htm.
	 */
	if(isset($_GET['p'])) //Use GET in <a> link
	{
		$p=$_GET['p'];
	}
	elseif(isset($_POST['p'])) //Search form uses POST
	{
		$p=$_POST['p'];
	}
	else
	{
		$p=null;
	}
    
    switch($p)
    {
        case 'logIn':
            $page='login.inc.php';
            $page_title="Login Page";
        break;
        case 'register':
            $page='register.inc.php';
            $page_title="Registration Page";
        break;        
        case 'logOut':
            $page='logout.inc.php';
            $page_title="Logout Page";
        break;        
        case 'displayFamilyPics':
        	$page='familyPics.inc.php';
        	$page_title="Family Pictures";
        break;
        case 'insertFamilyPics':
        	$page='insertFamilyPics.inc.php';
        	$page_title="Insert Pictures";
        break;
        case 'deleteFamilyPics':
        	$page='deleteFamilyPics.inc.php';
        	$page_title="Delete Pictures";
        break;
        default:
            $page='main.inc.php';
            $page_title="Home Page";                
        break;
     }

	//Make sure file exists, or set default to main.inc.php
	if(!file_exists($page))
	{
        echo '<p>The page</p>' . $page . '<p>does not exist</p>';
		$page='main.inc.php';
		$page_title="Home Page";
    }

	//include('includes/header.htm');
	include($page);
	//include('includes/footer.htm');
?>