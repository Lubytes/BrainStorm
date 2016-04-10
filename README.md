# BrainStorm
The final project for INFX 2670

INFX 2670 – Project Proposal

Group Project Report - Brainstorm

Brandon Poole - Johna Latouf - Chaoran Zhou

Brainstorm is a micro-blogging site that allows users to create mind-maps. Users can create an account that includes a bio, profile image, and display name. They can create, manage, and join groups. They can follow other users and view those users' latest posts.

Posts are laid out using jsPlumb (https://jsplumbtoolkit.com), a javascript library. Users cannot see posts in groups that they do not belong to. Users can reply to posts, delete their own posts, and rank posts with a voting system. Admin users can delete other users and anyone's posts.

Planning, database design, testing was done by all group members

Known Bugs:
* If you access the site without logging in, some features are unavailable, others don't work. For instance, if you try to reply/rank a post, nothing gets added to the database, but there is no message telling you to log in.
* The jsPlumb selectors have had some issues finding all posts (causing some posts to be positioned at the top or the page without their connectors), although they appear to be working correctly now. 
* The Logout button is not lined up in the posts page. 
* The account page shows individual posts from private groups that should be hidden. 
* Admin users cannot see private posts. 
* If you go to profile.php and set uID= to a non-existent user, you just get a blank profile page.
None of these bugs affect the core functionality of our project. Many of them are just instances that exist, but cannot harm our site or database.
