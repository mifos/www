<?php
/*
	CommonFunctions.php
	Various support functions 
	questions/comments: mfindlay@sagecomputerservices.com http://www.sagecomputerservices.com
*/
require_once (dirname(__FILE__)."/constants.php"); 

mytrace("commonfunctions.php version 1.00");

$g_sCurrentPage = GetCurrentPageNodeID();

//***************************************************************
// StripQEquals 
// mfindlay 7/1/10
//***************************************************************
function StripQEquals($sQEqualsString)
{
	// if the string is too short to contain q= then just return the original string
	if (strlen($sQEqualsString) < 3) return $sQEqualsString;
	
	// if the string starts with q= then return the string minus the q=
	if (strcasecmp(substr($sQEqualsString,0,2),'q=')==0) return substr($sQEqualsString,2); 
	
	// string does not begin with q= so just return the original string
	return $sQEqualsString; 
}
//***************************************************************
// BuildTopBlogArray
//***************************************************************
function BuildTopBlogArray($nCount)
{
	$sSQL = "SELECT node.nid AS nid, " .
			   "node.title AS node_title, " .
			   "node_revisions.body AS node_revisions_body, " .
			   "node_revisions.format AS node_revisions_format, " .
			   "comments.timestamp AS comments_timestamp " .
				 "FROM node node " .
				 "LEFT JOIN node_revisions node_revisions ON node.vid = node_revisions.vid " .
				 "LEFT JOIN comments comments ON node.nid = comments.nid " .
				 "WHERE (node.status <> 0) AND (node.type in ('blog')) " .
			   "ORDER BY comments_timestamp DESC " .
			   "LIMIT " . strval($nCount);
	
	mytrace($sSQL);
	
	$result = db_query($sSQL);
	
	// load each returned row into the return array
	$arrReturn=array();
	
	while ($arg = db_fetch_array($result)) 
	{
		$arrReturn[] = $arg;
	}
	
	return $arrReturn;

}
//********************************************************
// mfindlay 7/1/10 
// FetchThirdItemArray
// Returns an array of all the menu thirs level subitems for the given P1,P2 value
//********************************************************
function FetchThirdItemArray($s_menu,$s_p1,$s_p2)
{
	mytrace("FetchThirdItemArray: s_menu=$s_menu and s_p1=$s_p1 and s_p2=$s_p2");
	
	$arrReturn = array();
	
	// mfindlay 7/1/10 : because of the inadequate database structure of the drupal database, we need to first fetch all of the 
	//                   depath=1 items, then for each row, fetch the child items and append to our final returned table
	
	//$result = db_query("SELECT * FROM menu_links left outer join url_alias on url_alias.src = menu_links.link_path 
	//                    WHERE hidden=0 and menu_name=\"primary-links\" and depth=1 order by weight");
	$sSQL = "SELECT * FROM menu_links left outer join url_alias on url_alias.src = menu_links.link_path WHERE module=\"menu\" AND hidden=0 AND p1=$s_p1 AND p2=$s_p2 AND depth=3 ";
		if (strlen($s_menu)>0) $sSQL .= " AND menu_name=\"$s_menu\" "; 
	$sSQL .= "ORDER BY depth, weight";
	
	mytrace($sSQL);
	
	// fetch the intermediate WORK results
	$result = db_query($sSQL);
	
	// WORK array loop
	// First load each returned row into the WORK array
	while ($arg = db_fetch_array($result)) 
	{
		// write out the DEPTH=3 record
		$arrReturn[] = $arg;		
	}
	
	return $arrReturn;
}
//********************************************************
// mfindlay 7/1/10 
// FetchSubItemArray
// Returns an array of all the menu subitems for the given P1 value
//********************************************************
function FetchSubItemArray($s_menu,$s_p1)
{
	mytrace("FetchSubItemArray: s_menu=$s_menu and s_p1=$s_p1");
	
	$arrReturn = array();
	
	// mfindlay 7/1/10 : because of the inadequate database structure of the drupal database, we need to first fetch all of the 
	//                   depath=1 items, then for each row, fetch the child items and append to our final returned table
	
	//$result = db_query("SELECT * FROM menu_links left outer join url_alias on url_alias.src = menu_links.link_path 
	//                    WHERE hidden=0 and menu_name=\"primary-links\" and depth=1 order by weight");
	$sSQL = "SELECT * FROM menu_links left outer join url_alias on url_alias.src = menu_links.link_path WHERE module=\"menu\" AND hidden=0 AND p1=$s_p1 AND depth=2 ";
		if (strlen($s_menu)>0) $sSQL .= " AND menu_name=\"$s_menu\" "; 
	$sSQL .= "ORDER BY depth, weight";
	
	mytrace($sSQL);
	
	// fetch the intermediate WORK results
	$result = db_query($sSQL);
	
	// WORK array loop
	// First load each returned row into the WORK array
	while ($arg = db_fetch_array($result)) 
	{
		// fetch an array of subitems for this top level item
		$arrWork = FetchThirdItemArray($s_menu,$arg['p1'],$arg['p2']);
		
		// write out the DEPTH=2 record
		$arrReturn[] = $arg;
		
		// now fetch and write out each subitem to the final output array
		$nCount = count($arrWork);
		for ($x=0; $x<$nCount; $x++)
		{
			// write out the subitem to the final output array
			$arrReturn[] = $arrWork[$x];
		}
		
	}
	
	return $arrReturn;
}

