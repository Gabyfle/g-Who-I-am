$(document).ready(function() {
    /**
     * Animating header stuff
     * Principally text and colors
     */
    $("#header").hover(function(){
        $("#big-title").html("$el_gabyflus <span class=\"code-red\">=</span>").addClass("code-white");
        $("#description").html("<span class=\"code-yellow\">\"Fascinated by eye-popping pixels, badly written hieroglyphics, and air bubbles that are much too fresh.\"</span><span class=\"code-white\">;</span>").css("font-family", "Inconsolata");
    }, function() {
        $("#big-title").text("gabyfle").removeClass("code-white");
        $("#description").html("Website of a guy fascinated by eye-popping pixels, badly written hieroglyphics, and air bubbles that are much too fresh.").css("font-family", "Open Sans");
    });


    /*
     *  Get articles
     *  This is a dumb function but it does his job well so, it's alright.
     */
    $.get("https://blog.gabyfle.me/wp-json/wp/v2/posts", function(data) {
        if (data.length != 0) { $("#articles").removeClass("hide") }

        let article = data[0];

        let published = new Date(article["date"]);

        $("#title").text(article["title"]["rendered"]);
        $("#date").text(published.toDateString());

        let content = article["content"]["rendered"];
        
        let max = Math.min(content.length, 250);

        $("#content").html(content.substr(0, max) + "...");      

        $("#more").attr("href", article["link"]);
    });
});