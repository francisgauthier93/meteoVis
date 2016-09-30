<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Realisation avec JSrealB pour MeteoVis</title>
        <meta charset="UTF-8">
		<script src="../JSrealB/static/js/JSrealB.js" charset="UTF-8"></script>
		<script type="text/javascript">
			var URL = {
                lexicon:  {
                    fr: "../JSrealB/data/lex-fr.min.json",
                    en: "../JSrealB/data/lex-en.min.json"
                },
                rule: {
                    fr: "../JSrealB/data/rule-fr.min.json",
                    en: "../JSrealB/data/rule-en.min.json"
                },
                feature: "../JSrealB/data/feature.min.json"
            };

    // JSrealLoader({
    //             language: "fr",
    //             lexiconUrl: URL.lexicon.fr,
    //             ruleUrl: URL.rule.fr,
    //             featureUrl: URL.feature
    //         }, function() {
    //             console.log("Langue française chargée");
    //         });
		</script>
	</head>
	<body>
		<h2>
			Début des tests
		</h2>
		<div id="temperature">
			
		</div>
		<div id="id">
			<script type="text/javascript">
				
			JSrealLoader({
                language: "fr",
                lexiconUrl: URL.lexicon.fr,
                ruleUrl: URL.rule.fr,
                featureUrl: URL.feature
            }, function() {
                console.log("Langue française chargée");

                //Ajouts aux lexique:
                JSrealB.Config.get("lexicon")["partiellement"] = {"Adv": {"tab": ["av"]}};
                JSrealB.Config.get("lexicon")["nuageux"] = {"A": {"tab": ["n54"]}};
                JSrealB.Config.get("lexicon")["alternance"] = {"N": {"g":"f","tab": ["n17"]}};


	            var phrase = eval(<?php
				$json = file_get_contents("jsrealb-realizations.json");
				$jdecod = json_decode($json, TRUE);
				echo json_encode($jdecod["testPhrase"]); ?>)

				document.getElementById("id").innerHTML = phrase;//S(Pro('je'),VP(V('aimer'),NP(D('le'),N('pomme'))));

				var temperature = <?php
				$json = file_get_contents("jsrealb-realizations.json");
				$jdecod = json_decode($json, TRUE);
				$phrase = $jdecod["fr"]["startDay"];
				echo json_encode($phrase); ?>

				var cloudCover = <?php
				$cloudCover =  3;
				function getCloudCoverText($coverValue){
					global $jdecod;

					$ccv = $jdecod["fr"]["cloudCond"]["alternative"]["cloud-cover-value"];
					for($i=1; $i<count($ccv); $i++){
						if($ccv[$i]["min"] > $coverValue){
							return $ccv[$i-1]["text"];
						}
					}
					return $ccv[count($ccv)-1]["text"];
				}
				echo json_encode(getCloudCoverText($cloudCover));
				?>

				var tempMinMax = <?php
				$json = file_get_contents("jsrealb-realizations.json");
				$jdecod = json_decode($json, TRUE);
				$p = $jdecod["fr"]["conjAnd"] . "," . $jdecod["fr"]["startTemp"];
				echo json_encode($p);
				?>

				var tempMin = "17";
				var tempMax = "29"; //Afin de tester

				var tP = "Allo *|les|* amis.";
				var nos = "nos";
				var regExp = /\*\|([a-z\-]+)\|\*/gi;
				var regExp1 = /\*\|([a-z\-]+)\|\*/i;
				// tP= tP.replace(regExp,nos);
				// document.getElementById("temperature").innerHTML = tP;
				temperature = temperature.replace(regExp,cloudCover);
				tempMinMax = tempMinMax.replace(regExp1,tempMin);
				tempMinMax = tempMinMax.replace(regExp1,tempMax);
				var texte = temperature + "," + tempMinMax;
				 texte = "S("+texte+")";
				 console.log(texte);
				// document.getElementById("temperature").innerHTML = eval(temperature);
				 document.getElementById("temperature").innerHTML = eval(texte);
	            });
			
			</script>
		</div>
	</body>
</html>

