fixMozillaZIndex=true; //Fixes Z-Index problem  with Mozilla browsers but causes odd scrolling problem, toggle to see if it helps

var nSubMenuAdditionalWidthMedium = 150;   	//mfindlay
var nSubMenuAdditionalWidthWide = 200;    	//mfindlay

var nMenuWidth=200;				// width of menus to appear. Set to zero to ignore

// Set default locations for flyout menu
var nflyout_top = -1;   // -5
var nflyout_left = 0;  //0

//var submenuTopOffset = "offset=5";  see iym for reference use in submenu flyouts
//var submenuLeftOffset = "offset=1";

// milonic
_menuCloseDelay=250;           	// The time delay for menus to remain visible on mouse out
_menuOpenDelay=50;             	// The time delay before menus open on mouse over
_subOffsetTop=4;             	// Sub menu top offset from bottom of image associated with it
_subOffsetLeft=5;            	// Sub menu left offset

// MAIN STYLE
with(mainMenuStyle=new mm_style()){
onbgcolor="#f7b943";			// hover background color  
offbgcolor="#f7b943";			// normal (non-hover) background color  
offcolor="#211f1f";				// normal (non-hover) text color  
oncolor="#ffffff";				// hover text color  
offclass="mmpadding";			// custom style attached to menu
onclass="mmpadding";			// custom style attached to menu
bordercolor="#f7b943";			// border color #B59973
borderstyle="solid";
borderwidth=1;			
fontfamily="Arial";				// font / font family
fontsize="11px";				// font size
fontstyle="normal";				// font style   
fontweight="bold";				// font weight (bold)   
//outfilter="Fade(duration=0.1)";
overfilter="Fade(duration=0.1);Alpha(opacity=95);";
//overfilter="Fade(duration=0.1);Alpha(opacity=90);Shadow(color='#777777', Direction=135, Strength=5)";
padding=3;						// menu item cell padding
pagebgcolor="#f7b943"; 			// this is the (non-hover) background color of the menu item last clicked #D2B48C
pagecolor="#211f1f";  			// this is the (non-hover) text color of the menu item last clicked 
separatorcolor="#ffffff";		// separator color #D2B48C
separatorsize="1";
subimage="milonic/arrow.gif";
subimagepadding="2";
subimageposition="right";
}
// SUBLEVEL STYLE
with(subMenuStyle=new mm_style()){
onbgcolor="#f7b943";			// hover background color  
offbgcolor="#f7b943";			// normal (non-hover) background color  
offcolor="#211f1f";				// normal (non-hover) text color  
oncolor="#ffffff";				// hover text color  
offclass="mmpadding";			// custom style attached to menu
onclass="mmpadding";			// custom style attached to menu
bordercolor="#f7b943";			// border color #B59973
borderstyle="solid";
borderwidth=1;			
fontfamily="Arial";				// font / font family
fontsize="11px";				// font size
fontstyle="normal";				// font style   
fontweight="bold";				// font weight (bold)   
//outfilter="Fade(duration=0.1)";
overfilter="Fade(duration=0.1);Alpha(opacity=95);";
//overfilter="Fade(duration=0.1);Alpha(opacity=90);Shadow(color='#777777', Direction=135, Strength=5)";
padding=3;						// menu item cell padding
pagebgcolor="#f7b943"; 			// this is the (non-hover) background color of the menu item last clicked #D2B48C
pagecolor="#211f1f";  			// this is the (non-hover) text color of the menu item last clicked 
separatorcolor="#ffffff";		// separator color #D2B48C
separatorsize="1";
subimage="milonic/arrow.gif";
subimagepadding="2";
subimageposition="right";
}

