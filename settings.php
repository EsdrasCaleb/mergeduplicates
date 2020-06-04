<?php 
defined('MOODLE_INTERNAL') || die;

if (has_capability('tool/mergeusers:mergeusers', context_system::instance())) {
    if (!$ADMIN->locate('tool_mergeduplicates')) {
        $ADMIN->add('accounts',
            new admin_externalpage('tool_mergeduplicates_merge', get_string('pluginname', 'tool_mergeduplicates'),
                $CFG->wwwroot . '/' . $CFG->admin . '/tool/mergeduplicates/index.php'),'tool/mergeduplicates:merge');
    }
}