# Fountain Framework

## Description:
Fountain is a framework based on MVC, it's a framework to everyone.

## Installation
Only download the respositroy in the root directory and it's ready for use.

## Use
It's to easy this Framework, this is the project tree:

root/  
├── src/  
│  ├─ Controllers/  
│  └─ Css/  
│  └─ Js/  
│  └─ Views/  
├── Engine/  
│  └─ Core/  
│  └─ Utils/  
│&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└── Apis/  
├── Plugins/  

 ### SRC DIRECTORY

This is the most importants files.
  - Controllers
  - Css
  - Js
  - Views

If you have a page called "?Ctrl=Menu" the file names are this:
  - Controllers: Menu/Index.php
  - Css: Menu/Index.css
  - Js: Menu/Index.js
  - Views: Menu/Index.php

This is other example with Do "?Ctrl=Menu&Do=Login":
  - Controllers: Menu/Login.php
  - Css: Menu/Login.css
  - Js: Menu/Login.js
  - Views: Menu/Login.php

And fountain have a 3th: Action (It uses for ajax) "?Ctrl=Menu&Do=Login&Action=Auth":
  - Controllers: Menu/Login.php -> function Auth(){}
  - Css: Menu/Login.php
  - Js: Menu/Login.js
  - Views: Menu/Login.php

### ENGINE DIRECTORY
#### CORE DIRECOTORY
In this directory we have HTML class and the interfaces for IController, IView, ImportMVC, this is the same 
#### UTILS DIRECOTORY
In the utils we have the basics of the page, Head, Header, Footer etc...  
And the other is api, in this directory is the jquery, boostrap, etc...  

      

## Contribute  
I need your help to push up the project. You can create a repository with the plugins based on Fountain.

## Contact
Alejandro Fuentes Pardo  
beeguespark@gmail.com  
[Project URL: [https://github.com/begues12/fountain)](https://github.com/begues12/fountain)
