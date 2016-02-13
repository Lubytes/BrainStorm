<?php

    #
    # ESTABLISHING A SESSION
    # 
    # Sessions are initiated by using the session_start() function, they can also be
    # customized to only pertain to particular paths in the URL, to expire at a 
    # particular time, and to be named by a custom name (other than the default
    # PHPSESSID).
    #

	//session_set_cookie_params(0, '/~username/', 'web.cs.dal.ca');
	//session_name('ClassDemoPages');
	session_start();


	#
	# TERMINATING A SESSION
	#
	# To fully destroy the information stored in a session requires a few steps:
	#
	# 1) unset the information that has been stored in the $_SESSION array so that 
	#    it is not available to the rest of the script.
	# 2) Expire the cookie that has been holding the session identifier by setting
	#    it to a date in the past.
	# 3) Destroy the information that is stored in the session file on the server.
	#
	
	unset($_SESSION['user_data']);
	setcookie(session_name(), '', time() - 86400);
	session_destroy();


	#
	# HEADERS
	#
	# When setting headers, ensure that there is no output (including whitespace) before the 
	# call to the header function. If there is output present, the header function will fail.
	#
	
	header ("Location: index.php");

?>