<?php

class Redirect
{
    public static function to($reUrl = '',$code=0)
    {
        $url = $reUrl;
        if (!preg_match('/http/i', $reUrl)) {
            $url = System::getUrl() . $reUrl;
        }

        if((int)$code > 0)
        Response::headerCode($code);

        header("Location: " . $url);

        die();
    }


    public static function detectRedirect()
    {
        $uri=System::getUri();

        $hash=md5($uri);

        $savePath=self::cachePath().$hash.'.cache';

        if(file_exists($savePath))
        {
            $loadData=trim(file_get_contents($savePath));

            self::to($loadData);
        }
    }


    public static function get($inputData=array())
    {

        $limitQuery="";

        $limitShow=isset($inputData['limitShow'])?$inputData['limitShow']:0;

        $limitPage=isset($inputData['limitPage'])?$inputData['limitPage']:0;

        $limitPage=((int)$limitPage > 0)?$limitPage:0;

        $limitPosition=$limitPage*(int)$limitShow;

        $limitQuery=((int)$limitShow==0)?'':" limit $limitPosition,$limitShow";

        $limitQuery=isset($inputData['limitQuery'])?$inputData['limitQuery']:$limitQuery;

        $moreFields=isset($inputData['moreFields'])?','.$inputData['moreFields']:'';

        $field="id,from_url,to_url,date_added,status".$moreFields;

        $selectFields=isset($inputData['selectFields'])?$inputData['selectFields']:$field;

        $whereQuery=isset($inputData['where'])?$inputData['where']:'';

        $orderBy=isset($inputData['orderby'])?$inputData['orderby']:'order by id desc';

        $result=array();

        $dbPrefix=Database::getPrefix();

        $prefix=isset($inputData['prefix'])?$inputData['prefix']:$dbPrefix;

        
        $command="select $selectFields from ".$prefix."redirects $whereQuery";

        $command.=" $orderBy";

        $queryCMD=isset($inputData['query'])?$inputData['query']:$command;

        $queryCMD.=$limitQuery;

        $cache=isset($inputData['cache'])?$inputData['cache']:'yes';
        
        $cacheTime=isset($inputData['cacheTime'])?$inputData['cacheTime']:-1;

        $md5Query=md5($queryCMD);

        if($cache=='yes')
        {
            // Load dbcache

            $loadCache=Cache::loadKey('dbcache/system/redirect/'.$md5Query,$cacheTime);

            if($loadCache!=false)
            {
                $loadCache=unserialize($loadCache);
                return $loadCache;
            }

            // end load         
        }


        $query=Database::query($queryCMD);
        
        if(isset(Database::$error[5]))
        {
            return false;
        }

        $inputData['isHook']=isset($inputData['isHook'])?$inputData['isHook']:'yes';
        
        if((int)$query->num_rows > 0)
        {
            while($row=Database::fetch_assoc($query))
            {
                                       
                $result[]=$row;
            }       
        }
        else
        {
            return false;
        }
        
        // Save dbcache
        Cache::saveKey('dbcache/system/redirect/'.$md5Query,serialize($result));
        // end save


        return $result;
        
    }

    public static function cachePath()
    {
        $result=ROOT_PATH.'contents/redirects/';

        return $result;
    }

    public static function removeCache($inputData=array())
    {

        // $savePath=self::cachePath();

        $listID="'".implode("','", $inputData)."'";

        $loadData=self::get(array(
            'cache'=>'no',
            'where'=>"where id IN ($listID)",
            'orderby'=>'order by id desc'
            ));

        $total=count($loadData);

        for ($i=0; $i < $total; $i++) { 

            $from_url=$loadData[$i]['from_url'];

            $hash=md5($from_url);

            $savePath=self::cachePath().$hash.'.cache';

            if(file_exists($savePath))
            {
                unlink($savePath);
            }
        }
    }

    public static function saveCache($inputData=array())
    {
        $total=count($inputData);

        if((int)$total==0)
        {
            $loadData=self::get(array(
                'cache'=>'no',
                'where'=>"where status='1'",
                'orderby'=>'order by id desc'
                ));

            if(isset($loadData[0]['id']))
            {
                $from_url=$loadData[0]['from_url'];

                $hash=md5($from_url);

                $savePath=self::cachePath().$hash.'.cache';

                File::create($savePath,$loadData[0]['to_url']);
            }
        }
        else
        {
            $listID="'".implode("','", $inputData)."'";

            $loadData=self::get(array(
                'cache'=>'no',
                'where'=>"where id IN ($listID)",
                'orderby'=>'order by id desc'
                ));

            if(isset($loadData[0]['id']))
            {
                $total=count($loadData);

                for ($i=0; $i < $total; $i++) { 

                    $from_url=$loadData[$i]['from_url'];

                    $hash=md5($from_url);

                    $savePath=self::cachePath().$hash.'.cache';

                    if((int)$loadData[$i]['status']==0)
                    {
                        if(file_exists($savePath))
                        {
                            unlink($savePath);
                        }
                    }
                    else
                    {
                        File::create($savePath,$loadData[$i]['to_url']);
                    }

                }
            }
        }
    }

