<?php

class block_use_course_key extends block_base {

    function init() {
        $this->title = get_string('use_course_key', 'block_use_course_key');
        $this->version = 2009062225;
    }

    function get_content() {
        global $USER, $CFG, $SESSION, $COURSE;

        if (has_capability('block/use_course_key:usecoursekeyblock', get_context_instance(CONTEXT_SYSTEM))) {
            if ($this->content !== null) {
                return $this->content;
            }
            $this->content = new stdClass;
            $this->content->text = '';
            $this->content->footer = '';

            if (empty($this->instance)) {

            } else {
                $courseshown = $COURSE->id;
                $context = get_context_instance(CONTEXT_COURSE, $courseshown);

                if ($courseshown == SITEID) {
                    // Being displayed at site level. This will cause the filter to fall back to auto-detecting
                    // the list of courses it will be grabbing events from.
                    $filtercourse = null;
                    $groupeventsfrom = null;
                } else {
                    // Forcibly filter events to include only those from the particular course we are in.
                    $filtercourse = array($courseshown => $this->page->course);
                    $groupeventsfrom = array($courseshown => 1);
                }

                $msgboxwarning = preg_replace('/[\n\r]/', '\n', get_string("usecoursecodeagreement", "block_use_course_key"));

                $this->content->text = '<form id="course_key_generator" method="get" action="' . $CFG->wwwroot . '/course_keys/use.php"><div>' . '<table>' . '<tr><td colspan="2"><label for="key_code">' . get_string('use_key', 'block_use_course_key') . '</label><br/>' . '<input id="key_code" type="text" name="key_code" /></td></tr>' . '</table></div>' . '<input type="submit" value="' . get_string('use', 'block_use_course_key') . '" />' . '</form>';

                if (optional_param('err_key', false, PARAM_TEXT) == "1")
                    $this->content->text .= '<script type="text/javascript">alert("The key is wrong");</script>';
            }
            return $this->content;
        }
    }
}
?>