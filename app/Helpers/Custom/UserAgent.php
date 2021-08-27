<?php

namespace App\Helpers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAgent extends Controller
{
    private function parse($ua)
    {
        $pos = strpos($ua, '(');
        $pos2 = strpos($ua, ')', $pos);
        if ($pos === false or $pos2 === false)
        {
            return array(false, false);
        }

        $platform = substr($ua, $pos+1, $pos2-$pos-1);
        $browser = substr($ua, $pos2+2);
        $something = substr($ua, 0, $pos-1);

        return array($platform, $browser, $something);
    }

	public function detect($userAgent)
	{
		$len = strlen($userAgent);
		$in = false;

		$uas = $userAgent;

		for ($i=0; $i<$len; $i++)
		{
			switch ($uas[$i])
			{
				case '(' :	$in = true;
							$uas[$i] = ';';
							break;
				case ')' :	$in = false;
							$uas[$i] = ';';
							break;
				case ' ' :	if (!$in)
							{
								$uas[$i] = ';';
							}
							else
							{
								$uas[$i] = '/';
							}
			}
		}

		$ua = explode(';', $uas);

		$data = array();

		foreach ($ua AS $u)
		{
			if ($u == '') continue;

			$u = trim($u, '/');
			$t = explode('/', $u);

			$c = count($t);
			if ($c>2)
			{
				$t[1] .= ' ' . $t[2];
			}
			elseif ($c<2)
			{
				$t[1] = '';
			}

			$data[] = array($t[0], $t[1]);
		}

		$result = array();
		$info['platform'] 		= array('Windows', 'PPC', 'Macintosh', 'X11', 'Win64', 'PDA');
		$info['system'] 		= array('Windows', 'Mac', 'Linux', 'Darwin', 'Amiga', 'AmigaOS', 'WinNT', 'Commodore64', 'Unix', 'Symbian', 'Win32', 'PalmOS', 'Win98', 'Win95', 'Syllable', 'iPhone', 'iPod');
		$info['engine'] 		= array('Gecko', 'Trident', 'Presto', 'KHTML', 'AppleWebKit', 'libwww');
		$info['google_toolbar']	= array('GTB6');
		$info['alexa_toolbar']	= array('Alexa');
		$info['wrapper']		= array('Sleipnir', 'Avant', 'MyIE2', 'Embedded', 'TheWorld', 'MAXTHON',
										'Browzar', 'IEMB3', 'FDM', 'Maxthon', 'MRA');
		$info['browser']		= array('Firefox', 'Opera', 'Chrome', 'MSIE', 'Konqueror',
										'Opera', 'boxee', 'Mediapartners-Google', 'Googlebot',
										'Wget', 'W3C_Validator', 'Netscape', 'Yahoo!', 'Safari',
										'Songbird', 'Xiino', 'ACS-NF', 'abot', 'Ace Explorer',
										'ActiveBookmark', 'AIM', 'aipbot', 'amaya', 'Iceweasel',
										'AmigaVoyager', 'Arexx', 'ANTFresco', 'aolbrowser',
										'Astra', 'Avantgo', 'Crazy', 'curl', 'Dillo',
										'ELinks', 'FlashGet', 'IEMobile', 'ia_archiver', 'iCab',
										'Java', 'Links', 'Lynx', 'MobileExplorer', 'Blazer', 'NetFront',
										'Mozilla', 'WebPro', 'ANTGalio', 'heritrix', 'iCab', 'ABrowse',
										'OmniWeb', 'lolifox', 'Navigator', 'SeaMonkey', 'Camino',
										'Shiira', 'Sunrise', 'Flock', 'Minimo', 'K-Meleon', 'PycURL');
		$info['.net']			= array('.NET');

		foreach ($data AS $d)
		{
			foreach ($info AS $type=>$values)
			{
				foreach ($values AS $val)
				{
					if (strpos($d[0], $val) !== false)
					{
						if (strpos($d[0], 'Windows-Media-Player') !== false) continue;
						if (strpos($d[0], 'NetscapeOnline.co.uk') !== false) continue;

						//don't overwrite
						if ($type == 'engine' and (isset($result['engine']['name']) and  $result['engine']['name'] == 'AppleWebKit')) continue;
		                if ($type == 'browser' and (isset($result['browser']['name']) and  $result['browser']['name'] == 'Chrome')) continue;
		                if ($type == 'browser' and (isset($result['browser']['name']) and  $result['browser']['name'] == 'Shiira'))
		                {
		                	$result['browser']['version'] = $d[1];
							continue;
		                }
		                if ($type == 'browser' and (isset($result['browser']['name']) and $result['browser']['name'] == 'Sunrise')) continue;
		                if ($type == 'browser' and (isset($result['browser']['name']) and $result['browser']['name'] == 'Flock')) continue;
						if ($d[0] == 'Mac' and $d[1] == 'Community Build,') continue;

						$result[$type] = array('name'=>$d[0], 'version'=>$d[1]);
						break;
					}
				}
			}
		}

		//Some of the browsers/bots are generating "weird" UAS, so to support these more customized code is needed:
		if (isset($result['browser']['name']))
		{
			if (!isset($result['browser']['version']) or $result['browser']['version'] == '')
			{
				switch ($result['browser']['name'])
				{
					case 'boxee' :  list($system) = $this->parse($userAgent);

									$b = explode('-', $system);
								    $bb = explode('/', $b[0]);
								    $bbb = explode(' ', $bb[1]);

									$result['system']['name'] = $bbb[0];
									$result['system']['version'] = $bbb[1];
									$result['browser']['version'] = $b[1];
									break;
					case 'ELinks':
					case 'Links' :  list($b) = $this->parse($userAgent);

									$bb = explode(';', $b);
									$bbb = explode(' ', $bb[1]);

									$result['browser']['version'] = $bb[0];
									$result['system']['name'] = $bbb[1];
									$result['system']['version'] = isset($bbb[2]) ? $bbb[2] : '';
									break;
					case 'Opera' :  list($a, $b) = $this->parse($userAgent);
									$bb = explode(' ', $b);

									$result['browser']['version'] = $bb[count($bb)-1];
									break;
				}
			}
		}
		else if (strpos($userAgent, 'WebTV') !== false)
		{
									list($a, $a, $b) = $this->parse($userAgent);
									$bb = explode(' ', $b);
									$bb = explode('/', $bb[1]);

									$result['browser']['name'] = $bb[0];
									$result['browser']['version'] = $bb[1];
		}

		//polish the results
		$extend = array('Embedded'	=> array('Embedded Web Browser', ''),
						'IEMB3'		=> array('Embedded Web Browser', '3'),
						'FDM'		=> array('Free Download Manager', '')
						);

		foreach ($extend AS $short=>$long)
		{
			if (isset($result['wrapper']['name']) and $result['wrapper']['name'] == $short)
			{
				$result['wrapper']['name'] = $long[0];
				$result['wrapper']['version'] = $long[1];
			}
		}

		//generate some extra info
		$bots = array('Wget', 'Googlebot', 'curl', 'Mediapartners-Google', 'aipbot', 'abot', 'Yahoo!', 'PycURL');
		if (isset($result['browser']['name']) and in_array($result['browser']['name'], $bots))
		{
			$result['bot'] = true;
		}

		return $result;
	}
}
