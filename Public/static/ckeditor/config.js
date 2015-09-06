/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config ) {
	config.language = 'zh-cn'; 
	config.width = '99.7%'; 
	
		config.height = '450px';
	
	
	//	  config.fullPage = true;//允许包含html标签
	
		
	
		//  config.allowedContent = true;
	
	
	config.font_names='宋体/宋体;黑体/黑体;仿宋/仿宋_GB2312;楷体/楷体_GB2312;隶书/隶书;幼圆/幼圆;微软雅黑/微软雅黑;'+ config.font_names;
	config.image_previewText='&nbsp;';
	config.toolbar_default = [
	   
	  
	    
	    ['Source','Bold','Italic','Underline','Strike','-','Format'],
	    ['TextColor','BGColor'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	  
	    ['Image','Flash','Link','Unlink'],
	    ['Cut','Copy','-','SpecialChar'],
	    ['Undo','Redo','-','Find','Replace','-']
	];
	
	//,'Font','FontSize'
	
	
//	config.toolbar_default = [
//	                  		['Source','-','Templates','Preview'],
//	                  	    ['Cut','Copy','Paste','PasteText','PasteFromWord','-'],
//	                  	    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],['ShowBlocks'],['Image','Flash','Capture'],['Maximize'],
//	                  	    '/',
//	                  	
//	                  	    ['Subscript','Superscript','-'],
//	                  	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
//	                  	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
//	                  	    ['Link','Unlink','Anchor'],
//	                  	    ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
//	                  	    '/',
//	                  	    ['Bold','Italic','Underline','Strike','-'],
//	                  	    ['Styles','Format','Font','FontSize'],
//	                  	    ['TextColor','BGColor']
//	                  	];
//	
	config.toolbar = 'default';
	
		//config.filebrowserBrowseUrl = config.ckfinderPath+'/ckfinder.html?type=files&start=files:'+config.ckfinderUploadPath;
	//	config.filebrowserImageBrowseUrl = config.ckfinderPath+'/ckfinder.html?type=images&start=images:'+config.ckfinderUploadPath;
	//	config.filebrowserFlashBrowseUrl = config.ckfinderPath+'/ckfinder.html?type=flash&start=flash:'+config.ckfinderUploadPath;
		config.filebrowserUploadUrl = config.ckfinderPath+'/core/connector/java/connector.java?command=QuickUpload&type=files&currentFolder='+config.ckfinderUploadPath;
//		config.filebrowserImageUploadUrl = config.ckfinderPath+'/core/connector/java/connector.java?command=QuickUpload&type=images&currentFolder='+config.ckfinderUploadPath;
	//	config.filebrowserFlashUploadUrl = config.ckfinderPath+'/core/connector/java/connector.java?command=QuickUpload&type=flash&currentFolder='+config.ckfinderUploadPath;
		
		// 图片上传配置  
	    config.filebrowserUploadUrl = '/waone/admin.php?s=/Addons/execute/_addons/EditorForAdmin/_controller/Upload/_action/ck_upimg';  
	    config.filebrowserImageUploadUrl  =  '/waone/admin.php?s=/Addons/execute/_addons/EditorForAdmin/_controller/Upload/_action/ck_upimg';
	    config.filebrowserFlashUploadUrl = '/CmsSite/a/cms/file/ckupload?type=Flash&channel=2';  
	    
	    // 图片浏览配置  
	    config.filebrowserImageBrowseUrl = '/waone/admin.php?s=/Addons/execute/_addons/ImageManager/_controller/ImageManager/_action/ImageManager&viewtype=ckeditor'; 
		config.filebrowserWindowWidth = '1000';
		config.filebrowserWindowHeight = '700';
		 //从word中粘贴内容时是否移除格式plugins/pastefromword/plugin.js
		 config.pasteFromWordRemoveStyle =true;
		 
		 config.forcePasteAsPlainText =true//不去除
	
};
CKEDITOR.stylesSet.add( 'default', [
	/* Block Styles */
	{ name : '首行缩进'	, element : 'p', styles : { 'text-indent' : '20pt' } },
	/* Inline Styles */
	{ name : '标注黄色'	, element : 'span', styles : { 'background-color' : 'Yellow' } },
	{ name : '标注绿色'	, element : 'span', styles : { 'background-color' : 'Lime' } },
	/* Object Styles */
	{ name : '图片左对齐', element : 'img', attributes : { 'style' : 'padding: 5px; margin-right: 5px', 'border' : '2', 'align' : 'left' } },
	{ name : '图片有对齐', element : 'img', attributes : { 'style' : 'padding: 5px; margin-left: 5px', 'border' : '2', 'align' : 'right' } },
	{ name : '无边界表格', element : 'table', styles: { 'border-style': 'hidden', 'background-color' : '#E6E6FA' } }
]);
