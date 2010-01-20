<?php

header("Content-Type: application/xml; charset=ISO-8859-1"); 

echo'<?xml version="1.0" encoding="ISO-8859-1" ?>';

$root = 'http://query.yahooapis.com/v1/public/yql?q=';

$yql = 'select * from html where url="http://thinkphp.ro/articles" and xpath="//ul"';

$x = get($root. urlencode($yql). '&format=json');

$x = json_decode($x);

foreach($x->query->results->ul as $ul) {

        if($ul->id === 'presentationlist') {

                $presentationitem = '<item><title>'.$ul->li[0]->h3->a->content.'</title><link>'.$ul->li[0]->h3->a->href.'</link><description>'.$ul->li[0]->p->content.'</description></item>';
        }

        if($ul->id === 'videolist') {

                $videoitem = '<item><title>'.$ul->li[0]->h3->a->content.'</title><link>'.$ul->li[0]->h3->a->href.'</link><description>';

                $videoitem .= htmlentities('<embed'.

                             ' height="'.$u->li[0]->p->embed->height.'"'.

                             ' src="'.$u->li[0]->p->embed->src.'"'.

                             ' type="'.$u->li[0]->p->embed->type.'"'.

                             ' width="'.$u->li[0]->p->embed->width.'"'.

                             '></embed>');
 
                $videoitem.= '</description></item>';


        }

}


function get($url) {

       $ch = curl_init();

       curl_setopt($ch,CURLOPT_URL,$url);

       curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);

       curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

       $data = curl_exec($ch);

       curl_close($ch);

       return $data; 
}

?>

<rss  xmlns:media="http://search.yahoo.com/mrss/" xmlns:dc="http://purl.org/dc/elements/1.1/" version="2.0">

<channel>

<title>Adrian Statescu`s latest</title>

<description>Events, Presentations, Videos by Adrian Statescu</description>

<link>http://thinkphp.ro/articles</link>

<language>en-gb</language>

<copyright>Adrian Statescu 2009</copyright>

<lastBuildDate><?php echo date('r') ;?> </lastBuildDate>

<pubDate><?php echo date('r') ;?></pubDate>

<?php echo$presentationitem; ?>

<?php echo$videoitem; ?>

</channel>
</rss>


