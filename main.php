<?php 

/*
 *plugin name: Extended Membership (Comments Scheduler)
 *author: Mahibul Hasan Sohag
 *plugin url: http://naturalcommentschedular.com/
 *author url: http://naturalcommentschedular.com/
 *description: (S2Membership must be activated before using it) It works with the S2 membership plugin to exntend the membership and makes suitable for the Comments Scheduler Plugin
 */

define("MCPMMEMBERSHIP_DIR", dirname(__FILE__));
define("MCPMMEMBERSHIP_FILE", __FILE__);

include MCPMMEMBERSHIP_DIR . '/classes/mcp-registration.php';
mcp_registration::init();

include MCPMMEMBERSHIP_DIR . '/classes/membership-checking.php';
mcp_membership_contrer::init();

?>