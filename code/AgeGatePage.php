<?php
  /**
   * Defines the AgeGate page type
   */

    class AgeGatePage extends Page
    {

        public static $db = array(

         );

        public static $has_one = array(

        );

        public static $allowed_children = array(
         );

        public static $can_be_root = true;

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();
            return $fields;
        }
    }

    class AgeGatePage_Controller extends Page_Controller
    {

        public function init()
        {
            Cookie::set('age', 'true', 30, '/');
            parent::init();
            $userAgent = $_SERVER['HTTP_USER_AGENT'];

            if ($this->isSearchEngine()) {
                if ($this->AgeGateBackURL() != "") {
                    $this->redirect(Director::absoluteBaseURL().$this->AgeGateBackURL());
                } else {
                    $this->redirect(Director::absoluteBaseURL());
                }
            }


            if (strpos($_SERVER['REQUEST_URI'], 'age-gate') !== false) {
                Requirements::javascript(THIRDPARTY_DIR.'/jquery/jquery.js');
                Requirements::javascript('silverstripe-age-gate/javascript/jquery.cookie.js');
                Requirements::javascript('silverstripe-age-gate/javascript/agegate.js');
                Requirements::javascript('silverstripe-age-gate/javascript/date.js');
                Requirements::javascript('silverstripe-age-gate/javascript/agegate.js');
                Requirements::css('silverstripe-age-gate/css/agegate.css');
            }
            $this->renderWith('Page', 'AgeGatePage');
        }

        public function AgeGateForm()
        {
            $enter = new FormAction("EnterAgeGate", "Enter");
            $enter->setUseButtonTag(true);
            $leave = new FormAction("LeaveAgeGate", "Leave");
            $leave->setUseButtonTag(true);
            $form = new Form($this, "AgeGateForm", new FieldList(
                // List your fields here
                new TextField("Month", "Month", "MM", 2),
                new TextField("Day", "Day", "DD", 2),
                new TextField("Year", "Year", "YYYY", 4),
                new CheckboxField("itWillBecomeAMemory", "Remember Me")
            ), new FieldList(
                // List the action buttons here
                $enter,
                $leave
            ));

            return $form;
        }

        public function EnterAgeGate()
        {
        }

        public function LeaveAgeGate()
        {
            $this->redirect('http://google.com');
        }

        public function AgeGateBackURL()
        {
            return Session::get('AgeGateBackURL');
        }

        public function isSearchEngine()
        {
            $isSearchEngine = Session::get('isSearchEngine');
            if ($isSearchEngine == null) {
                $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
                $all_agents = array("google","googlebot","msnbot","yahoo","facebook","twitter","abcdatos","acme-spider","ahoythehomepagefinder","Alkaline","anthill","appie","arachnophilia","arale","araneo","araybot","architext","aretha","ariadne","arks","aspider","atn","atomz","auresys","backrub","bayspider","bbot","bigbrother","bjaaland","blackwidow","blindekuh","Bloodhound","borg-bot","boxseabot","brightnet","bspider","cactvschemistryspider","calif","cassandra","cgireader","checkbot","christcrawler","churl","cienciaficcion","cmc","Collective","combine","confuzzledbot","coolbot","cosmos","cruiser","cusco","cyberspyder","cydralspider","desertrealm","deweb","dienstspider","digger","diibot","directhit","dnabot","download_express","dragonbot","dwcp","e-collector","ebiness","eit","elfinbot","emacs","emcspider","esculapio","esther","evliyacelebi","nzexplorer","fastcrawler","fdse","felix","ferret","fetchrover","fido","finnish","fireball","fish","fouineur","francoroute","freecrawl","funnelweb","gama","gazz","gcreep","getbot","geturl","golem","grapnel","griffon","gromit","gulliver","gulperbot","hambot","harvest","havindex","hometown","wired-digital","htdig","htmlgobble","hyperdecontextualizer","iajabot","iconoclast","Ilse","imagelock","incywincy","informant","infoseek","infoseeksidewinder","infospider","inspectorwww","intelliagent","irobot","iron33","israelisearch","javabee","JBot","jcrawler","askjeeves","jobo","jobot","joebot","jubii","jumpstation","kapsi","katipo","kdd","kilroy","ko_yappo_robot","labelgrabber.txt","larbin","legs","linkidator","linkscan","linkwalker","lockon","logo_gif","lycos","macworm","magpie","marvin","mattie","mediafox","merzscope","meshexplorer","MindCrawler","mnogosearch","moget","momspider","monster","motor","muncher","muninn","muscatferret","mwdsearch","myweb","NDSpider","netcarta","netmechanic","netscoop","newscan-online","nhse","nomad","northstar","objectssearch","occam","octopus","OntoSpider","openfind","orb_search","packrat","pageboy","parasite","patric","pegasus","perignator","perlcrawler","phantom","phpdig","piltdownman","pimptrain","pioneer","pitkow","pjspider","pka","plumtreewebaccessor","poppi","portalb","psbot","Puu","python","raven","rbse","resumerobot","rhcs","rixbot","roadrunner","robbie","robi","robocrawl","robofox","robozilla","roverbot","rules","safetynetrobot","scooter","search_au","search-info","searchprocess","senrigan","sgscout","shaggy","shaihulud","sift","simbot","site-valet","sitetech","skymob","slcrawler","slurp","smartspider","snooper","solbot","speedy","spider_monkey","spiderbot","spiderline","spiderman","spiderview","spry","ssearcher","suke","suntek","sven","sygol","tach_bw","tarantula","tarspider","tcl","techbot","templeton","titin","titan","tkwww","tlspider","ucsd","udmsearch","uptimebot","urlck","valkyrie","verticrawl","victoria","visionsearch","voidbot","voyager","vwbot","w3index","w3m2","wallpaper","wanderer","wapspider","webbandit","webcatcher","webcopy","webfetcher","webfoot","webinator","weblayers","weblinker","webmirror","webmoose","webquest","webreader","webreaper","webs","websnarf","webspider","webvac","webwalk","webwalker","webwatch","wget","whatuseek","whowhere","wlm","wmir","wolp","wombat","worm","wwwc","wz101","xget","Nederland.zoek");
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
    }
