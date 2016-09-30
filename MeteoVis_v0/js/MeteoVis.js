// paramètres initiaux
//var currNbJours=6;
var currLang = "fr";

// conversion d'affichage des degrés
// attention: on arrondit et on peut perdre des décimales après plusieurs conversions...
function c2f(c) {
    return Math.round(c * 9 / 5 + 32)
}
function f2c(f) {
    return Math.round((f - 32) * 5 / 9)
}

function updateTooltipCelsius()
{
    var newContent = $("<div>").html($(this).attr("data-title"))
            .find(".celsius").toggleClass("celsius farenheit").parent().html();
    $(this).attr("data-title", newContent);
    $(this).tooltip()
            .attr('data-original-title', newContent)
            .tooltip('fixTitle');
}

function fromCelsius() {
    $(".celsius").text(function (i, e) {
        return c2f(parseFloat(e.replace(',', '.')));
    });
    $(".celsius").toggleClass("celsius farenheit");
    $(".temperature").each(updateTooltipCelsius);
    $(".accumCond").each(updateTooltipCelsius);
    $(".windCond").each(updateTooltipCelsius);
    $("svg text tspan.svgcelsius").each(function () {
        $(this).text(c2f(parseFloat($(this).text().replace(',', '.'))) + "°F");
    });
}

function updateTooltipFarenheit()
{
    var newContent = $("<div>").html($(this).attr("data-title"))
            .find(".farenheit").toggleClass("celsius farenheit").parent().html();
    $(this).attr("data-title", newContent);
    $(this).tooltip()
            .attr('data-original-title', newContent)
            .tooltip('fixTitle');
}

function fromFarenheit() {
    $(".farenheit").text(function (i, e) {
        return f2c(parseFloat(e));
    });
    $(".farenheit").toggleClass("celsius farenheit");
    $(".temperature").each(updateTooltipFarenheit);
    $(".accumCond").each(updateTooltipFarenheit);
    $(".windCond").each(updateTooltipFarenheit);
    $("svg text tspan.svgcelsius").each(function () {
        $(this).text(f2c(parseFloat($(this).text().replace('.', ','))) + "°C");
    });
}

function setLanguage(l1, $button) {
    var l2 = l1 == 'fr' ? 'en' : 'fr';
    $('.' + l2).hide();
    $('.' + l1).show();
    if ($button != null)
        $button.text(l2);
    currLang = l1;
    // cacher les options du dessin qui ne sont pas sélectionnés
    if (!$("#temperature").is(":checked"))
        $(".temperature." + l1).hide()
    // patcher le placeholder que je n'arrive pas à faire avec le code de langue habituel
    $("#inVille").attr("placeholder", l1 == "fr" ? "Changer de ville" : "Change city");

}

// condition qui dépend aussi de la langue
function setTemperature($cb) {
    setCondition("temperature", true);
}
//Accumulation
function setAccumulation($cb) {
    setCondition("accumCond", true);
}
// Vent
function setWind($cb) {
    setCondition("windCond", true);
}
// condition qui ne dépend pas de la langue
function setCondition(condName, isLangDep) {
    if ($("#" + condName).is(":checked"))
        $("." + condName + (isLangDep ? ("." + currLang) : "")).show();
    else
        $("." + condName + (isLangDep ? ("." + currLang) : "")).hide();
}
// initialisation et mise en place des listeners

$(document).ready(function () {
    // installation du tableau de suggestion des noms de villes

    var villes = [];
    var regions;
    regions = (currLang == "fr" ? regionsFr : regionsEn);
    for (var k in regions)
    {

        villes.push(k);
    } // ne garder que les clés
    // adapté de http://twitter.github.io/typeahead.js/examples/

    $('#inVille').typeahead(
            {hint: true, highlight: true, minLength: 1},
    {name: 'villes',
        displayKey: "value",
        source: function (q, cb) {
            var matches, substringRE;
            matches = [];
            if (q.substr(0, 2) == "st" || q.substr(0, 2) == "St") {
                substringRE = new RegExp('^s(ain)?(\.| |-)?' + q.substr(1), 'i');
            } else
                substringRE = new RegExp('^' + q, 'i');
            $.each(villes, function (i, str) {
                if (substringRE.test(str)) {
                    matches.push({value: str});
                }
            });
            var matchesSorted = matches.sort(compare);
            cb(matchesSorted.slice(0, 10));
            //alert(matches[0].value);
        }
    });
    function compare(a, b)
    {
        if (a.value < b.value)
            return -1;
        if (a.value > b.value)
            return 1;
        return 0;
    }



    // adapté de http://stackoverflow.com/questions/9425024/submit-selection-on-bootstrap-typeahead-autocomplete
    $('#inVille').on('typeahead:selected', function (e) {
        var villeSelectionnee = $('#inVille').val();
        var prov = regions[villeSelectionnee][0];
        var ville = regions[villeSelectionnee][1];
        var id02 = regions[villeSelectionnee][2];
        var id37 = regions[villeSelectionnee][3];
        var code = regions[villeSelectionnee][4];
        var province = regions[villeSelectionnee][5];
        $('#prov').val(prov);
        $('#ville').val(ville);
        $('#inVille');
        $('#id02').val(id02);
        $('#id37').val(id37);
        $('#code').val(code);
        $('#province').val(province);

        e.target.form.submit();
    })

    //  peut-être intéressant si on sort avec tab... mais génère souvent trop de submits
    // .blur(function(e) { 
    //           window.setTimeout(function(){e.target.form.submit()}, 50)
    //       });
    // installation des tooltips sur les éléments de temperature 
    $('.temperature').tooltip({
        trigger: 'hover click',
        html: true,
        container: 'body'
    });
    $('.accumCond').tooltip({
        trigger: 'hover click',
        html: true,
        container: 'body'
    });
    $('.windCond').tooltip({
        trigger: 'hover click',
        html: true,
        container: 'body'
    });

    //// traitement des boutons à bascule
    // l'unité des degrés de température
    $('#degres').click(function () {
        var d = $(this).text();
        if (d == "°F") {
            fromCelsius();
            $(this).text("°C")
        } else {
            fromFarenheit();
            $(this).text("°F");
        }
    })
    // affichage selon la langue
    $('#lang').click(function () {
        setLanguage($(this).text(), $(this));

    });


    // afficher selon la langue de défaut
    setLanguage(currLang, null);

    // changement du nombre de jours
    $('#nbjours select').change(function (e) {
        currNbJours = $(this).val();
        afficher_nbr_jour($(this).val());
    });
    function afficher_nbr_jour(NbJour) {
        // Elargir le graphique
        $("#graphique").attr("width", (NbJour * 150) + "px");
        
        var $trs = $('#prevision-texte tr');
        $trs.each(function (i, e) {
            if (i < NbJour+1) // +1 for title
                $(this).show();
            else
                $(this).hide();
        });
    }
    afficher_nbr_jour(currNbJours);

    /// traitement des checkbox
    $('#temperature').change(function () {
        setTemperature($(this));
    });
    setTemperature($('#temperature'));
    
    //accumulation
    $('#accumCond').change(function () {
        setAccumulation($(this));
    });
    setAccumulation($('#accumCond'));
    
    //vent
    $("#windCond").change(function () {
        setWind($(this))
    });
    setWind($('#windCond'));
    
    //precipitation
    $("#precipCond").change(function () {
        setCondition("precipCond", false)
    });
    
    //cloud cover
    $("#cloudCond").change(function () {
        setCondition("cloudCond", false)
    });
});
