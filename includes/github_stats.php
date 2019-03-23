<?php
/**
 * Gets github stats from Github's API
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */

$github_user = "Gabyfle";

$get_options  = [
    'http' => [
            'method' => 'GET',
            'header' => [
                    'User-Agent: Gabyfle'
            ]
    ]
];
$context  = stream_context_create($get_options);

$jsonurl = "https://api.github.com/users/" . $github_user . "/repos";
$json = file_get_contents($jsonurl, false, $context);
$repositeries = json_decode($json, true);

$totalLines = 0;
$addedLines = 0;
$deletedLines = 0;

foreach ($repositeries as $id => $value) {
    $repo_name = $value["name"];
    $jsonurl = "https://api.github.com/repos/" . $github_user . "/" . $repo_name . "/commits";    
    $json = file_get_contents($jsonurl, false, $context);
    $commits = json_decode($json, true);

    foreach ($commits as $id => $value) {
        $sha = $value["sha"];
        $jsonurl = "https://api.github.com/repos/" . $github_user . "/" . $repo_name . "/commits/" . $sha;
        $json = file_get_contents($jsonurl, false, $context);
        $datas = json_decode($json, true);
        /* Adding lines to vars */
        $totalLines = $totalLines + $datas["stats"]["total"];
        $addedLines = $addedLines + $datas["stats"]["additions"];
        $deletedLines = $deletedLines + $datas["stats"]["deletions"];
    }
}

$github_stats = [
    "githubUsername" => $github_user,
    "totalLines" => $totalLines,
    "addedLines" => $addedLines,
    "deletedLines" => $deletedLines
];
header('Content-Type: application/json');
echo json_encode($github_stats, JSON_PRETTY_PRINT);