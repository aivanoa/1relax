<?php
	header('Content-Type: text/plain');
	$sd = array_shift((explode('.', $_SERVER['HTTP_HOST'])));
	
if( $sd != '1relax' ) { ?>
User-Agent: *
Disallow: /salons/edit.php
Disallow: /bitrix
Disallow: /personal
Disallow: /search/
Disallow: /vacancy/
Disallow: /reklama/
Disallow: /salons/*/girls/$
Disallow: /salons/*/vacancy/$
Disallow: /salons/*/news/$
Disallow: /salons/*/comments/$
Disallow: /salons/*/programms/$
Disallow: /comments/
Allow: /bitrix*templates
Allow: /bitrix*js
Allow: /bitrix*css
Host: <?=$sd?>.1relax.ru 
Sitemap: http://<?=$sd?>.1relax.ru/sitemap.xml
<? } else { ?>
User-Agent: *
Disallow: /*index.php$
Disallow: /bitrix
Disallow: /auth/
Disallow: /personal/
Disallow: /*search
Disallow: /*/slide_show/
Disallow: /*/gallery/*order=*
Disallow: /*print=
Disallow: /*register=
Disallow: /*forgot_password=
Disallow: /*change_password=
Disallow: /*login=
Disallow: /*logout=
Disallow: /*auth=
Disallow: /*action=
Disallow: /*bitrix_*=
Disallow: /*backurl=*
Disallow: /*BACKURL=*
Disallow: /*back_url=*
Disallow: /*BACK_URL=*
Disallow: /*back_url_admin=*
Disallow: /*print_course=Y
Disallow: /*COURSE_ID=
Disallow: /*?COURSE_ID=
Disallow: /*PAGE_NAME=
Disallow: /*SHOWALL
Disallow: /*show_all=
Disallow: /*?oid=
Disallow: /*?id=
Disallow: /*?quote=
Disallow: /*?admin=
Allow: /*.css$
Allow: /*.png$
Allow: /js/*.js$
Allow: /*.JPG$
Allow: /*.jpg$
Allow: /*.gif$
Allow: /*.jpeg$
Allow: /bitrix/*.ttf
Allow: /bitrix/*.woff
Allow: /bitrix/*.css
Allow: /bitrix/*.js
Allow: /sitemap.xml$


Sitemap: http://1relax.ru/sitemap.xml

User-Agent: DISCo Pump
Disallow: /

User-Agent: Wget
Disallow: /

User-Agent: WebZIP
Disallow: /

User-Agent: Teleport Pro
Disallow: /

User-Agent: WebSnake
Disallow: /

User-Agent: Offline Explorer
Disallow: /

User-Agent: Web-By-Mail
Disallow: /

User-Agent: psbot
Disallow: /

User-Agent: gigabot
Disallow: /

User-Agent: Twiceler
Disallow: /

User-Agent: NetinfoBot
Disallow: /

User-Agent: ia_archiver
Disallow: /

User-Agent: AhrefsBot
Disallow: /

User-Agent: MJ12bot
Disallow: /

User-Agent: Detectify
Disallow: /

User-Agent: dotbot
Disallow: /

User-Agent: Riddler
Disallow: /

User-Agent: SemrushBot
Disallow: /

User-Agent: LinkpadBot
Disallow: /

User-Agent: BLEXBot
Disallow: /

User-Agent: FlipboardProxy
Disallow: /

User-Agent: aiHitBot
Disallow: /

User-Agent: trovitBot
Disallow: /

User-Agent: Baiduspider
Disallow: /

User-Agent: FeedBurner
Disallow: /

<? } ?>