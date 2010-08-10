<?php
/* 
	milonicfunctions.php
	Various support functions 
	questions/comments: mfindlay@sagecomputerservices.com http://www.sagecomputerservices.com
*/
mytrace("milonicfunctions.php version 1.01");

$arrSubmenus = array();

//***************************************************************
// BuildMilonicMenuData
// Starting point for the building of the dynamic menu
//***************************************************************
function BuildMilonicMenuData($arrLinks)
{
	mytrace("BuildMilonicMenuData");
	global $arrSubmenus;
	
	$nCount = count($arrLinks);
	$s="";
	
	// build the top level menu items
	for ($x=0; $x<$nCount; $x++)
	{
		$row = $arrLinks[$x];
		if ($row['depth']=="1")
			{
				// Starting a new menu: fetch the top level menu template
				$TopLevel = GetTopLevelMenuTemplate($arrLinks,$x);
				$s .= $TopLevel;
			}
	}
	
	$s .= CRLF . "//********************* SUB MENUS ********************" . CRLF;
	
	// display the subitems under the top level
	foreach ($arrSubmenus as $Submenu)
	{
		$s .= CRLF . $Submenu . CRLF;
	}

	return $s;
}
//**************************************************************
// GetTopLevelMenuTemplate
// Builds the top level menu structure. 
// $nPos is the zero-based index of the current array position
//**************************************************************
function GetTopLevelMenuTemplate($arrLinks,$nPos)
{
	mytrace("GetTopLevelMenuTemplate. nPos = $nPos");
	
	$s="";
	$sLineItems="";
	
	// fetch the current row
	$row = $arrLinks[$nPos];
	
	mytrace("title = " . $row['link_title']);
	mytrace("depth = " . $row['depth']);
	
	$s =  "//******************** " . $row['link_title'] . " ***********************************" . CRLF;
	$s .= "with(milonic=new menuname('mm_" . $row['mlid'] . "')){ " . CRLF;
	$s .= "		//alwaysvisible=1; " . CRLF;
	$s .= "		//followscroll=1; " . CRLF;
	$s .= "		//overflow='scroll';  " . CRLF;
	$s .= "		style=mainMenuStyle; " . CRLF;
	$s .= "		//itemwidth=200; " . CRLF;
	$s .= "		top=nflyout_top; " . CRLF;
	$s .= "		left=nflyout_left; " . CRLF;
	$s .= "		TMPL_LINE_ITEMS_" . $row['mlid'] . CRLF;
	$s .= "		}" . CRLF;

	// if the menu has any subitems. if so, build them
	//if ($row['has_children']=="1") 
	{
		$sLineItems = GetMenuLineItems($arrLinks,$nPos);
	}
	
	// all sublevels are now built for this top level. So search and replace the line items
	$s = str_replace("TMPL_LINE_ITEMS_" . $row['mlid'],$sLineItems,$s);
	
	mytrace("GetTopLevelMenuTemplate. Complete.");
	return $s;
}

//**************************************************************
// GetMenuLineItems
// Builds the line items. 
// $nPos is the zero-based index of the current array position
//**************************************************************
function GetMenuLineItems($arrLinks,$nPos)
{
	mytrace("GetMenuLineItems. nPos = $nPos");
	
	global $base_path;
	global $arrSubmenus;
	
	// The row pointed to by $nPos has already been built at this point, so 
	// fetch the current row for reference and then start with the next row
	$prior_row = $arrLinks[$nPos];
	
	$nPos++;
	$bContinue=true;
	$s="";
	
	// ok to continue?
	while ($bContinue && (count($arrLinks) > $nPos))
	{
		// fetch the row this function is to work on 
		$row = $arrLinks[$nPos];
		
		// make sure this row is a child element of the $prior_row
		if (intval($row['depth']) >= intval($prior_row['depth'])+1)
		{
			// start a line item
			$s .= "aI(\"" ;   

			// set the text title
			$s .= "text=" . $row['link_title'] . ";";
			
			// if this item has children, create a 'showmenu' and build that submenu
			if ($row['has_children']=="1")
			{
				$s .= "showmenu=SUBMENU_" . $row['mlid'] . ";";
				
				$Submenu = BuildSubmenu($arrLinks,$nPos,$row['mlid']);
				
				if (strlen($Submenu)>1) $arrSubmenus[] = $Submenu;
				
				// since the BuildSubmenu will create the line items for this parent,
				// skip ahead to the next sibling
				$nCurrentDepth = intval($row['depth']);
				$nPos++;
				while (count($arrLinks) > $nPos)
				{
					$row = $arrLinks[$nPos];
					if ((intval($row['depth']) <= $nCurrentDepth) || $row['has_children']=="1")
					{
						// we have now skipped over the child items that were created in the BuildSubmenu() function above.
						// decrement the nPos by 1 here since the bottom of this loop increments it by 1.
						$nPos--;
						break;
					}
					
					$nPos++;
				}
			}
			else
			{
				// build the link
				// mfindlay 7/6/10 
				if (IsTestSite())
				{
					$s .= "url=" . $base_path . "?q=";
				}
				else
				{
					$s .= "url=" . $base_path;
				}
				
				if (strlen($row['dst'])>1)
				{
					$s .= $row['dst'];
				}
				else
				{
					$s .= $row['link_path'];
				}
				$s .=  ";";
			}
			
			$s .= "\");" . CRLF;
			
		}
		else
		{
			$bContinue=false;
			break;
		}
		
		$nPos++;
	}
	
	//$s .= "}" . CRLF;
	
	/*foreach ($arrSubmenus as $Submenu)
	{
		$s .= CRLF . $Submenu . CRLF;
	}
	*/
	
	mytrace("GetMenuLineItems. Complete.");
	return $s;
}

