# PHP/Symfony Developer course project
## First project: simple PHP Blog
### First iteration: Blog display
#### Requirements:
**Home page of the blog** will have to list blog posts with the following:
* Title
* Content
* Author
* Publication date

**This project has been made in OOP** so future iterations and components will be easier to plug in.

**Five blog posts will be displayed on each page**, pagination system will have to be included for older posts.

#### Files:
* PHP files:
  * Bootstrap: index.php
  * Controller/BlogController.php
  * Lib
    * SplClassLoader.php
    * Router.php
    * Entity/Post.php
  * Model
    * Model/BlogManager.php
    * Model/PDOFactory.php
  * View
    * 404.php
    * Index.php
    * layout.php
    * SingleView.php
* MySQL files:
  * Database Schema
  * Demo datas

### Second iteration: adding comments
#### Requirements:
**Visitors will be allowed to comment posts. No membership needed.**
They will be authorized the following:
* Nickname (optional)
* Mail (optional)
* Comment (mandatory)

**If the visitor has filled mail adress, the presence of an associated Gravatar will be checked.**

#### Files
**Only changes from iteration 2 will be shown.**
* PHP Files:
  * Lib
    * Entity/Comment.php (added)
* MySQL Files:
  * Database Schema (changed)

*__This file will be updated with actual file names, and with each iteration.__*