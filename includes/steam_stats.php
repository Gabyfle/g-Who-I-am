<?php
/**
 * Gets steam stats from Steam's API
 * @author Gabriel Santamaria <gaby.santamaria@outlook.fr>
 */
$steam_api = "";
$steam_id = "76561198127516196";

/**
 * Checking if datas hasn't already been fetched
 */
$datas = file_get_contents("datas/steam.txt");
$decoded = json_decode($datas, true);
if ($decoded["lastFetched"] - time() <= 1800) {
    $steam_stats = [
        "lastFetched" => $decoded["lastFetched"],
        "steamid"    => $decoded["steamid"],
        "totalGames" => $decoded["totalGames"],
        "totalHours" => $decoded["totalHours"]
    ];
} else {
    $jsonurl = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=" . $steam_api . "&steamid=" . $steam_id . "&format=json";
    $json = file_get_contents($jsonurl);
    $decoded = json_decode($json, true);
    
    $totalGames = $decoded["response"]["game_count"];
    $totalHours = 0;
    /**
     * Sum of all hours per game
     */
    foreach ($decoded["response"]["games"] as $key => $value) {
        $totalHours = $totalHours + $value["playtime_forever"];
    }

    $steam_stats = [
        "lastFetched" => time(),
        "steamid"    => $steam_id,
        "totalGames" => $totalGames,
        "totalHours" => $totalHours
    ];

    $flow = fopen("datas/steam.txt", "w");
    $status = fwrite($flow, json_encode($steam_stats));
}

header('Content-Type: application/json');
echo json_encode($steam_stats, JSON_PRETTY_PRINT);