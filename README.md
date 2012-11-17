HMAjaxStrategy
==============

Version 0.1 Created by Nicholas Huot

Introduction
--------------

HMAjaxStrategy was designed to easily allow users to make ajax calls to their application without loading the layout. It was designed to be plug & play without needing any modification to the existing code base. 

What It Does
--------------

The module simply checks for XmlHttpRequest headers by using $request->isXmlHttpRequest. For any calls made with ajax, the module grabs the ViewModel prior to being injected into the View object, and sets the _terminate property to true. 

Installation
--------------

### Main Setup

#### By cloning project

1. Clone this project into your `./vendor/` directory.

#### With composer

Coming Soon...

#### Post installation

1. Enabling it in your `application.config.php`file.

    ```php
    <?php
    return array(
        'modules' => array(
            // ...
            'HMAjaxStrategy',
        ),
        // ...
    );
    ```
	
Post Installation
-----------------

Simply create an ajax call to something in your application.

### Example

	```JavaScript
	<script type="text/javascript">
		jQuery(function(){
			jQuery('#myModal').on('show',function(){
			});
		});
	</script>
	```
	
	```Php
	//Add this to the layout.phtml file in the Skeleton Application
	<a href="<?php $this->basePath(); ?>/application" class="btn" data-toggle="modal" data-target=".modal">Login</a>
	<div class="modal hide fade">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Modal header</h3>
	  </div>
	  <div class="modal-body">
		<p>One fine body…</p>
	  </div>
	  <div class="modal-footer">
		<a href="#" class="btn">Close</a>
		<a href="#" class="btn btn-primary">Save changes</a>
	  </div>
	</div>
	```
	
You should notice that the menu and footer of the them are not rendered with the application. Disable the module to see the difference in how it is rendered. 