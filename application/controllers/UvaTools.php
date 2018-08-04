<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Tools to get data from urls
 *
 * @package default
 * @author  rudolf
 **/
class UvaTools {

    /**
     * Username list
     * @var array
     */
    private $userlist = array(
        "erhemdiputra",
        "debora_mlnd",
        "rud_bast",
        "stenlytw",
        "Caledfwlch",
        "jansonh",
        "FlixHK",
        "michaleona",
        "exxe",
        "blueazrael",
        "geralmcz",
        "Eagle Vision",
        "danieal",
        "Andre_Tirta",
        "CheeseStick",
        "hobert",
        "Raokiray",
        "D3w1",
        "omg0394",
        "xybil",
        "Adorian",
    );

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
     * Main function, get user data
     * @return array table
     */
    public function getData() {
        $infos = array();
        $rank = array();
        // $workers = array();

        foreach ($this->userlist as $username) {
            // $worker = new AsyncOperation($username);
            // $infos[] = $worker;
            $infos[] = $this->getInfoByUsername($username);
            $rank[$username] = end($infos)["rank"];
        }

        // sort data by user's rank
        array_multisort($rank, SORT_ASC, $infos);
        return $infos;
    }

    /**
     * Get information by username using user id
     * @param  string $username username
     * @return mixed            assoc. array of user's info
     */
    private function getInfoByUsername($username) {
        $uri = "http://uhunt.felix-halim.net/api/uname2uid/".urlencode($username);
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
    private function getBaseInfoByUserId($userId) {
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
     * Get the last submitted information by user id
     * @param  int      $userId user's id
     * @return array            assoc. array
     */
    private function getLastInfoByUserId($userId) {
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
    private function getProblemTitleById($problemId) {
        $uri = "http://uhunt.felix-halim.net/api/p/id/".$problemId;
        $response = json_decode(file_get_contents($uri), TRUE);

        return $response["title"];
    }

} // END class UvaTools
