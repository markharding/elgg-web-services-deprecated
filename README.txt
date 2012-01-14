Elgg Web Services
=================

The Elgg web services are essentially RPC web services the output can be requested as JSON as well as XML. These web services are based on Elgg's web services API.

### Making a web services call

Any call to the web services can be made by calling the URL

	```
	<site URL>/services/api/rest/<outpput type>/?method=<method name>
	```
Here <site URL> : the path of root directory of Elgg website
	 <outpput type> : json or xml
	 <method name> : the name of the remote method you want to call
	 
Other parameters need to be passed by GET or POST depending on the type of web services is being requested. 

Getting Started
--------------------

### Configuration
	
These web services can be enabled or disabled depending on requirement. Any web services can be disabled or enabled from
 "Web Services" in Admin settings.

List of Web Services
--------------------

Below are a list of all the methods that can be called.

### Core

 * site.test - Heartbeat method to test whether web services are up
 * site.get_info - Get basic information about this Elgg site
 * site.get_info - Find out if the elgg site is running the OAuth plugin
 * site.river_feed		    Get river feed

### User

 * user.get_profile_fields          Get profile fields
 * user.get_profile                 Get profile information
 * user.save_profile              Update profile information
 * user.get_user_by_email           Get all users registered with an email ID
 * user.check_username_availability Check availability of username
 * user.register                    Register user	
 * user.friend.add                  Add a user as a friend
 * user.friend.remove               Remove a user from friend	
 * user.friend.get_friends          Get friends of a user
 * user.friend.get_friends_of       Obtains the people who have made a given user a friend

### Blog

 * blog.save_post         Make a blog post
 * blog.get_post          Read a blog post	
 * blog.delete_post       Delete a blog post
 * blog.get_friends_posts  Get latest blog post by friends
 * blog.get_latest_posts Latest blog post by a user or by all user
 
### Group

 * group.join                  Joining a group
 * group.leave                 Leaving a group
 * group.forum.save_post       Posting a new topic to a group
 * group.forum.delete_post     Deleting a topic from a group
 * group.forum.get_latest_post Get latest post in a group
 * group.forum.get_reply     Get replies on a post
 * group.forum.save_reply    Post a reply
 * group.forum.delete_reply    Delete a reply

### Wire

 * wire.save_post        Making a wire post
 * wire.get_posts         Read latest wire post of user
 * wire.get_friends_posts Read latest wire post by friends
 * wire.delete_posts Read latest wire post by friends

 
### File

 * file.get_files    Get file list by all users or a pecific user
 * file.get_files_by_friend Get file list by friends