//********************************************************
// GetMenuArray
// Returns an array of all the menu items in the desired menu
// $s_menu is optional
// $s_starting_depth is optional
//********************************************************
function GetMenuArray($s_menu)
{
	mytrace("GetMenuArray: s_menu=$s_menu");
	
	$arrReturn = array();
	
	// mfindlay 7/1/10 : because of the inadequate database structure of the drupal database, we need to first fetch all of the 
	//                   depath=1 items, then for each row, fetch the child items and append to our final returned table
	
	//$result = db_query("SELECT * FROM menu_links left outer join url_alias on url_alias.src = menu_links.link_path 
	//                    WHERE hidden=0 and menu_name=\"primary-links\" and depth=1 order by weight");
	$sSQL = "SELECT * FROM menu_links left outer join url_alias on url_alias.src = menu_links.link_path WHERE module=\"menu\" AND hidden=0 AND depth=1 ";
		if (strlen($s_menu)>0) $sSQL .= " AND menu_name=\"$s_menu\" "; 
		//if (strlen($s_starting_depth)>0) $sSQL .= " AND depth=$s_starting_depth ";
	$sSQL .= "ORDER BY depth,weight ";     // p1,p2,p3,p4,p5,p6,p7,p8,p9, depth, weight
	
	mytrace($sSQL);
	
	// fetch the intermediate WORK results
	$result = db_query($sSQL);
	
	// WORK array loop
	// First load each returned row into the WORK array
	while ($arg = db_fetch_array($result)) 
	{
		// fetch an array of subitems for this top level item
		$arrWork = FetchSubItemArray($s_menu,$arg['p1']);
		
		// write out the DEPTH=1 record
		$arrReturn[] = $arg;
		
		// now fetch and write out each subitem to the final output array
		$nCount = count($arrWork);
		for ($x=0; $x<$nCount; $x++)
		{
			// write out the subitem to the final output array
			$arrReturn[] = $arrWork[$x];
		}
		
	}
	
	// Now the array elements are in their proper top level weight order.
	// So fetch each top level item's subitems
	//while ($arg = db_fetch_array($result)) 
	//{
	//	$arrReturn[] = $arg;
	//}

	
	// mfindlay 7/1/10
	// we now have the loaded array, but it needs to be further sorted by weight at the DEPTH=1 level
	return $arrReturn;
}

