function setClass()
{
  $("ul.dhtmlgoodies_tree") // Find all unordered lists with class of "tv"
  .find("li:last-child").addClass("tvil").end(); // Apply class "TVIL aka TreeView Item - Last"
}
$(document).ready(function() {
  

	treeObj = new JSDragDropTree();
	treeObj.setTreeId('dhtmlgoodies_topNodes');
	
	treeObj.imageFolder = '/js/drag-drop-folder-tree/images/';
	treeObj.filePathAddItem = '/tree/category_new';
	treeObj.filePathRenameItem = '/tree/category_rename';
	treeObj.filePathDeleteItem = '/tree/category_delete';
	
	treeObj.setMaximumDepth(20);
	treeObj.setMessageMaximumDepthReached('Maximum depth reached'); // If you want to show a message when maximum depth is reached, i.e. on drop.
	treeObj.initTree();
	treeObj.expandAll(); 
	
	
	setClass();
});