    public static function insert($inputData=array())
    {
        // End addons
        // $totalArgs=count($inputData);

        CustomPlugins::load('before_redirect_insert');

        $addMultiAgrs='';

        if(isset($inputData[0]['from_url']))
        {
            foreach ($inputData as $theRow) {

                $theRow['date_added']=date('Y-m-d H:i:s');

                $from_url=$theRow['from_url'];

                $from_url=trim(str_replace(System::getUrl(), '', $from_url));

                if(preg_match('/^\/(.*?)$/i', $from_url,$match))
                {
                    $from_url=$match[1];
                }

                $to_url=trim($theRow['to_url']);

                if(!preg_match('/^http/i', $to_url))
                {
                    $to_url=System::getUrl().$to_url;
                }

                $theRow['from_url']=$from_url;

                $theRow['to_url']=$to_url;

                $keyNames=array_keys($theRow);

                $insertKeys=implode(',', $keyNames);

                $keyValues=array_values($theRow);

                $insertValues="'".implode("','", $keyValues)."'";

                $addMultiAgrs.="($insertValues), ";

            }

            $addMultiAgrs=substr($addMultiAgrs, 0,strlen($addMultiAgrs)-2);
        }
        else
        {       
            $inputData['date_added']=date('Y-m-d H:i:s');

            $from_url=$inputData['from_url'];

            $from_url=trim(str_replace(System::getUrl(), '', $from_url));

            if(preg_match('/^\/(.*?)$/i', $from_url,$match))
            {
                $from_url=$match[1];
            }

            $to_url=trim($inputData['to_url']);

            if(!preg_match('/^http/i', $to_url))
            {
                $to_url=System::getUrl().$to_url;
            }

            $inputData['from_url']=$from_url;

            $inputData['to_url']=$to_url;

            $keyNames=array_keys($inputData);

            $insertKeys=implode(',', $keyNames);

            $keyValues=array_values($inputData);

            $insertValues="'".implode("','", $keyValues)."'";   

            $addMultiAgrs="($insertValues)";    
        }


        Database::query("insert into ".Database::getPrefix()."redirects($insertKeys) values".$addMultiAgrs);

        // DBCache::removeDir('system/redirect');

        if(!$error=Database::hasError())
        {

            $id=Database::insert_id();

            self::saveCache();
            
            CustomPlugins::load('after_redirect_insert');

            return $id; 
        }

        return false;
    
    }

    public static function remove($post=array(),$whereQuery='',$addWhere='')
    {
        
        if(is_numeric($post))
        {
            $id=$post;

            unset($post);

            $post=array($id);
        }

        self::removeCache($post);

        $total=count($post);

        $listID="'".implode("','",$post)."'";

        $whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listID)";

        $addWhere=isset($addWhere[5])?$addWhere:"";

        $command="delete from ".Database::getPrefix()."redirects where $whereQuery $addWhere";



        Database::query($command);

        CustomPlugins::load('after_redirect_remove',$post);

        // DBCache::removeDir('system/redirect');
        
        // DBCache::removeCache($listID,'system/redirect');

        return true;
    }

    public static function update($listID,$post=array(),$whereQuery='',$addWhere='')
    {
        if(is_numeric($listID))
        {
            $catid=$listID;

            unset($listID);

            $listID=array($catid);
        }

        self::removeCache($listID);

        $listIDs="'".implode("','",$listID)."'";    
                
        $keyNames=array_keys($post);

        $total=count($post);

        $setUpdates='';

        for($i=0;$i<$total;$i++)
        {
            $keyName=$keyNames[$i];
            $setUpdates.="$keyName='$post[$keyName]', ";
        }

        $setUpdates=substr($setUpdates,0,strlen($setUpdates)-2);
        
        $whereQuery=isset($whereQuery[5])?$whereQuery:"id in ($listIDs)";
        
        $addWhere=isset($addWhere[5])?$addWhere:"";

        Database::query("update ".Database::getPrefix()."redirects set $setUpdates where $whereQuery $addWhere");

        if(!$error=Database::hasError())
        {
            CustomPlugins::load('after_redirect_update',$listID);

            self::saveCache($listID);

            return true;
        }

        return false;
    }



}
