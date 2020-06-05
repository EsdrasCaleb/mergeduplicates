# mergeduplicates
a simple plugin to merge duplicate user(same username) in moodle

This plugin depends on the merge user account plugin.

Its a simple script that search for duplicate usernames and merge them. 
It can be used when you let the option of admin conflict on and import a course that duplicate usernames.

This can happen when you copy a moodle from one place to another and one person make an account in the 2 system after this.

If you import a course from one copied moodle to another the site_hash id will be the same and it will search from users
with the same username and id to merge. 

Some people to avoid this problem mark the option resolve admin conflict, what makes another problem that is duplicate users

this plugin solves this
