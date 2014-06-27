<?php
  /**
   * Defines the AgedGate page type
   */

	class AgeGatedPage extends Page {

		private static $db = array();

		private static $has_one = array();

		function getCMSFields() {
			$fields = parent::getCMSFields();  //get all the fields...
			return $fields;
		}
	}

    class AgeGatedPage_Controller extends Page_Controller {
		public function init() {

			$ageMonth = Cookie::get('bmonth');
			$ageDay = Cookie::get('bday');
			$ageYear = Cookie::get('byear');
			$age = Cookie::get('age');
			$allowed_urls = array('/age-gate/');
			if($age == NULL) {
				if(!$this->isSearchEngine()){
				    if(!in_array($_SERVER['REQUEST_URI'], $allowed_urls)) {
				    	Session::set('AgeGateBackURL', urlencode($_SERVER['REQUEST_URI']));
                        $this->redirect(Director::absoluteBaseURL()."age-gate/");
				    }

				}
			} else {
				if(!in_array($_SERVER['REQUEST_URI'], $allowed_urls)) {
					if($ageMonth == NULL || $ageDay == NULL || $ageYear == NULL) {
					    if(!in_array($_SERVER['REQUEST_URI'], $allowed_urls)) {
					        Session::set('AgeGateBackURL', urlencode($_SERVER['REQUEST_URI']));
					    }
						$this->redirect(Director::absoluteBaseURL()."age-gate/");
					}
				}
			}

			parent::init();
		}

		public function isSearchEngine(){
			$isSearchEngine = Session::get('isSearchEngine');
			if($isSearchEngine == NULL) {

	            $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	            $all_agents = array("google","googlebot","msnbot","yahoo","facebook", "abcdatos","acme-spider","ahoythehomepagefinder","Alkaline","anthill","appie","arachnophilia","arale","araneo","araybot","architext","aretha","ariadne","arks","aspider","atn","atomz","auresys","backrub","bayspider","bbot","bigbrother","bjaaland","blackwidow","blindekuh","Bloodhound","borg-bot","boxseabot","brightnet","bspider","cactvschemistryspider","calif","cassandra","cgireader","checkbot","christcrawler","churl","cienciaficcion","cmc","Collective","combine","confuzzledbot","coolbot","cosmos","cruiser","cusco","cyberspyder","cydralspider","desertrealm","deweb","dienstspider","digger","diibot","directhit","dnabot","download_express","dragonbot","dwcp","e-collector","ebiness","eit","elfinbot","emacs","emcspider","esculapio","esther","evliyacelebi","nzexplorer","fastcrawler","fdse","felix","ferret","fetchrover","fido","finnish","fireball","fish","fouineur","francoroute","freecrawl","funnelweb","gama","gazz","gcreep","getbot","geturl","golem","grapnel","griffon","gromit","gulliver","gulperbot","hambot","harvest","havindex","hometown","wired-digital","htdig","htmlgobble","hyperdecontextualizer","iajabot","iconoclast","Ilse","imagelock","incywincy","informant","infoseek","infoseeksidewinder","infospider","inspectorwww","intelliagent","irobot","iron33","israelisearch","javabee","JBot","jcrawler","askjeeves","jobo","jobot","joebot","jubii","jumpstation","kapsi","katipo","kdd","kilroy","ko_yappo_robot","labelgrabber.txt","larbin","legs","linkidator","linkscan","linkwalker","lockon","logo_gif","lycos","macworm","magpie","marvin","mattie","mediafox","merzscope","meshexplorer","MindCrawler","mnogosearch","moget","momspider","monster","motor","muncher","muninn","muscatferret","mwdsearch","myweb","NDSpider","netcarta","netmechanic","netscoop","newscan-online","nhse","nomad","northstar","objectssearch","occam","octopus","OntoSpider","openfind","orb_search","packrat","pageboy","parasite","patric","pegasus","perignator","perlcrawler","phantom","phpdig","piltdownman","pimptrain","pioneer","pitkow","pjspider","pka","plumtreewebaccessor","poppi","portalb","psbot","Puu","python","raven","rbse","resumerobot","rhcs","rixbot","roadrunner","robbie","robi","robocrawl","robofox","robozilla","roverbot","rules","safetynetrobot","scooter","search_au","search-info","searchprocess","senrigan","sgscout","shaggy","shaihulud","sift","simbot","site-valet","sitetech","skymob","slcrawler","slurp","smartspider","snooper","solbot","speedy","spider_monkey","spiderbot","spiderline","spiderman","spiderview","spry","ssearcher","suke","suntek","sven","sygol","tach_bw","tarantula","tarspider","tcl","techbot","templeton","titin","titan","tkwww","tlspider","ucsd","udmsearch","uptimebot","urlck","valkyrie","verticrawl","victoria","visionsearch","voidbot","voyager","vwbot","w3index","w3m2","wallpaper","wanderer","wapspider","webbandit","webcatcher","webcopy","webfetcher","webfoot","webinator","weblayers","weblinker","webmirror","webmoose","webquest","webreader","webreaper","webs","websnarf","webspider","webvac","webwalk","webwalker","webwatch","wget","whatuseek","whowhere","wlm","wmir","wolp","wombat","worm","wwwc","wz101","xget","Nederland.zoek", "integrity");
	            $isSearchEngine = false;
	            foreach ($all_agents as $agent) {
	            	if (stripos($ua, $agent) !== false) {
	            		$isSearchEngine = true;
	            		break;
	            	}
	            }
	           Session::set('isSearchEngine', $isSearchEngine);

			}
			return $isSearchEngine;
		}

		public function AgeGateBackURL(){
	        return Session::get('AgeGateBackURL');
	    }

    }
