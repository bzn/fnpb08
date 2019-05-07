var TREE_FORMAT =
[
//0. left position
	0,
//1. top position
	0,
//2. show +/- buttons
	false,
//3. couple of button images (collapsed/expanded/blank)
	["/images/tree/c.gif", "/images/tree/e.gif", "/images/tree/b.gif"],
//4. size of images (width, height,ident for nodes w/o children)
	[16,16,16],
//5. show folder image
	true,
//6. folder images (closed/opened/document)
	["/images/tree/menu_point1.gif", "/images/tree/menu_point2.gif", "/images/tree/menu_point3.gif"],
//7. size of images (width, height)
	[12,9],
//8. identation for each level [0/*first level*/, 16/*second*/, 32/*third*/,...]
	[4,14,24,34],
//9. tree background color ("" - transparent)
	"",
//10. default style for all nodes
	"clsNode",
//11. styles for each level of menu (default style will be used for undefined levels)
	["menu1","menu2","menu3"],//["clsNodeL0","clsNodeL1","clsNodeL2","clsNodeL3","clsNodeL4"],
//12. true if only one branch can be opened at same time
	false,
//13. item pagging and spacing
	[0,1],
];
