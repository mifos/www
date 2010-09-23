/* $Id: README.txt,v 1.2 2010/08/30 01:22:28 ohnobinki Exp $ */
-- Fork --

This module is a fork of the module http://drupal.org/project/checkout and has 
been nearly completely reweritten since then

-- SUMMARY --
This module implements a pessimistic locking strategy, which means that content
will be exclusively locked whenever a user starts editing it.  The lock will be
automatically released when the user submits the form or navigates away from
the edit page.

Users may also permanently lock content, to prevent others from editing it.  
Content locks that have been "forgotten" can be automatically released after a
configurable time span.

For a full description visit the project page:
  http://drupal.org/project/content_lock
Bug reports, feature suggestions and latest developments:
  http://drupal.org/project/issues/content_lock


-- INSTALLATION --

1. Install as usual, see http://drupal.org/node/70151 for further information.

2. Configure user permissions at User management >> Permissions:

   check out documents - This enables content locking when a user starts
     editing it.  Note that even without this permission, users are still
     able to edit contents, they're just not protected against concurrent
     edits.

   keep documents checked out - Whether to allow users to keep content locked
     across edits.  This will enable a similar named checkbox on the content
     edit form.

   administer checked out documents - View and release locked contents of all
     users.  This enables the administrative tab on Content management >>
     Content.  Note that even without this permission, users can manage their
     own content locks on their profile page.

3. Configure the module at Content management >> Post settings.

   Show lock / unlock message - Make content_lock more verbose, informing a
     user when he locks a node and about his inconsideration when he visits
     one node while he has kept another node locked.

   Add cancel button - Adds a link in a node's edit form to cancel the edit,
     letting the user intentionally navigate away from the Edit page without
     being asked for confirmation by a javascript dialog.

-- CREDITS --
Current authors:
Eugen Mayer http://drupal.org/user/108406
Nathan Phillip Brink http://drupal.org/user/108406


Original authors:
Stefan M. Kudwien
Joël Guesclin
