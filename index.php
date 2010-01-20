<?php

     /* start time */
     $oldtime = microtime(true);

     $root = 'http://query.yahooapis.com/v1/public/yql?q=';

     /* videos RSS */
     $yql = 'select title,link,description from rss(10) where url = "http://feeds.delicious.com/v2/rss/codepo8/myvideos?count=15";';

     /* presentations RSS */
     $yql .= 'select meta.views,content.thumbnail,content.description,title,link,description from rss(10) where url = "http://www.slideshare.net/rss/user/thinkphp";';

     /* ajaxian RSS */
     $yql .= 'select title,link from rss(10) where url = "http://feeds.feedburner.com/ajaxian";';

     /* ajaxrain RSS */
     $yql .= 'select title,link from rss(10) where url = "http://feeds.feedburner.com/ajaxrain";';

     /* myblog RSS */
     $yql .= 'select title,link from rss(10) where url = "http://thinkphp.ro/blog/rss/feed.rss";';

     /* mininova books RSS */
     $yql .= 'select title,link from rss(10) where url = "http://www.mininova.org/rss.xml?sub=50";';

     /* joobs RSS */
     $yql .= 'select title,link from rss(10) where url = "http://www.joobs.ro/it/rss/categoria/programare/";';

     /* upcoming conference RSS */
     $yql1 = 'select * from html where url="http://wait-till-i.com/talks-and-conference-participation/" and xpath="//ul" limit 1;';

     /* book knowfree RSS */
     $yql2 = 'select * from html where url="http://knowfree.net/" and  xpath="//div[@class=\'post\']" limit 5'; 

     $query = "select * from query.multi where queries='".$yql."'";

     /* assemble url for upcoming travel */
     $url = $root . urlencode($yql1) . '&format=xml&diagnostics=false';  

     /* get travel upcoming */
     $travels = renderHTML($url);

     /* assemble url for books */
     $url = $root . urlencode($yql2) . '&format=xml&diagnostics=false';  

     /* get books */
     $books = renderHTML($url);

     /* assemble compotent url */
     $url = $root . urlencode($query) . '&format=json&diagnostics=false&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';

     /* get content url */
     $output = get($url);

     /* json decode */
     $data = json_decode($output);

     /* grab results from response */
     $results = $data->query->results->results;

              foreach($results[0]->item as $r) {

                      $videos .= '<li><h3><a href="'.$r->link.'">'.$r->title.'</a></h3><p>'.html_entity_decode($r->description).'</p></li>';

              }

              foreach($results[1]->item as $r) {

                      $presentations.='<li><h3><a href="'.$r->link.'">'.$r->title.'</a></h3><p><a href="'.$r->link.'"><img src="'.$r->content->thumbnail->url.'"></a>'.$r->content->description->content.'</p></li>';
              }  

              foreach($results[2]->item as $r) {

                      $ajaxian .='<li><h3><a href="'.$r->link.'">'.$r->title.'</a></h3></li>';
              }


              foreach($results[3]->item as $r) {

                      $ajaxrain .='<li><h3><a href="'.$r->link.'">'.$r->title.'</a></h3></li>';
              }

              foreach($results[4]->item as $r) {

                      $blog .='<li><h3><a href="'.$r->link.'">'.$r->title.'</a></h3></li>';
              }


              foreach($results[5]->item as $r) {

                      $mininova .='<li><h3><a href="'.$r->link.'">'.$r->title.'</a></h3></li>';
              }


              foreach($results[6]->item as $r) {

                      $jobber .='<li><h3><a href="'.$r->link.'">'.$r->title.'</a></h3></li>';
              }


       
     function get($url) {

          $curl_handle=curl_init();

          curl_setopt($curl_handle,CURLOPT_URL,$url);

          curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);

          curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);

          $buffer = curl_exec($curl_handle);

          curl_close($curl_handle);
 
          if(empty($buffer)){return 'Error retrieving data, please try later.'; } else { return $buffer; }
     }


    function renderHTML($url) {

           $c = get($url);

           if(strstr($c,'<')){

                 $c = preg_replace("/.*<results>|<\/results>.*/",'',$c);

                 $c = preg_replace("/<\?xml version=\"1\.0\" encoding=\"UTF-8\"\?>/",'',$c);

                 $c = preg_replace("/<!--.*-->/",'',$c);
             }

        return $c;
    }


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Adrian Statescu - Developer PHP</title>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css"> 
  <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
  <style>

  html,body {background: #666}

  #doc2 {

    background: #fff;
    border: 1em solid #fff;
  }

  h1,h2,h3,h4,h5,h6{

    font-family:calibri,"arial rounded mt bold",helvetica,arial;
  }

  h1 {

      background: #CEE298;

      padding: .5em;

      font-size: 200%;

      margin-top: 0;
  }

  h2 {

     border-bottom:2px solid #000;
  }

 h3 a{

    color:#000;

    display:block;

    text-decoration:none;

    min-height:2em;

    border-bottom:3px solid #95C514;
 }


  #bd {position: relative;}

  #nav {

      position: absolute;

      width: 949px;

      top: -30px;

      left: 0.5px;
 
      background: #95C514;

      overflow: auto;

      padding: .5em 0;

      text-transform: uppercase;     
  }

  #nav li {display: inline;padding: 0 1em;}

  #nav a {

     color: #000;

     font-weight: bold;

     text-decoration: none;

     border-bottom: 2px solid #95C514;
  }

  #nav a:hover{ border-bottom:2px solid #000;}

  #presentationlist li{float: left; width: 23%;padding-right: 1%;}

  #presentationlist img{ display:block;margin:.5em 0 }

  #presentationlist, #videolist {overflow: hidden}

  #videolist li{float: left; width: 48%;padding-right: 1%;}

  ul,ul li {list-style: none;paddin: 0; margin: 0}

  #ajaxianlist h3 a {border:none; padding:0; margin:0 0 .5em 0; min-height:1em; color:#333;}

  #ajaxrainlist h3 a {border:none; padding:0; margin:0 0 .5em 0; min-height:1em; color:#333;}

  #jobberlist h3 a {border:none; padding:0; margin:0 0 .5em 0; min-height:1em; color:#333;}

  #mininovalist h3 a {border:none; padding:0; margin:0 0 .5em 0; min-height:1em; color:#333;}

  #bloglist h3 a {border:none; padding:0; margin:0 0 .5em 0; min-height:1em; color:#333;}

  .post h1{background: #fff;padding: 0;margin-top: 5px}

  .post h1 a{border-bottom: 1px solid #333;color: #333;text-decoration: none;padding: 0;margin:0}

   a {color: #333}

  .photo{ float:left; width:180px; display:block; margin-right:10px; overflow:hidden; }

  .byline {font-weight: bold;color: #95C008}

  .byline2 {font-weight: bold;}

  #ft a{color:#666;}

  #ft{ margin-top:2em;color:#999;font-size:90%;}


  </style>

</head>
<body>

<div id="doc2" class="yui-t7"> 

     <div id="hd"><h1>thinkphp.ro everything Adrian Statescu</h1></div> 

         <div id="bd"> 

	    <div class="yui-g"> 

                <div class="yui-u first"> 

                  <h2>About this and me</h2>

                  <a href="http://thinkphp.ro/about/ninja.jpg" class="photo"><img src="http://thinkphp.ro/about/ninja.jpg" alt="ninja JavaScript"></a>
                  <p class="byline2">Hello, I am <span class="fn">Adrian Statescu</span>, a <span class="title">Developer PHP</span> living and working in <span class="adr"><span class="locality">Bucharest</span>, <span class="country-name">Romania</span></span></p></p>
                  <p>This site is a repository of online articles, talks, videos and other bits and bobs I share on the web.</p>
                  <p>This site is dynamically generated from several web resources using <a href="http://developer.yahoo.com/yql">YQL</a>.</p>


                </div> 

                <div class="yui-u">

                  <h2>Upcoming Events</h2>

                  <?php echo$travels; ?><a href="feed.php"><img src="http://thinkphp.ro/rss.png" style="border:0" alt="rss"></a>

                </div> 

	    </div> 

          <div class="yui-g"> 

                  <h2 id="presentationhead">Presentation</h2>

                  <p class="byline">Here are my latest presentations, hosted on SlideShare for you to re-use.</p>

                  <ul id="presentationlist"><?php echo$presentations; ?></ul>

         </div> 

         <div class="yui-g"> 

                  <h2 id="videoshead">Video</h2>

                  <p class="byline">Here are my latest videos, hosted on Yahoo! video.</p>

                  <ul id="videolist"><?php echo$videos; ?></ul>

         </div> 


	    <div class="yui-g"> 

                <div class="yui-u first"> 

                  <h2 id="ajaxianhead">Ajaxian</h2>

                  <p class="byline">Here are latest entries on ajaxian</p>

                  <ul id="ajaxianlist"><?php echo$ajaxian ;?></ul>

                </div> 

                <div class="yui-u">

                  <h2 id="ajaxrainhead">Ajaxrain</h2>

                    <p class="byline">Here are latest entries on ajaxrain</p>

                    <ul id="ajaxrainlist"><?php echo$ajaxrain ;?></ul>

                </div> 

	    </div> 




	    <div class="yui-g"> 

                <div class="yui-u first"> 

                  <h2 id="jobberhead">Joobs</h2>

                  <p class="byline">Here are latest entries on jobber</p>

                  <ul id="jobberlist"><?php echo$jobber ;?></ul>

                </div> 

                <div class="yui-u">

                  <h2 id="mininovahead">Mininova</h2>

                    <p class="byline">Here are latest books hosted on mininova</p>

                    <ul id="mininovalist"><?php echo$mininova ;?></ul>

                </div> 

	    </div> 


          <div class="yui-g"> 

                  <h2 id="bookshead">Books</h2>

                  <p class="byline">Here are latest books hosted on knowfree</p>

                  <?php echo$books; ?>

         </div> 


	    <div class="yui-g"> 

                <div class="yui-u first"> 

                  <h2 id="bloghead">Blog</h2>

                  <p class="byline">Almost daily ravings of a geek with an urge to better the world</p>
                    
                  <ul id="bloglist"><?php echo$blog ;?></ul>

                </div> 

                <div class="yui-u">

                  <h2 id="contacthead">Contact</h2>

                     <p class="byline">Ways to contact me</p>
                     <p>The easiest option to contact me is via Twitter where I am known as <a href="http://twitter.com/thinkphp">thinkphp</a><p>You can see my photos on <a href="http://www.flickr.com/photos/23455178@N06/">Flickr</a> and my professional connections on <a href="http://www.linkedin.com/in/thinkphp">LinkedIn</a>.</p><p>If none of this tickles your fancy, you can send me an old fashioned <a href="mailto:mergesortv@gmail.com">email</a>, but please be patient as I'll need a few hours to answer.</p>

                </div> 

	    </div> 




<ul id="nav">
  <li><a href="#eventshead">Events</a></li>
  <li><a href="#presentationshead">Presentations</a></li>
  <li><a href="#videoshead">Videos</a></li>
  <li><a href="#ajaxianhead">Ajaxian</a></li>
  <li><a href="#ajaxrainhead">Ajaxrain</a></li>
  <li><a href="#bookshead">Books</a></li>
  <li><a href="#jobberhead">joobs</a></li>
  <li><a href="#mininovahead">mininova</a></li>
  <li><a href="#bloghead">Blog</a></li>
  <li><a href="#contacthead">Contact</a></li>
</ul>

	 
     </div><!--end body -->

             <div id="ft">

                  <span>Adrian Statescu mergesortv@gmail.com is a developer PHP living and working in Bucharest, Romania </span>

                  <p>This site is dynamically updated using <a href="http://developer.yahoo.com/yql">YQL</a> and uses <a href="http://developer.yahoo.com/yui">YUI</a> for layout.</p>

                  <p><?php echo "Time spent: ". (microtime(true) - $oldtime);?></p>
             </div><!--end footer --> 

	</div> <!-- end doc -->

</body>
</html>