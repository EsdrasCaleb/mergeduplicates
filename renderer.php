<?php 

defined('MOODLE_INTERNAL') || die();

class tool_mergeduplicates_renderer extends plugin_renderer_base{
    public function index_page($duplicatenumber)
    {
        $output = html_writer::start_div();
        $output .= get_string('numberduplicates', 'tool_mergeduplicates',$duplicatenumber);
        $output .= html_writer::end_div();
        $returnurl = new moodle_url('/admin/tool/mergeduplicates/index.php',array('do'=>1));
        $returnbutton = new single_button($returnurl, get_string('merge', 'tool_mergeduplicates'));
        if($duplicatenumber>0){
            $output .= $this->output->render($returnbutton);
        }
        return $output;
    }
    
    public function localheader(){
        $output = $this->header();
        $output .= $this->heading_with_help(get_string('mergeduplicates', 'tool_mergeduplicates'), 'header', 'tool_mergeduplicates');
        return $output;
    }
    
    public function results_page($to, $from, $success, array $data, $logid)
    {
        if ($success) {
            $resulttype = 'ok';
            $dbmessage = 'dbok';
            $notifytype = 'notifysuccess';
        } else {
            $transactions = (tool_mergeusers_transactionssupported()) ?
                    '_transactions' :
                    '_no_transactions';

            $resulttype = 'ko';
            $dbmessage = 'dbko' . $transactions;
            $notifytype = 'notifyproblem';
        }


        $output = html_writer::empty_tag('br');
        $output .= html_writer::start_tag('div', array('class' => 'result'));
        $output .= html_writer::start_tag('div', array('class' => 'title'));
        $output .= get_string('merging', 'tool_mergeusers');
        if (!is_null($to) && !is_null($from)) {
            $output .= ' ' . get_string('usermergingheader', 'tool_mergeusers', $from) . ' ' .
                    get_string('into', 'tool_mergeusers') . ' ' .
                    get_string('usermergingheader', 'tool_mergeusers', $to);
        }
        $output .= html_writer::empty_tag('br') . html_writer::empty_tag('br');
        $output .= get_string('logid', 'tool_mergeusers', $logid);
        $output .= html_writer::empty_tag('br');
        $output .= get_string('log' . $resulttype, 'tool_mergeusers');
        $output .= html_writer::end_tag('div');
        $output .= html_writer::empty_tag('br');

        $output .= html_writer::start_tag('div', array('class' => 'resultset' . $resulttype));
        foreach ($data as $item) {
            $output .= $item . html_writer::empty_tag('br');
        }
        $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');
        $output .= html_writer::tag('div', html_writer::empty_tag('br'));
        $output .= $this->notification(html_writer::tag('center', get_string($dbmessage, 'tool_mergeusers')), $notifytype);
        return $output;
    }
    public function page_end(){
        $output = $this->footer();
        return $output;
    }
}