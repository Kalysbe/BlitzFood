/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.uiColor = '#AADC6E';
	
	//config.uploadFolder = 'http://www.kse.kg/files/'; // сообщаем плагину куда будем заливать фото
	
	config.filebrowserBrowseUrl = '/scripts/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = '/scripts/kcfinder/browse.php?type=images';
       config.filebrowserFlashBrowseUrl = '/scripts/kcfinder/browse.php?type=flash';
       config.filebrowserUploadUrl = '/scripts/kcfinder/upload.php?type=files';
       config.filebrowserImageUploadUrl = '/scripts/kcfinder/upload.php?type=images';
       config.filebrowserFlashUploadUrl = '/scripts/kcfinder/upload.php?type=flash';
};
