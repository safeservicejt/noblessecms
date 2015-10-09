<rss version="2.0">
    <channel>
        <title>
            <![CDATA[ <?php echo $setting['title'];?> ]]>
        </title>
        <link>
        <![CDATA[ <?php echo System::getUrl();?> ]]>
        </link>
        <description>
            <![CDATA[ <?php echo $setting['description'];?> ]]>
        </description>
        <ttl>10</ttl>
        <copyright><?php echo System::getUrl();?></copyright>
        <pubDate><?php echo date("d/m/Y h:m:s");?></pubDate>
        <generator>NoblesseCMS</generator>
        <docs><?php echo Url::rss();?></docs>
        <image>
            <title>
                <?php echo $setting['title'];?>
            </title>
            <url>
                <?php echo System::getUrl();?>bootstrap/images/logo3128.png
            </url>
            <link><?php echo System::getUrl();?></link>
            <width>128</width>
            <height>128</height>
        </image>

        <?php
        $total=count($listPost);

        $li='';

        if(isset($listPost[0]['title']))
        for($i=0;$i<$total;$i++)
        {
            $li.='
                <item>
                <title>
                    <![CDATA[ '.$listPost[$i]['title'].' ]]>
                </title>
                <link>
                <![CDATA[
                '.$listPost[$i]['url'].'
                ]]>
                </link>
                <image>
                <![CDATA[
                '.System::getUrl().$listPost[$i]['image'].'
                ]]>
                </image>
                <guid isPermaLink="false">
                    <![CDATA[
                          '.$listPost[$i]['url'].'
                    ]]>
                </guid>
                <description>
                    <![CDATA[
                    '.htmlentities($listPost[$i]['content']).'
                   ]]>
                </description>
                <pubDate>'.$listPost[$i]['date_added'].'</pubDate>
                 </item>

            ';
        }

        echo $li;
        ?>


    </channel>
</rss>