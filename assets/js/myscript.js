/**
 * Enum for verdictId -> description
 * @type {Array}
 */
var verdicts = new Array({
    10 : "Submission error",
    15 : "Can't be judged",
    20 : "In queue",
    30 : "Compile error",
    35 : "Restricted function",
    40 : "Runtime error",
    45 : "Output limit",
    50 : "Time limit",
    60 : "Memory limit",
    70 : "Wrong answer",
    80 : "PresentationE",
    90 : "Accepted",
});

/**
 * Get problem's title by id
 * @param  {int}    problemId   problem's id
 * @return {string}             problem's title
 */
function getProblemTitle(problemId) {
    var url = "http://uhunt.felix-halim.net/api/p/" + problemId;
    $.getJSON(url, function (response) {
        return response.title;
    });
}

/**
 * Get user's last submitted problem's information
 * @param  {int}    userId   user's id
 * @return {Array}           assoc array of required info
 */
function getLastInfo(userId) {
    var url = "http://uhunt.felix-halim.net/api/subs-user-last/" + userId + "/1";
    $.getJSON(url, function (response) {
        // response's first index
        var subs = response.subs[0];

        var problemTitle = getProblemTitle(subs[1]);
        var verdict = verdicts[ subs[2] ];
        var date = new Date().setSeconds(subs[4]);

        // construct required data in assoc. array
        var data = new Array({
            "problemTitle" : problemTitle,
            "verdict" : verdict,
            "time" : moment().format("dd.mm.yyyy hh:MM:ss"),
        });
        return data;
    });
}

/**
 * Get user's base information by userId
 * @param  {int}    userId  user's id
 * @return {Array}          assoc array of required info
 */
function getBaseInfo(userId) {
    var url = "http://uhunt.felix-halim.net/api/ranklist/" + userId + "/0/0";
    $.getJSON(url, function (response) {
        var user = response[0];

        var rank = user.rank;
        var name = user.name;
        var totalAccept = user.ac;
        var totalSubmit = user.nos;

        var data = new Array({
            "name": user.name,
            "username": user.uname,
            "acccept": user.ac,
            "submit": user.nos,
            "rank": user.rank,
        });
        return data;
    });
}

/**
 * Get userId by username and continue to get other info by id
 * @param  {string} username
 * @return {int}    user's id
 */
function getUserInfoByUsername(username) {
    var url = "http://uhunt.felix-halim.net/api/uname2uid/" + username;
    $.getJSON(url, function (response) {
        var userId = response;
        // console.log(userId);
        var base = getBaseInfo(userId);
        var last = getLastInfo(userId);

        console.log(base.name + " " + last.title);
    });
}

$(document).ready(function () {
    // getUserInfoByUsername("rud_bast");
});
