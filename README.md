# CMPUT-391-Project

There must be a file misc/dbpass.php of the form:

$username = "XX";
$password = "XXXX";

This file will NOT be put in the repository for obvious reasons

We use Oracle 11 for a DBMS

edit icon:

http://thenounproject.com/term/edit/22190/

delete icon:

http://thenounproject.com/term/delete/61554/


## Architecture:

It's important to note that there is a .htaccess file in all folders except style and images that DENY ALL. The php files 
in those folders are not meant to be executed by themselves.

At the top level we have a series of pseudo controllers that display a view and control a model. Each
PHP file corresponds to an actual page that can be visited.

In models there are a series of classes corresponding to tables in the database.

Each one contains methods for updating and inserting a row and other utilities

## Views

In views there is actual HTML and displaying that is subcategorized into lists and forms. Templates holds all data that shows
on all or most pages

To use a view we write:

$content = "/path/to/view.php";
include('views/templates/template.php');

A title must also be set.

At the top of each file the required variables will be stated. But for brevity each form can be given a $message which allows you 
to report errors and successes.

## Controllers

In controllers there are a series of files that handle applying changes to a model and determining if they are valid or not.

Their distinction with views gets fuzzy because they return error messages.

## Utils

Utils contains a series of files that are used nearly everywhere including database connection, building forms and validation tools

## Images and Style

These contain images and CSS respectively. 

