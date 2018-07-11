/**
 * Every rich text editor plugin is expected to come with a wysiwyg.js file,
 * and should follow the same structure.
 *
 * This makes sure there is consistency among multiple RTE plugins.
 */
if (typeof Vamshop.Wysiwyg == 'undefined') {
	// Vamshop.uploadsPath and Vamshop.attachmentsPath is set from Helper anyways
	Vamshop.Wysiwyg = {
		uploadsPath: Vamshop.basePath + 'uploads/',
		attachmentsPath: Vamshop.basePath + 'file_manager/attachments/browse'
	};
}

/**
 * This function is called when you select an image file to be inserted in your editor.
 */
Vamshop.Wysiwyg.choose = function(url, title, description) {

};

/**
 * Returns boolean value to indicate an editor within the page has been modified
 */
Vamshop.Wysiwyg.isDirty = function() {
}

/**
 * Reset dirty indicator for all editors in the page
 */
Vamshop.Wysiwyg.resetDirty = function() {
}

/**
 * This function is responsible for integrating attachments/file browser in the editor.
 */
Vamshop.Wysiwyg.browser = function() {
};

if (typeof jQuery != 'undefined') {
	$(document).ready(function() {
		Vamshop.Wysiwyg.browser();
	});
}
