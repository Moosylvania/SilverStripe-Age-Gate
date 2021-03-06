<?php

namespace Moosylvania\AgeGate\Middlewares;


use SilverStripe\Control\Cookie;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Control\Middleware\HTTPMiddleware;

class AgeGateMiddleware implements HTTPMiddleware{

    protected function isSearchEngine(HTTPRequest $request){
        $session = $request->getSession();
		$isSearchEngine = $session->get('isSearchEngine');
		if($isSearchEngine == NULL) {
            $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
            $all_agents = array("google","googlebot","msnbot","yahoo","facebook","FBAN","bitlybot","twitter","abcdatos","acme-spider","ahoythehomepagefinder","Alkaline","anthill","appie","arachnophilia","arale","araneo","araybot","architext","aretha","ariadne","arks","aspider","atn","atomz","auresys","backrub","bayspider","bbot","bigbrother","bjaaland","blackwidow","blindekuh","Bloodhound","borg-bot","boxseabot","brightnet","bspider","cactvschemistryspider","calif","cassandra","cgireader","checkbot","christcrawler","churl","cienciaficcion","cmc","Collective","combine","confuzzledbot","coolbot","cosmos","cruiser","cusco","cyberspyder","cydralspider","desertrealm","deweb","dienstspider","digger","diibot","directhit","dnabot","download_express","dragonbot","dwcp","e-collector","ebiness","eit","elfinbot","emacs","emcspider","esculapio","esther","evliyacelebi","nzexplorer","fastcrawler","fdse","felix","ferret","fetchrover","fido","finnish","fireball","fish","fouineur","francoroute","freecrawl","funnelweb","gama","gazz","gcreep","getbot","geturl","golem","grapnel","griffon","gromit","gulliver","gulperbot","hambot","harvest","havindex","hometown","wired-digital","htdig","htmlgobble","hyperdecontextualizer","iajabot","iconoclast","Ilse","imagelock","incywincy","informant","infoseek","infoseeksidewinder","infospider","inspectorwww","intelliagent","irobot","iron33","israelisearch","javabee","JBot","jcrawler","askjeeves","jobo","jobot","joebot","jubii","jumpstation","kapsi","katipo","kdd","kilroy","ko_yappo_robot","labelgrabber.txt","larbin","legs","linkidator","linkscan","linkwalker","lockon","logo_gif","lycos","macworm","magpie","marvin","mattie","mediafox","merzscope","meshexplorer","MindCrawler","mnogosearch","moget","momspider","monster","motor","muncher","muninn","muscatferret","mwdsearch","myweb","NDSpider","netcarta","netmechanic","netscoop","newscan-online","nhse","nomad","northstar","objectssearch","occam","octopus","OntoSpider","openfind","orb_search","packrat","pageboy","parasite","patric","pegasus","perignator","perlcrawler","phantom","phpdig","piltdownman","pimptrain","pioneer","pitkow","pjspider","pka","plumtreewebaccessor","poppi","portalb","psbot","Puu","python","raven","rbse","resumerobot","rhcs","rixbot","roadrunner","robbie","robi","robocrawl","robofox","robozilla","roverbot","rules","safetynetrobot","scooter","search_au","search-info","searchprocess","senrigan","sgscout","shaggy","shaihulud","sift","simbot","site-valet","sitetech","skymob","slcrawler","slurp","smartspider","snooper","solbot","speedy","spider_monkey","spiderbot","spiderline","spiderman","spiderview","spry","ssearcher","suke","suntek","sven","sygol","tach_bw","tarantula","tarspider","tcl","techbot","templeton","titin","titan","tkwww","tlspider","ucsd","udmsearch","uptimebot","urlck","valkyrie","verticrawl","victoria","visionsearch","voidbot","voyager","vwbot","w3index","w3m2","wallpaper","wanderer","wapspider","webbandit","webcatcher","webcopy","webfetcher","webfoot","webinator","weblayers","weblinker","webmirror","webmoose","webquest","webreader","webreaper","webs","websnarf","webspider","webvac","webwalk","webwalker","webwatch","wget","whatuseek","whowhere","wlm","wmir","wolp","wombat","worm","wwwc","wz101","xget","Nederland.zoek", "integrity");
            $isSearchEngine = false;
            foreach ($all_agents as $agent) {
            	if (stripos($ua, $agent) !== false) {
            		$isSearchEngine = true;
            		break;
            	}
            }
            if($isSearchEngine){
                $session->set('isSearchEngine', true);
            }

		}
		return $isSearchEngine;
	}

	protected function AgeGateBackURL(){
        return Session::get('AgeGateBackURL');
    }

    public function process(HTTPRequest $request, callable $delegate)
    {
        $age = Cookie::get('moosylvaniaAgeGateOfAge');
        $session = $request->getSession();
        $isSearchEngine = $this->isSearchEngine($request);

        if($age == NULL && $request->getURL() != 'age-gate' && !$request->isPOST() && !$request->isAJAX() && !$isSearchEngine) {
            $session->set('AgeGateBackURL', $_SERVER['REQUEST_URI']);
            $url = Director::absoluteBaseURL()."age-gate";
            $urlParts = explode('?', $_SERVER['REQUEST_URI']);

            if(count($urlParts)>1){
                $url .= "?".$urlParts[1];
            }

            $response = HTTPResponse::create();
            $response = $response->redirect($url, 302);

		} else if(($age || $isSearchEngine) && $request->getURL() == 'age-gate'){
            $session = $request->getSession();
            $response = HTTPResponse::create();
            if($session->get('AgeGateBackURL') && strpos($session->get('AgeGateBackURL'), '/age-gate') !== 0){
                $response = $response->redirect($session->get('AgeGateBackURL'), 302);
            } else {
                $response = $response->redirect('/', 302);
            }
        } else {
            $response = $delegate($request);
        }

        return $response;
    }
}