//********************************************************
// OutBR
//********************************************************
function OutBR($s)
{
	print("<span class='mytracetext'>");
	
	print($s);
	
	print("</span><br>");
}
//********************************************************
// GetCurrentPagePath
// returns the current page path, minus the q=
// so http://grameen.minisage.com/?q=about/news/press-releases would return
// about/news/press-releases
//********************************************************
function GetCurrentPagePath()
{
	$sPHPSelf = $_SERVER['QUERY_STRING']; 
	$sCurrentPagePath = StripQEquals($sPHPSelf);
	return $sCurrentPagePath;
}
//********************************************************
// GetCurrentSecondLevelName
// Returns the second level name that we're currently on (if any)
// for example, q=about/news/press-releases would return 'about/news'
//********************************************************
function GetCurrentSecondLevelName()
{
	mytrace("GetCurrentSecondLevelName()");
	
	// strip the q=
	$sCurrentPagePath = GetCurrentPagePath();  // i.e. about/news/press-releases
	mytrace("GetCurrentSecondLevelName: current path = $sCurrentPagePath");
	
	// make lower case
	$sCurrentPagePath = strtolower($sCurrentPagePath);
	// mfindlay 7/1/10 strip &debug=0 or &debug=1 if present, as these are debug strings
	$sCurrentPagePath = StripDebugQS($sCurrentPagePath);
	mytrace("adjusted path = $sCurrentPagePath");
	
	// is the current path a node/21 type path (admin failed to use url aliasing, so fetch the path by querying on the node)
	if (strpos($sCurrentPagePath,"node")===0)
	{
		mytrace("Node only, unable to fetch Second level name");
		return "";
	}
	
	$arrLevels  = explode("/",$sCurrentPagePath);
	if (count($arrLevels)>1)
	{
		$sRet = $arrLevels[0] . '/' . $arrLevels[1];
		mytrace("Second Level name found: " . $sRet);
		
		return $sRet;
	}

	mytrace("NO Second Level name found");
	return "";
}

