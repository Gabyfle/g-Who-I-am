<?php
/**
 * Gets github stats from Github's API
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */

$github_user = "Gabyfle";
$github_token = "";

/**
 * Checking if datas hasn't already been fetched
 */
$datas = file_get_contents("datas/github.txt");
$decoded = json_decode($datas, true);
if (time() - $decoded["lastFetched"] <=  (5 * 3600)) {
    $github_stats = [
        "lastFetched" => $decoded["lastFetched"],
        "githubUsername"    => $decoded["githubUsername"],
        "repos" => $decoded["repos"],
        "languages" => $decoded["languages"]
    ];
} else {
    $get_options  = [
        'http' => [
                'method' => 'GET',
                'header' => [
                        'User-Agent: github-stats (Made by Gabyfle)'
                ]
        ]
    ];
    $context  = stream_context_create($get_options);

    /* Getting repositery number */
    $jsonurl = "https://api.github.com/users/" . $github_user . "?access_token=" . $github_token;
    $json = file_get_contents($jsonurl, false, $context);
    $user = json_decode($json, true);

    $reposNumber = $user["public_repos"];

    /* Getting languages statistics */
    $languages = []; /* Languages stats table */

    $jsonurl = "https://api.github.com/users/" . $github_user . "/repos?access_token=" . $github_token;
    $json = file_get_contents($jsonurl, false, $context);
    $repositeries = json_decode($json, true);

    foreach ($repositeries as $key => $value) {
        $jsonurl = $value["languages_url"] . "?access_token=" . $github_token;
        $json = file_get_contents($jsonurl, false, $context);
        $stats = json_decode($json, true);
        foreach ($stats as $key => $value) {
            $languages[$key] = $languages[$key] + $value;
        }
    }

    $github_stats = [
        "lastFetched" => time(),
        "githubUsername" => $github_user,
        "repos" => $reposNumber,
        "languages" => $languages
    ];

    $flow = fopen("datas/github.txt", "w");
    $status = fwrite($flow, json_encode($github_stats));
}

header('Content-Type: application/json');
echo json_encode($github_stats, JSON_PRETTY_PRINT);