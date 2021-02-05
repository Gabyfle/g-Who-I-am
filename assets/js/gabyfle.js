$(document).ready(function() {
    /*
     *  Get articles
     *  This is a dumb function but it does his job well so, it's alright.
     */
    $.get("https://blog.gabyfle.me/wp-json/wp/v2/posts", function(data) {
        if (data.length != 0) { $("#articles").removeClass("hide") }
        else { return } // no articles

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