//********************************************************
// StripDebugQS
// strips debug=0 or debug=1 from string
//********************************************************
function StripDebugQS($s)
{
	$sRet = str_replace('&debug=1','',$s);
	$sRet = str_replace('&debug=0','',$sRet);
	return $sRet;
}
//********************************************************
// GetCurrentPageNodeID
// Returns the "node/21" version of the path
//********************************************************
function GetCurrentPageNodeID()
{
	mytrace("GetCurrentPageNodeID");
	
	// strip the q=
	$sCurrentPagePath = GetCurrentPagePath();  // i.e. about/news/press-releases
	mytrace("current path = $sCurrentPagePath");
	
	/*
	$nPos = strrpos($sPHPSelf,"/");
	if ($nPos===false)
	{
		mytrace("unable to determine current page name");
		return "";
	}
	
	$sCurrentPage = substr($sPHPSelf,$nPos+1);
	mytrace("Page following last forward slash = $sCurrentPage");
	
	// if we have the node at this point, return. 
	// Otherwise we have an alias so lookup the node
	if (is_int($sCurrentPage)) 
	{
		mytrace("page is node based: node = $sCurrentPage");
		return "node/" . $sCurrentPage;  // returns node/21
	}
	*/
	
	// make lower case
	$sCurrentPagePath = strtolower($sCurrentPagePath);
	
	// mfindlay 7/1/10 strip &debug=0 or &debug=1 if present, as these are debug strings
	$sCurrentPagePath = StripDebugQS($sCurrentPagePath);
	mytrace("adjusted path = $sCurrentPagePath");
	
	// is the current path a node/21 type path (admin failed to use url aliasing, so just return the node)
	if (strpos($sCurrentPagePath,"node")===0)
	{
		// node based 
		mytrace("returning node based current page: $sCurrentPagePath");
		return $sCurrentPagePath; 
	}
	
	// read from the url_alias table to fetch the NODE for this alias
	$sSQL = "SELECT * FROM url_alias WHERE dst='" . $sCurrentPagePath . "'";
	mytrace($sSQL);
	
	$result = db_query($sSQL);
	
	// load each returned row into the return array
	if ($arg = db_fetch_array($result))
	{
		$sCurrentNode = $arg['src'];	
		mytrace("page is alias based: src = $sCurrentNode");
		return $sCurrentNode;   // returns node/21 address
	} 
	
	mytrace("Returning empty string");
	return "";
}
//********************************************************
// GetCurrentSection
//********************************************************
function GetCurrentSection()
{
	// get querystring
	$sQS = trim($_SERVER['QUERY_STRING']);
	mytrace("GetCurrentSection. sQS = [$sQS]");
	
	// to lower case
	$sQS = strtolower($sQS);
	
	// strip off any querystring parameters
	$nPos = strpos($sQS,"&");
	if ($nPos!==FALSE)
	{
		$sQS = substr($sQS,0,$nPos);
	}
	mytrace("cleaned sQS = [$sQS]");

	// empty?
	if (strlen($sQS)<1)
	{
		return "";
	}
	
	// strip the q=
	$sQS = StripQEquals($sQS);
	
	// store the QS at this point in case we need to do a node lookup
	$sNodeLookup = $sQS;
	
	// look for the first forward slash
	$nPos = strpos($sQS,"/");
	
	// not found? return what we have
	if ($nPos===FALSE) return $sQS;
	
	// remove everything after the forward slash
	$sQS = substr($sQS,0,$nPos);
	//echo $sQS;
	
	mytrace("Current section = [$sQS]");
	
	// is URL aliasing turned off (we will then only have the word 'node' from the querystring)?
	if (strcmp($sQS,"node")==0)
	{
		mytrace("No alias set up for this node. Performing a lookup");
		$sQS = GetSectionNameByNode($sNodeLookup);
	}
	
	return $sQS; 
}
//********************************************************
// GetSectionNameByNode
// given a node name, look up the name of the owning section
//********************************************************
function GetSectionNameByNode($sNodeName)
{
	$sSQL = "SELECT * FROM menu_links WHERE link_path=\"$sNodeName\" ";
	mytrace($sSQL);
	
	$result = db_query($sSQL);
	
	$p1="";
	
	// load each returned row into the return array
	if ($arg = db_fetch_array($result))
	{
		$p1 = $arg['p1'];
	} 
	
	if (strlen($p1)<1)
	{
		return "";
	}
	
	$sSQL = "SELECT * FROM menu_links WHERE mlid=$p1 ";
	$result = db_query($sSQL);
	
	// load each returned row into the return array
	if ($arg = db_fetch_array($result))
	{
		return $arg['link_title'];
	} 

	return "";
}
//********************************************************
// BuildRightNavMenu
//********************************************************
function BuildRightNavMenu($sSection)
{
	$P1="";
	$mytable="";
	$TOParg="";
	$arg="";
	$sCurrentPage = GetCurrentPageNodeID();
	
	// mfindlay 7/1/10 Fetch the 2nd level that we're currently in. *(if we are in a 2nd level)
	//                 For example, if we are on page q=about/news/press-releases then even though we are on page press-releases, 
	//                 the name of the 2nd level we're on is 'about/news'. Just as the name of the first level we're on is 'about'
	//                 We need to know the name of the current 2nd level page we're on (if any) so that as we build the menu, if we
	//                 encounter a 2nd level menu item, we know whether or not to make it dark which would indicate that we're on 
	//                 that 2nd level
	$sCurrentSecondLevelName = GetCurrentSecondLevelName();
	
	
	mytrace("BuildRightNavMenu: sCurrentPage=$sCurrentPage");
	
	$mytable .= "<div class='rightcolintmenuheight'>";
	
	// first get the information about the top level menu
	if (strlen($sSection)<1)
	{
		return "";
	}
	
	//$result = db_query("SELECT * FROM menu_links WHERE hidden=0 and menu_name=\"primary-links\" order by P1, depth, weight");
	$sSQL = "SELECT * FROM menu_links WHERE module=\"menu\" AND hidden=0 and menu_name=\"primary-links\" and depth=1 " .
	        "AND link_title=\"$sSection\" " . 
	        "ORDER BY WEIGHT";
	//echo $sSQL;
	
	$result = db_query($sSQL);
	
	// get the P1 value of the section menu
	if ($arg = db_fetch_array($result)) 
	{
		// store top record
		$TOParg = $arg;
		
		$P1 = MyTrim($arg['p1']);
		if (strlen($P1)<1)
		{
			mytrace("Error: Unable to read P1 value");
			return "";
		}
	}
	
	// mfindlay 7/1/10
	// fetch the 2nd and 3rd level menu items into a work array
	$arrWork = FetchSubItemArray("primary-links",$arg['p1']);
	$nWrkArrayCount = count($arrWork);
	
	// we at least have a section name, so create the table header
	$mytable .= "<table class='rightnavtable' cellspacing='0' cellpadding='0' width='100%'>" . CRLF;
	
	$bFirst=TRUE; 
	$sClass="";
	
	$nSubSectionToggleCount=0;  // Represents the number of subsections that will be expandable/collapseable.
	$bInSubMenu=FALSE;			// indicates whether we're in the process of writing submenu items.
	$sHideMe = "";				// Gets set on all collapseable subitems so that we can toggle their visibility
	$sSubMenuID = "";			// Sets the TR of the submenu clickable row, so we can find it in ToggleSubmenu
		
	/*
		SELECT * FROM menu_links left outer join url_alias on url_alias.src = menu_links.link_path
		WHERE hidden=0 AND menu_name="primary-links" AND p1=114 order by P1, depth, weight
	*/
	// fetch the rows
	//$sSQL = "SELECT * FROM menu_links WHERE hidden=0 AND menu_name=\"primary-links\" AND p1=$P1 order by P1, depth, weight";
	/* mfindlay 7/1/10
	$sSQL = "SELECT * FROM menu_links left outer join url_alias on url_alias.src = menu_links.link_path " . 
	        "WHERE module=\"menu\" AND hidden=0 AND depth < 4 AND menu_name=\"primary-links\" AND p1=$P1 " . 
			"ORDER BY P1, P2, P3, P4, P5, P6, P7, P8, P9, depth, weight";
	mytrace($sSQL);
	
	$result = db_query($sSQL);
	while ($arg = db_fetch_array($result)) */
	for ($x=-1; $x<$nWrkArrayCount; $x++)
	{
		// fetch the row. The very first row will have already been 
		if ($bFirst) 
		{
			// first time: fetch the top row we read above
			$arg = $TOParg; 
		}
		else
		{
			// fetch the subitem from the array we loaded
			$arg = $arrWork[$x];
		} 
		// only allow 3 levels
		// mfindlay 7/1/10 handle this in the query.   if (intval($arg['depth']) > 3) continue;
		
		$sClass="";
		$onClickHandler = "";
		$sSubMenuID = "";			
		
		// is this the first record? This is the section title
		if ($bFirst)  
		{
			$sClass = "rightnavtabletitle";
		}
		else
		{
			// Set up the class name(s).
			// If this is a subsection, mark as such, otherwise, mark as first level item under the section title
			$sClass = ($arg['has_children']==="1") ? "rightnavtableitem_bordertop rightnavtableitem_parent_" : "rightnavtableitem_bordertop rightnavtableitem_";
			$sClass .= $arg['depth']; // append the depth. (will be 2 or 3)
			
			// mfindlay 7/1/10 If the menu item is a level 2 and has children, AND if we're in that section now, then add "current" to the level 2 so that 
			//                 it shows at the darker level.
			// Is this a subsection header? (it has children and is at the level 2 in the menu structure) 
			if ( ($arg['has_children']==="1") && ($arg['depth']=="2") )
			{
				// are we currently in the section represented by this subsection?
				if (strcasecmp($sCurrentSecondLevelName,$arg['dst'])==0)
				{
					// Add the 'current' qualifier to this second level item.
					// We will not toggle this level.
					$sClass .= " current ";
				}
				else
				{
					// increment the number that references each expandable submenu
					$nSubSectionToggleCount++;
					$onClickHandler = " onclick=\"ToggleSubmenu('Submenu_$nSubSectionToggleCount'); return false;\" ";
					// Tell subsequent rows that we are in the process of coding the collapseable submenu items. We 
					// are currently processing the submenu header row, so we need to set the class on individual subitems under this section
					// to hidden initially, then when the subheader row is clicked, we'll toggle them to make them visible.
					$bInSubMenu=TRUE; 
					
					// Set the TR's id so we can find it in ToggleSubmenu
					$sSubMenuID = " id='Submenu_$nSubSectionToggleCount' ";
				}
			}
		}
		
		// If we are done processing submenu items, turn off the bInSubMenu flag
		if ( ($arg['has_children']==="0") && ($arg['depth']=="2") ) $bInSubMenu=FALSE;
		
		// Another check to see if we've completed a submenu: if we are at level 2 and sHideMe has a value, then we've completed
		// a submenu above us and it's time to turn off the hideme flag
		if (($arg['depth']=="2") && (strlen($sHideMe)>0))
		{
			$bInSubMenu=FALSE;
			$sHideMe = "";
		}
		
		// If we are processing a submenu (to be collapseable) item, then set the 'hideme' flag, otherwise clear the 'hideme' flag
		if (($bInSubMenu==TRUE) && ($arg['depth']=="3"))
		{
			$sHideMe = " class='hideme cantoggle' ";
		}
		else
		{
			$sHideMe = "";
		}
		
		// indent based on the level of the menu item
		// The title will have its own class rightnavtabletitle
		// The child items will be named rightnavtableitem_x where x is their depth level on the menu
		// Non child items that also have children will have a clas of rightnavtableitem_parent_x where x is the depth
		
		// build the link path (http://grameen.minisage.com/?q=about/mission)
		$sLink="";
		$sLink = trim($arg['dst']);
		if (strlen($sLink)<1) $sLink = $arg['link_path'];
		
		// if this td is for the current page, set "selected" class
		$bIsCurrentPage=FALSE;
		$sSelectedClass="";
		
		mytrace("sCurrentPage = $sCurrentPage");
		mytrace("src = " . strval($arg['src']));
		mytrace("dst = " . strval($arg['dst']));
		
		// make sure we don't set a highlight if we don't know what the current page is
		if (strlen($sCurrentPage)>0)  // mfindlay 7/1/10
		{
			if (strcasecmp(strval($arg['src']),$sCurrentPage)==0) $bIsCurrentPage=TRUE;
			if (strcasecmp(strval($arg['dst']),$sCurrentPage)==0) $bIsCurrentPage=TRUE;
		}
		if ($bIsCurrentPage==TRUE) $sSelectedClass = " class='selecteditem' ";

		$hRefPrefix = "<a $sSelectedClass onfocus='this.blur()' href='" . $front_page . "/?q=$sLink" . "'>";
		$hRefSuffix = "</a>";
		
		//dvm($arg);
		
		if (($bFirst) || ($arg['has_children']==="1"))
		{
			// turn off link on header
			$hRefPrefix="";
			$hRefSuffix="";
		}
		
		$bFirst=FALSE;
				
		//print $arg['link_title'] . ' ';
		$mytable .= "<tr $sSubMenuID $sHideMe>" . CRLF . 
			             "<td align='left' valign='middle' class='" . $sClass . "' $onClickHandler>$hRefPrefix" . $arg['link_title'] . "$hRefSuffix</td>" . CRLF . 
			        "</td>" . CRLF;
	} //for ($x=0; $x<$nWrkArrayCount; $x++) // while ($arg = db_fetch_array($result)) 

	// close the table
	$mytable .= "</table>" . CRLF . "</div>" . CRLF;
	
	return $mytable;
}
//********************************************************
// MyTrim
//********************************************************
function MyTrim($s)
{
	return trim(strval($s));
}
//********************************************************
// MyDate
//********************************************************
function MyDate()
{
	// MySQL takes dates in YYYY-MM-DD format
	$sMySQLDate = date('Y-m-d',time()); 
	return strval($sMySQLDate);
}
//********************************************************
// MyNow
//********************************************************
function MyNow()
{
	mytrace("MyNow");
	
	// MySQL takes dates in YYYY-MM-DD HH:MM:SS format
	$sMySQLDate = date('Y-m-d H:i:s',time()); 
	return strval($sMySQLDate);
}
//********************************************************
// GetYear
//********************************************************
function GetYear()
{
	mytrace("GetYear");
	
	// MySQL takes dates in YYYY-MM-DD HH:MM:SS format
	$sCurrentYear = date('Y');
	return $sCurrentYear;
}
//********************************************************
// mytrace. 
// Displays the string to the screen.
// Only show on test site, and only if trace enabled
//********************************************************
function mytrace($s)
{
	// see constants.php for TRACE_ENABLED flag
	
	// turn off trace?
	if (isset($_REQUEST[QS_DEBUG]))
	{
		if ($_REQUEST[QS_DEBUG]=="0") 
		{
			$_SESSION[QS_DEBUG]="";
		} 
	}
	
	// Turn ON trace?
	if (isset($_REQUEST[QS_DEBUG]))
	{
		if ($_REQUEST[QS_DEBUG]=="1") 
		{
			$_SESSION[QS_DEBUG]="1";
			
			OutBR($s);
			return;
		} 
	}
	
	if (TRACE_ENABLED) 
	{
		$_SESSION[QS_DEBUG]="1";
		
		OutBR($s);
		return;
	} 
	
	if (isset($_SESSION[QS_DEBUG]))
	{
		if ($_SESSION[QS_DEBUG]=="1") 
		{
			$_SESSION[QS_DEBUG]="1";
			
			OutBR($s);
			return;
		} 
	}
	
}