//******************** ABOUT US ***********************************
with(milonic=new menuname("mm_aboutus")){
//alwaysvisible=1;
//followscroll=1;
//overflow="scroll";  // Do not use scrollbars on this flyout since it can be so close to bottom of page
style=mainMenuStyle;
itemwidth=153;  
top=nflyout_top;
left=nflyout_left;

//aI("align=center;pointer=move;text=drag to move menu;type=dragable;url=#;");
aI("text=Corporate Overview;url=" + sNonSSLBaseSite + "pages/aboutus/aboutus_overview.php;");
aI("text=Ecessa's Target Market;url=" + sNonSSLBaseSite + "pages/aboutus/aboutus_market.php;");
aI("text=Careers;url=" + sNonSSLBaseSite + "pages/aboutus/aboutus_careers.php;");
aI("text=Contact Us;url=" + sNonSSLBaseSite + "pages/contact/contact_main.php;");
aI("text=Ecessa's History;url=" + sNonSSLBaseSite + "pages/aboutus/aboutus_history.php;");
//aI("showmenu=HOWHELP_SPONSORACHILD;text=sponsor a child;url=" + sNonSSLBaseSite + "pages/howhelp/howhelp_sponsor_child_en.php;");
}
//******************** PRODUCTS ***********************************
with(milonic=new menuname("mm_products")){
//alwaysvisible=1;
//followscroll=1;
//overflow="scroll";  // Do not use scrollbars on this flyout since it can be so close to bottom of page
style=mainMenuStyle;
itemwidth=153;  
top=nflyout_top;
left=nflyout_left;

//aI("align=center;pointer=move;text=drag to move menu;type=dragable;url=#;");
aI("text=Overview;url=" + sNonSSLBaseSite + "pages/products/products_overview.php;");
aI("text=PowerLink;url=" + sNonSSLBaseSite + "pages/products/products_powerlink_pl50.php;");
aI("text=ShieldLink;url=" + sNonSSLBaseSite + "pages/products/products_shieldlink_sl100.php;");
aI("text=PowerLink Demo;url=" + sNonSSLBaseSite + "pages/products/products_powerlinkdemo.php;");
aI("text=ShieldLink Demo;url=" + sNonSSLBaseSite + "pages/products/products_shieldlinkdemo.php;");
aI("text=PowerLink-EDU;url=" + sNonSSLBaseSite + "pages/products/products_powerlink_EDU.php;");
aI("text=ShieldLink-EDU;url=" + sNonSSLBaseSite + "pages/products/products_shieldlink_EDU.php;");
//aI("showmenu=HOWHELP_SPONSORACHILD;text=sponsor a child;url=" + sNonSSLBaseSite + "pages/howhelp/howhelp_sponsor_child_en.php;");
}
//******************** SOLUTIONS ***********************************
with(milonic=new menuname("mm_solutions")){
//alwaysvisible=1;
//followscroll=1;
//overflow="scroll";  // Do not use scrollbars on this flyout since it can be so close to bottom of page
style=mainMenuStyle;
itemwidth=153;  
top=nflyout_top;
left=nflyout_left;

//aI("align=center;pointer=move;text=drag to move menu;type=dragable;url=#;");
aI("text=Overview;url=" + sNonSSLBaseSite + "pages/solutions/solutions_overview.php;");
aI("text=Industry;url=" + sNonSSLBaseSite + "pages/solutions/solutions_industry_landing.php;");
aI("text=Technology;url=" + sNonSSLBaseSite + "pages/solutions/solutions_technology_landing.php;");

//aI("showmenu=HOWHELP_SPONSORACHILD;text=sponsor a child;url=" + sNonSSLBaseSite + "pages/howhelp/howhelp_sponsor_child_en.php;");
}
//******************** PARTNERS ***********************************
with(milonic=new menuname("mm_partners")){
//alwaysvisible=1;
//followscroll=1;
//overflow="scroll";  // Do not use scrollbars on this flyout since it can be so close to bottom of page
style=mainMenuStyle;
itemwidth=153;  
top=nflyout_top;
left=nflyout_left;

//aI("align=center;pointer=move;text=drag to move menu;type=dragable;url=#;");
aI("text=Overview;url=" + sNonSSLBaseSite + "pages/partners/partners_overview.php;");
aI("text=Technology Partners;url=" + sNonSSLBaseSite + "pages/partners/partners_technology.php;");
aI("text=Partner Advantage;url=" + sNonSSLBaseSite + "pages/partners/partners_advantage.php;");
aI("text=Partner Marketing;url=" + sNonSSLBaseSite + "pages/partners/partners_marketing.php;");
aI("text=Partner Application;url=" + sNonSSLBaseSite + "pages/partners/partners_application.php;");
//aI("showmenu=HOWHELP_SPONSORACHILD;text=sponsor a child;url=" + sNonSSLBaseSite + "pages/howhelp/howhelp_sponsor_child_en.php;");
}
//******************** SUPPORT ***********************************
with(milonic=new menuname("mm_support")){
//alwaysvisible=1;
//followscroll=1;
//overflow="scroll";  // Do not use scrollbars on this flyout since it can be so close to bottom of page
style=mainMenuStyle;
itemwidth=153;  
top=nflyout_top;
left=nflyout_left;

//aI("align=center;pointer=move;text=drag to move menu;type=dragable;url=#;");
aI("text=Support Services;url=" + sNonSSLBaseSite + "pages/support/support_services.php;");
aI("text=FAQ;url=" + sNonSSLBaseSite + "pages/support/support_faq_list.php;");
//aI("showmenu=HOWHELP_SPONSORACHILD;text=sponsor a child;url=" + sNonSSLBaseSite + "pages/howhelp/howhelp_sponsor_child_en.php;");
}
//******************** SUPPORT ***********************************
with(milonic=new menuname("mm_news")){
//alwaysvisible=1;
//followscroll=1;
//overflow="scroll";  // Do not use scrollbars on this flyout since it can be so close to bottom of page
style=mainMenuStyle;
itemwidth=153;  
top=nflyout_top;
left=nflyout_left;

//aI("align=center;pointer=move;text=drag to move menu;type=dragable;url=#;");
aI("text=Press Releases;url=" + sNonSSLBaseSite + "pages/news/news_press_releases_list.php;");
aI("text=News Articles;url=" + sNonSSLBaseSite + "pages/news/news_articles_list.php;");
aI("text=Awards;url=" + sNonSSLBaseSite + "pages/news/news_awards.php;");
aI("text=Events;url=" + sNonSSLBaseSite + "pages/news/news_events.php;");
//aI("showmenu=HOWHELP_SPONSORACHILD;text=sponsor a child;url=" + sNonSSLBaseSite + "pages/howhelp/howhelp_sponsor_child_en.php;");
}
	/*with(milonic=new menuname("HOWHELP_SPONSORACHILD")){
	style=subMenuStyle;
	//itemwidth += nSubMenuAdditionalWidthWide;
	aI("text=sponsored children;url=" + sNonSSLBaseSite + "pages/howhelp/howhelp_sponsored_children_en.php;");
	}*/

