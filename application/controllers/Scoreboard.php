<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scoreboard extends CI_Controller {

    /**
     * Index page controller
     */
    public function index() {
        require_once 'UvaTools.php';
        $this->load->library('table');

        $tool = new UvaTools();
        $this->constructTableData($tool->getData());

        // load view
        $this->load->view('scoreboard', array(
            "table" => $this->table,
        ));
    }

    /**
     * Construct table using CI Table Library
     * @param  array $infos assoc. array containing extracted user informations
     */
    private function constructTableData($infos) {
        $template = array(
            'table_open' => '<table class="table table-striped table-hover">',
        );
        $this->table->set_template($template);

        $this->table->set_heading(
            "#", "Name", "Username", "Accepted", "No. of Submission", "Rank",
            // "Last Submission",
            "Problem", "Verdict", "Date Time"
        );
        $i = 1;
        foreach ($infos as $info) {
            $data = array($i++);
            foreach ($info as $key => $value) {
                $data[] = $value;
            }
            $this->table->add_row($data);
        }
    }

}
