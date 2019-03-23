$(document).ready(function() {
    /**
     * Animating header stuff
     * Principally text and colors
     */
    $("#header").hover(function(){
        $("#big-title").html("$Gabriel_Santamaria <span style=\"color: #f92472 !important;\">=</span>").css("color","#FFFFFF");
        $("#description").html("\"Passionné de pixels, de hiéroglyphes, et de bulles d'air\"<span style=\"color: #FFFFFF !important;\">;</span>").css("color","#e7db74").css("font-family", "Inconsolata");
    }, function() {
        $("#big-title").text("Gabriel Santamaria").css("color","#ac80ff");
        $("#description").html("Le site internet d'un passionné <small>(de plus)</small> de pixels, de hiéroglyphes, et de bulles d'air").css("color","#FFFFFF").css("font-family", "Open Sans");
    });
});

/**
 * Getting repos number from Github
 */
function getUserData(user)
{
    var url = 'includes/steam_stats.php';
    jQuery.getJSON(url, function(json){
        var ownedGames = json.totalGames;
        var totalHours = json.totalHours;
        $("#ownedGames").html(ownedGames + "<span style=\"color:#FFF;\">,</span>");
        $("#totalHours").html(Math.floor(totalHours / 60) + "<span style=\"color:#FFF;\">,</span>");
    });
}
getUserData("Gabyfle");