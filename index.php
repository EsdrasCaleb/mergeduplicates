<?php

require('../../../config.php');

global $CFG;
global $PAGE;
global $SESSION;
global $DB;

// Report all PHP errors
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once($CFG->libdir . '/blocklib.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/accesslib.php');
require_once($CFG->libdir . '/weblib.php');


require_login();
require_capability('tool/mergeusers:mergeusers', context_system::instance());

admin_externalpage_setup('tool_mergeduplicates_merge');

$do = optional_param('do', null, PARAM_INT);

$duplicatesusers = $DB->get_records_sql("SELECT username from 
(SELECT username,count(id) as total from {user} where suspended=0 group by username) as con where total>1");
$mut = new MergeUserTool();
$logsid = array();
$renderer = $PAGE->get_renderer('tool_mergeduplicates');
echo $renderer->localheader();
if($do){
    foreach($duplicatesusers as $dup){
        $users = $DB->get_records_sql("SELECT * from {user} where username = '{$dup->username}' and suspended=0 order by id");
        $primeiro = true;
        $userTomerge;
        foreach($users as $user){
            if($primeiro){
                $userTomerge = $user;
                $primeiro = false;
            }
            else{
                $log = array();
                $success = true;
                list($success, $log, $logid) = $mut->merge($userTomerge->id, $user->id); //to user, from user
                echo $renderer->results_page($userTomerge, $user, $success, $log, $logid);
            }

        }
    }
}
else{
    echo $renderer->index_page(count($duplicatesusers));
}
echo $renderer->page_end();
