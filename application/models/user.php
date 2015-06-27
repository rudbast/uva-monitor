<?php

/**
 * User model containing a list of informations
 *
 * @package default
 * @author  rudolf
 **/
class User extends CI_Model {

    // basic user information
    /**
     * Name of user
     * @var string
     */
    private $_name;

    /**
     * Username
     * @var string
     */
    private $_uname;

    /**
     * Total of accepted submissions
     * @var int
     */
    private $_totalAccept;

    /**
     * Total of submissions
     * @var int
     */
    private $_totalSubmit;

    /**
     * Rank of user
     * @var int
     */
    private $_rank;

    // latest user activity information
    /**
     * Title of the latest submitted problem
     * @var string
     */
    private $_problemTitle;

    /**
     * Result of the latest submitted problem
     * @var string
     */
    private $_verdict;

    /**
     * Time of the latest submitted problem
     * @var datetime
     */
    private $_time;

    /**
     * User's object constructor
     * @param string    $name
     * @param string    $uname
     * @param int       $totalAccept
     * @param int       $totalSubmit
     * @param int       $rank
     * @param string    $problemName
     * @param string    $verdict
     * @param datetime  $time
     */
    public function __construct(
        $name,
        $uname,
        $totalAccept,
        $totalSubmit,
        $rank,
        $problemName,
        $verdict,
        $time) {

        $this->_name = $name;
        $this->_uname = $uname;
        $this->_totalAccept = $totalAccept;
        $this->_totalSubmit = $totalSubmit;
        $this->_rank = $rank;
        $this->_problemTitle = $problemTitle;
        $this->_verdict = $verdict;
        $this->_time = $time;
    }

    /**
     * Set value of any instance member
     * @param mixed $name  member instance
     * @param mixed $value value to be set for member instance
     */
    public function __set($name, $value) {
        $this->$name = $value;
    }

    /**
     * Get value of any instance member
     * @param  mixed $name member instance
     * @return mixed       member instance's value
     */
    public function __get($name) {
        return $this->$name;
    }

} // END class User extends CI_Model