/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

let xhr = new XMLHttpRequest();
xhr.open('GET', "../../../build/entrypoints.json", false);
xhr.send();

var baseFile = JSON.parse(xhr.responseText);
var cssFile = baseFile.entrypoints.app.css[0];

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.allowedContent = true;
	config.baseHref = '/';
	config.bodyClass = 'no-js cms-viewer';
	config.contentsCss = cssFile;
	config.defaultLanguage = 'fr';
	config.emailProtection = 'encode';
	config.entities = false;
	config.extraAllowedContent = 'i(*)';
	config.extraPlugins = 'codemirror,templates,video,widget';
	config.height = 300;
	// config.startupMode = 'source';
};

CKEDITOR.dtd.$removeEmpty['i'] = false;
