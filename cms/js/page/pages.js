"use strict";

/**
 * get drag and drop working
 */
var dropkick_cms_app = dropkick_cms_app || {};

dropkick_cms_app.page = {};
dropkick_cms_app.page.pages = {};

//===========================================================================>
/**
 * page object
 */
function page() {
}

/**
 * render the page and components
 */
page.prototype.render = function() {
	
	//all the rows that need to be draggable
	jQuery('article.pages ul.page_list li.draggable_page').draggable(
		{
			"axis": "y",
			"cancel": ".table_code", //page codes not draggable
			"containment": jQuery( 'article.pages ul.categories' ),
			"snap": true
		}
	);
	
	//targets for dragged rows
	jQuery('article.pages ul.categories li.droppable').droppable(
		{
			"drop": function(evnt, ui) {
				
				var self = this;
				
				//make sure cant drag on self
				if (jQuery(self).data("category_id") != ui.draggable.data("category_id")) {
					
					var category_id = jQuery(self).data("category_id");
					var page_id     = ui.draggable.data("page_id");
				
					jQuery.post(
						"libs/ajax.php",
						{ "action": "category_page_move", "category_id": category_id, "page_id": page_id },
						function(data) {
						}
					);
					
					ui.draggable.data('category_id', category_id );
					
					ui.draggable.css( 'top', '0px' );
					
					jQuery( 'ul.page_list', jQuery(self) ).append( ui.draggable );
				}
			},
			
			"hoverClass": "hover" 
		}
	);
};

//===========================================================================>
/**
 * wire up
 */
dropkick_cms_app.page.pages = new page();

dropkick_cms_app.page.pages.render();
