<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scoreboard extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $userlist = array(
            "bounces",
            // "rud_bast",
            // "erhemdiputra",
            // "jansonh",
            // "FlixHK",
            // "hobert",
            // "michaleona",
            // "exxe",
            // "blueazrael",
            // "geralmcz",
            // "danieal",
            // "Andre_Tirta",
            // "debora_mlnd",
            // "CheeseStick",
            // "Raokiray",
            // "D3w1",
            // "Caledfwlch",
            // "omg0394",
            // "xybil",
            // "Eagle Vision",
            // "Adorian",
        );

        $infos = array();
        $workers = array();

        foreach ($userlist as $username) {
            // $worker = new AsyncOperation($username);
            // $infos[] = $worker;
            $infos[] = $this->getInfoByUsername($username);
        }

        // load view
        $this->load->view('scoreboard', array(
            "infos" => $infos,
        ));
    }

    /**
     * Get information by username using user id
     * @param  string $username username
     * @return mixed            assoc. array of user's info
     */
    public function getInfoByUsername($username) {
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

}
