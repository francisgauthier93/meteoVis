<script type="text/javascript" charset="utf-8" src="JSrealB/static/js/JSrealB.js"></script>
<script type="text/javascript" src="JSrealB/static/js/jquery-latest.min.js"></script>
<script type="text/javascript" src="JSrealB/static/js/jquery-ui.min.js"></script>
 <script type="text/javascript">
 var URL = {
                lexicon:  {
                    fr: "JSrealB/data/lex-fr.min.json",
                    en: "JSrealB/data/lex-en.min.json"
                },
                rule: {
                    fr: "JSrealB/data/rule-fr.min.json",
                    en: "JSrealB/data/rule-en.min.json"
                },
                feature: "JSrealB/data/feature.min.json"
            };

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
                
             	var jsonFile = 
				<?php
                	$jsonString = file_get_contents('public/data/jsreal-realization-instruction.json');
                	$data = json_decode($jsonString, true);
                	echo $data["testPhrase2"]; 
					//echo var_dump($data);
                ?>
                
                var phrase = 
                <?php 
                	$jsonString = file_get_contents('public/data/additional-info-phrases.json');
                	$phrases = json_decode($jsonString, true);
                	
					$phrases7 = "[";
					for($i=0;$i<7;$i++){
						if($i==0){
							$phrases7 =  $phrases7 . "\"" . $phrases[$i]. "\"";
						}else{
							$phrases7 =  $phrases7 . ",\"" . $phrases[$i] . "\"";
						}
						
					}
                	echo "$phrases7]";
                ?>

                for(var i=1; i<8; i++){
                	$("#forecastTable tr:eq("+i+")").append("<td>"+eval(phrase[i-1])+"</td>");
                }
    			
            });
</script>
// <?php
// class addInfo{
// 	protected $meteo;

// 	public function __construct($meteo)
// 	{
// 		$this->oMeteoCode = $meteo;
// 	}
// 	function getAdditionalInfo(){
// 		return NP(D("le"),N("souris"));
// 	}
// }
// ?>
