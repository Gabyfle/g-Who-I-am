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

    /**
     * Animating stats stuff
     * Colors, texts, etc...
     */
    var texts = [];
    $("#stats").hover(function(){
        $("#stats-title").html("<span style=\"color:#f92472;\">local</span> Statistiques {");
        $("#stats").find("h3").each(function(index) {
            texts[index] =  $(this).text();
            $(this).html("[<span style=\"color:#e7db74;\">\"" + $(this).text() + "\"</span>] <span style=\"color: #f92472 !important;\">=</span>")
        });
        $("#stats").find("p").html("<span style=\"color:#74705d;\">-- Voici ce que je fais sur mon temps libre :kappa:</span>").css("font-family", "Inconsolata");
        $("#hiddenBracket").css("visibility", "visible");
    }, function() {
        $("#stats-title").text("Statistiques");
        $("#stats").find("h3").each(function(index) {
            $(this).text(texts[index]);
        });
        $("#stats").find("p").text("Voici ce que je fais sur mon temps libre :kappa:").css("font-family", "Open Sans");
        $("#hiddenBracket").css("visibility", "hidden");
    });
});

/**
 * Getting repos number from Github
 */
function getUserData(user)
{
    var url = 'https://api.github.com/users/' + user;
    jQuery.getJSON(url, function(json){
        var repos = json.public_repos;
        if (json.message != "Not Found"){
            $("#repos").text(repos);
        } else{
            $("#repos").text("N/A");
        }
    });
}
getUserData("Gabyfle");