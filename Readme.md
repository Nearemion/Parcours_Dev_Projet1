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
  * index.php (modified)
  * Controller\BlogController.php (modified)
  * Lib
    * Entity
      * Comment.php (added)
      * Post.php (modified)
    * Form
      * Field.php (added, abstract class)
      * FormType.php (added, form builder)
      * Input.php (added)
      * Textarea.php (added)
    * Hydrator.php (Hydrating trait form Entities and Fields)
  * Model\BlogManager.php (modified)
  * View
    * CommentForm.php (added)
    * layout.php (modified)
    * SingleView.php (updated)
* MySQL Files:
  * Database Schema (updated)
  * Demo datas (updated)

### Third iteration: Admin space
#### Requirements:
**Admin pages will be in protected space, like a sub-folder "/admin" protected with any method deemed suitable.**
Administration will allow:
* Adding, editing and deleting blog posts
* Comment moderation

**Comment moderation will take two options:** validation prior to publication, or suppression/edition after publication.
An option will be accessible in the admin space to chose the preferred way.

#### Files
**Only changes from iteration 3 will be shown.**
* PHP Files:
* MySQL Files:

*__This file will be updated with actual file names, and with each iteration.__*