//aI("text=Ecessa's History;url=" + sNonSSLBaseSite + "pages/aboutus/aboutus_history.php;");
//aI("showmenu=HOWHELP_SPONSORACHILD;text=sponsor a child;url=" + sNonSSLBaseSite + "pages/howhelp/howhelp_sponsor_child_en.php;");

//**************************************************************
// BuildSubmenu
// Builds a 'showmenu' submenu
// $nPos is the zero-based index of the current array position
// $sSubmenuID is the unique id of the submenu
//**************************************************************
function BuildSubmenu($arrLinks,$nPos,$sSubmenuID)
{
	mytrace("BuildSubmenu. nPos = $nPos");
	
	// store the contents of the record just processed for our reference
	$prior_row = $arrLinks[$nPos];
	
	//$nPos++;
	$bContinue=true;
	$s="";
	
	$s .= "with(milonic=new menuname(\"SUBMENU_" . $sSubmenuID . "\")){" . CRLF;
	$s .= "style=subMenuStyle;" . CRLF;
	$s .= "//itemwidth += nSubMenuAdditionalWidthWide;" . CRLF;
	
	$s .= GetMenuLineItems($arrLinks,$nPos);

	$s .= "}" . CRLF;
	
	return $s;
}
	/*with(milonic=new menuname("HOWHELP_SPONSORACHILD")){
	style=subMenuStyle;
	//itemwidth += nSubMenuAdditionalWidthWide;
	aI("text=sponsored children;url=" + sNonSSLBaseSite + "pages/howhelp/howhelp_sponsored_children_en.php;");
	}*/

//==============================================================================
function BuildTopNavRow($row,$sSelected)
{
	//<div id="topnavlink_aboutus" onMouseOut="popdown(); return false;" 
	// onMouseOver="popup('mm_aboutus','topnavlink_aboutus'); return false;">
	//<a id="aaboutus" href="../pages/aboutus/aboutus_overview.php">ABOUT US</a></div>
	global $base_path;
	$s="";
	
	// build the link path
	// mfindlay 7/6/10 
	if (IsTestSite())
	{
		$sLinkPath = $base_path . "?q=";
	}
	else
	{
		$sLinkPath = $base_path;
	}
	
	if (strlen($row['dst'])>1)
	{
		$sLinkPath .= $row['dst'];
	}
	else
	{
		$sLinkPath .= $row['link_path'];
	}
	
	
	// special case for BLOG. If this is NOT the BLOG header, replace the linkpath with null path. We only
	// allow the original Drupal link if it is the BLOG.
	if (strcasecmp($row['link_path'],"blog")!=0) 
	{
		// NOT blog
		// Do not allow links on top nav.
		$sLinkPath = "javascript:void(0);";
	}
	else
	{
		$sLinkPath = "javascript:void(0);";
		//-----------------------------------------
		// mjf 7/22/10 Make blog a flyout menu item
		// IS Blog
		// Do not allow links on top nav.
		/*
		$s .= "<div class='miloniclink' id='topnavlink_" . "blog" . "' onMouseOut=\"popdown(); return false;\" ";
		$s .= "onMouseOver=\"popup('mm_" . "blog" . "','topnavlink_" . "blog". "'); return false;\">";
		$s .= "<a id=\"a" . $row['mlid'] . "\" href=\"" . $sLinkPath . "\">" . $row['link_title'] . "</a>";
		return $s;
		*/
		//-----------------------------------------
	}
	
	$s .= "<div class='miloniclink' id='topnavlink_" . $row['mlid'] . "' onMouseOut=\"popdown(); return false;\" ";
	$s .= "onMouseOver=\"popup('mm_" . $row['mlid'] . "','topnavlink_" . $row['mlid'] . "'); return false;\">";
	if (strlen($sSelected)>0)
	{
		$s .= "<span class='toplinkselected'>" . $row['link_title'] . "</span>";
	}
	else
	{
		$s .= "<a id=\"a" . $row['mlid'] . "\" href=\"" . $sLinkPath . "\">" . $row['link_title'] . "</a>";
	}
	
	
	return $s;
}
?>