//********************************************************
// ShowServerVariables
//********************************************************
function ShowServerVariables()
{
	mytrace("----------- Server Variables -------------------");
	foreach($_SERVER as $key_name => $key_value) {
		mytrace($key_name . " = " . $key_value);
	}
	mytrace("------------------------------------------------");
}
//********************************************************
// IsCurrentPageSecure
//********************************************************
function IsCurrentPageSecure()
{
	// Test site SSL is broken, so always allow on TEST site
	if (IsTestSite())
	{
		return true;
	}
	return ($_SERVER['SERVER_PORT'] == '443');
}
//********************************************************
// IsSecurePage
//********************************************************
function IsSecurePage()
{
	return IsCurrentPageSecure();
}
//********************************************************
// EscapeHTML
//********************************************************
function EscapeHTML($s)
{
	mytrace("EscapeHTML");
	
	$s = ereg_replace('"','&quot;',$s);
	$s = ereg_replace('<','&lt;',$s);
	$s = ereg_replace('>','&gt;',$s);
	$s = mysql_escape_string($s);
	return $s;
}
//********************************************************
// UnEscapeHTML
//********************************************************
function UnEscapeHTML($s)
{
	$s = ereg_replace('&quot;','"',$s);
	$s = ereg_replace('&lt;','<',$s);
	$s = ereg_replace('&gt;','>',$s);
	return $s;
}
//********************************************************
// Out
//********************************************************
function Out($s)
{
	print($s);
}
//********************************************************
// my_stripos : for PHP versions prior to PHP 5
//********************************************************
function my_stripos($haystack,$needle,$offset = 0)
{
   return(strpos(strtolower($haystack),strtolower($needle),$offset));
}
//********************************************************
// my_nl2br : REPLACES newlines with <br />
//********************************************************
function my_nl2br($s_string)
{
	$sRet="";
	$sRet = str_replace(NEWLINE_STRING,BR_STRING,$s_string);

   	return $sRet;
}
//********************************************************
// my_spaces2nbsp : REPLACES ' ' with &nbsp;
//********************************************************
function my_spaces2nbsp($s_string)
{
	$sRet="";
	$sRet = str_replace(SPACE_STRING,NBSP_STRING,$s_string);

   	return $sRet;
}
//********************************************************
// my_br2nl : REPLACES <br /> with newlines
//********************************************************
function my_br2nl($s_string)
{
	$sRet="";
	$sRet = str_replace(BR_STRING,NEWLINE_STRING,$s_string);
	
   	return $sRet;
}

