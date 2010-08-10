// menu_data.js version 1.01

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
_subOffsetTop=-1;             	// 4 Sub menu top offset from bottom of image associated with it
_subOffsetLeft=1;            	// 5 Sub menu left offset

// MAIN STYLE
with(mainMenuStyle=new mm_style()){
onbgcolor="#66b5da";			// hover background color  
offbgcolor="#88b9cf";			// normal (non-hover) background color  
offcolor="#ffffff";				// normal (non-hover) text color  
oncolor="#ffffff";				// hover text color  
offclass="mmpadding";			// custom style attached to menu
onclass="mmpadding";			// custom style attached to menu
bordercolor="#6cb6d8";			// border color #B59973
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
pagebgcolor="#88b9cf"; 			// this is the (non-hover) background color of the menu item last clicked #D2B48C
pagecolor="#ffffff";  			// this is the (non-hover) text color of the menu item last clicked 
separatorcolor="#6cb6d8";		// separator color #D2B48C
separatorsize="1";
subimage="/sites/all/themes/monsterzen/milonic/arrow.gif";
subimagepadding="6";
subimageposition="right";
}
// SUBLEVEL STYLE
with(subMenuStyle=new mm_style()){
onbgcolor="#71a23a";			// hover background color  
offbgcolor="#99c36a";			// normal (non-hover) background color  
offcolor="#ffffff";				// normal (non-hover) text color  
oncolor="#ffffff";				// hover text color  
offclass="mmpadding";			// custom style attached to menu
onclass="mmpadding";			// custom style attached to menu
bordercolor="#71a23a";			// border color #B59973
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
pagebgcolor="#99c36a"; 			// this is the (non-hover) background color of the menu item last clicked #D2B48C
pagecolor="#ffffff";  			// this is the (non-hover) text color of the menu item last clicked 
separatorcolor="#80ad4d";		// separator color #D2B48C
separatorsize="1";
subimage="/sites/all/themes/monsterzen/milonic/arrow.gif";
subimagepadding="6";
subimageposition="right";
}

// mjf 7/22/10 : make blog a flyout menu item
/*
with(milonic=new menuname('mm_blog')){ 
		//alwaysvisible=1; 
		//followscroll=1; 
		//overflow='scroll';  
		style=mainMenuStyle; 
		//itemwidth=200; 
		top=nflyout_top; 
		left=nflyout_left; 
aI("text=News Log;url=/?q=blog;");
}
*/

