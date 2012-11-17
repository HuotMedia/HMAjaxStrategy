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