//********************************************************
// MySetCookie
//********************************************************
function MySetCookie($sCookieName, $sCookieValue)
{
	$bRC = setcookie($sCookieName, $sCookieValue, time()+60*60*24*GENERAL_COOKIE_DAYS);
	return $bRC;
}
//********************************************************
// MyGetCookie
//********************************************************
function MyGetCookie($sCookieName)
{
	if (isset($_COOKIE[$sCookieName])) 
	{
		return $_COOKIE[$sCookieName];
	}
	
	return "";
}

//********************************************************
// AbandonSession
//********************************************************
function AbandonSession()
{
	// Initialize the session.
	// If you are using session_name("something"), don't forget it now!
	session_start();
	
	// Unset all of the session variables.
	$_SESSION = array();
	
	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	if (isset($_COOKIE[session_name()])) 
	{
		setcookie(session_name(), '', time()-42000, '/');
	}
	
	// Finally, destroy the session.
	session_destroy();
}
//********************************************************
// GenerateGuid
//********************************************************
function GenerateGuid()
{
    $microTime = microtime();
	list($a_dec, $a_sec) = explode(" ", $microTime);

	$dec_hex = sprintf("%x", $a_dec* 1000000);
	$sec_hex = sprintf("%x", $a_sec);

	ensure_length($dec_hex, 5);
	ensure_length($sec_hex, 6);

	$guid = "";
	$guid .= $dec_hex;
	$guid .= create_guid_section(3);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= $sec_hex;
	$guid .= create_guid_section(6);

	return '{' . $guid . '}';
}
//********************************************************
// GenerateQSAppend
//********************************************************
function GenerateQSAppend()
{
    $microTime = microtime();
	list($a_dec, $a_sec) = explode(" ", $microTime);

	$dec_hex = sprintf("%x", $a_dec* 1000000);
	$sec_hex = sprintf("%x", $a_sec);

	//ensure_length($dec_hex, 5);
	//ensure_length($sec_hex, 6);

	return strval($dec_hex) . strval($sec_hex);
}

//********************************************************
// GetIntPageHeaderImg
// mfindlay 7/1/10 : created function GetIntPageHeaderImg
// Returns the name of the image to be used for the passed section
//********************************************************
function GetIntPageHeaderImg($s_current_section)
{
	mytrace("GetIntPageHeaderImg: current section passed is $s_current_section");
	if (strcasecmp($s_current_section,"about")==0) return "header_about.jpg";
	if (strcasecmp($s_current_section,"products")==0) return "header_products.jpg";
	if (strcasecmp($s_current_section,"services")==0) return "header_services.jpg";
	if (strcasecmp($s_current_section,"customers")==0) return "header_customers.jpg";
	if (strcasecmp($s_current_section,"community")==0) return "header_community.jpg";
	
	return "header_default.jpg";
}
//********************************************************
// IsFireFox
//********************************************************
function IsFireFox()
{
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']); 
	$nPos = strpos($agent,"firefox");
	return ($nPos != FALSE);
}
//********************************************************
// IsIE7
//********************************************************
function IsIE7()
{
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']); 
	$nPos = strpos($agent,"msie 7.");
	return ($nPos != FALSE);
}
?>