<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use function Psy\debug;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class Curl extends Model
{
    /**
     * @var string
     */
    protected $allArticles = "";
    /**
     * @var array
     */
    protected $articles = array();
    /**
     * @var float|int
     */
    protected $loopCount = 100;

    /**
     * @return array
     */
    public function sendCurl() {

        for ($i = 1; $i <= $this->loopCount; $i++) {
            $chr = curl_init();
            curl_setopt($chr, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.6 (KHTML, like Gecko) Chrome/16.0.897.0 Safari/535.6');
            curl_setopt($chr, CURLOPT_HEADER, FALSE);
            curl_setopt($chr, CURLOPT_URL, 'http://www.tert.am/en/news/'.$i);
            curl_setopt($chr, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($chr, CURLOPT_BINARYTRANSFER,TRUE);
            curl_setopt($chr, CURLOPT_FRESH_CONNECT, TRUE);
            curl_setopt($chr, CURLOPT_FORBID_REUSE, TRUE);
            curl_setopt($chr, CURLOPT_FOLLOWLOCATION, TRUE);

            $buffer = curl_exec($chr);

            if( $buffer === false ) {
                continue;
            }

            $cutFirstOutput = strstr($buffer, '<div class="news-blocks" style="clear:left">');
            $onlyArticles = substr($cutFirstOutput, 0, strpos($cutFirstOutput, '<div class="pagingBlock">'));
            $this->allArticles .= $onlyArticles;

            curl_close($chr);
            $buffer = "";
        }

        if( !empty($this->allArticles) ) {

            File::deleteDirectory('images/');

            $crawler = new Crawler($this->allArticles);

            $filter = '.news-blocks';
            $articlesHTML = $crawler
                ->filter($filter)
                ->each(function (Crawler $node) {
                    return $node->html();
                });

            File::makeDirectory('images/', 0775, true, true);

            foreach ($articlesHTML as $index => $artHTML) {
                $crawler = new Crawler($artHTML);
                $this->articles[$index]['title'] = preg_replace('/ +/', ' ', trim(preg_replace('/[^A-Za-z0-9]/', ' ', $crawler->filter('h4')->text())));
                $this->articles[$index]['description'] = preg_replace('/ +/', ' ', trim(preg_replace('/[^A-Za-z0-9]/', ' ', $crawler->filter('p.nl-anot>a')->text())));

                $imageName = $crawler->filter('a>img')->attr('src');
                $imageNameNew = explode('/', strtok(str_replace('http://www.tert.am/news_images/','images/', $imageName), '?'));
                $this->articles[$index]['image'] =  $imageNameNew[0].'/'.$imageNameNew[1].''.(isset($imageNameNew[2])?('-'.$imageNameNew[2]):'').''.(isset($imageNameNew[3])?('-'.$imageNameNew[3]):'');


                $this->articles[$index]['url'] = $crawler->filter('p.nl-anot>a')->attr('href');
                $this->articles[$index]['posted_at'] =  preg_replace('/ +/', ' ', trim(preg_replace('/[^0-9:.]+/', ' ', $crawler->filter('p.nl-dates')->text())));

                $file = file_get_contents($imageName);

                $save = file_put_contents($this->articles[$index]['image'], $file);

                if( !$save ){
                    continue;
                }
            }

            $this->insertData($this->articles);
        }


        return $this->articles;
    }

    public function insertData( $data ) {
        // We should check if the $data is valid, I suppose its valid now
        try{
            DB::transaction(function () use ($data) {
                DB::table('articles')->truncate();
                DB::table('articles')->insert($data);
            });
        }catch(\Exception $exception){
            Log::error('Failed insertData method execution');
        }
    }


}
