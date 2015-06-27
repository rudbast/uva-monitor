<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Testing Thread operation
 *
 * @package default
 * @author  rudolf
 **/
class AsyncOperation extends Thread {

    private $username;
    private $data;

    public function __construct($username) {
        $this->username = $username;
    }

    public function run() {
        if ($this->username) {
            $this->data = $this->getInfoByUsername($this->username);
        }
    }

    public function getData() {
        $this->start();
        while ($this->isRunning()) {
            usleep(100);
        }
        return $this->data;
    }

    /**
     * Get information by username using user id
     * @param  string $username username
     * @return mixed            assoc. array of user's info
     */
    public function getInfoByUsername($username) {
        $uri = "http://uhunt.felix-halim.net/api/uname2uid/".$username;
        $response = json_decode(file_get_contents($uri));

        $baseInfo = $this->getBaseInfoByUserId($response);
        $lastInfo = $this->getLastInfoByUserId($response);

        return array_merge($baseInfo, $lastInfo);
    }

    /**
     * Get the base information by user id
     * @param  int      $userId user's id
     * @return array            assoc. array of base user's info
     */
    public function getBaseInfoByUserId($userId) {
        $uri = "http://uhunt.felix-halim.net/api/ranklist/".$userId."/0/0";
        $response = json_decode(file_get_contents($uri), TRUE);

        $user = $response[0];
        $data = array(
            "name"      => $user["name"],
            "username"  => $user["username"],
            "acccept"   => $user["ac"],
            "submit"    => $user["nos"],
            "rank"      => $user["rank"],
        );
        return $data;
    }

    /**
     * Verdicts result enum
     * @var array
     */
    private $verdicts = array(
        10 => "Submission error",
        15 => "Can't be judged",
        20 => "In queue",
        30 => "Compile error",
        35 => "Restricted function",
        40 => "Runtime error",
        45 => "Output limit",
        50 => "Time limit",
        60 => "Memory limit",
        70 => "Wrong answer",
        80 => "PresentationE",
        90 => "Accepted",
    );

    /**
     * Get the last submitted information by user id
     * @param  int      $userId user's id
     * @return array            assoc. array
     */
    public function getLastInfoByUserId($userId) {
        $uri = "http://uhunt.felix-halim.net/api/subs-user-last/".$userId."/1";
        $response = json_decode(file_get_contents($uri), TRUE);

        $subs = $response["subs"][0];
        $problemTitle = $this->getProblemTitleById($subs[1]);
        $verdict = $this->verdicts[ $subs[2] ];
        $time = new DateTime();
        $time->setTimestamp($subs[4]);

        $data = array(
            "title"     => $problemTitle,
            "verdict"   => $verdict,
            "time"      => $time->format('d-M-Y H:i:s'),
        );
        return $data;
    }

    /**
     * Get problem title by problem id
     * @param  int      $problemId  problem's id
     * @return string               problem's title
     */
    public function getProblemTitleById($problemId) {
        $uri = "http://uhunt.felix-halim.net/api/p/id/".$problemId;
        $response = json_decode(file_get_contents($uri), TRUE);

        return $response["title"];
    }

} // END class AsyncOperation extends Thread