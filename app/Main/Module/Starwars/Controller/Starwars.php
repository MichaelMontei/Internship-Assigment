<?php

namespace Main\Module\Starwars\Controller;

use App\Starwars\StarwarsMapper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use M\DataObject\FilterWhere;
use M\Exception\InvalidArgumentException;
use M\Uri\Uri;
use Main\Controller\Main;

class Starwars extends Main
{
    /**
     * @throws InvalidArgumentException
     */
    public function index()
    {
        (new \Main\Module\Starwars\View\Starwars())
            ->setChars($this->getChars())
            ->addWrap($this->_getWrap())
            ->display();
    }


//    public function sync()
//    {
//        $t0 = microtime(true);
//        $i = 1;
//        while (count($data = $this->getData($i)) > 0) {
//            // logging
//            // @For now 5 because we get a crash if we ask for all data, rate limit reached
//            if ($i === 5) {
//                break;
//            }
//            $i++;
//        }
//
//        $t1 = microtime(true);
//        $total = $t1 - $t0;
//        d($total);
//    }


    public function getData(int $page): array
    {
        $uri = new Uri('https://swapi.dev/api/people');
        $uri->setQueryVariables([
            'page' => $page
        ]);
        !d($uri->toString());

    }

//        $uri = new Uri('https://swapi.dev/api/people');
//        $uri->setQueryVariables([
//            'page' => $page
//        ]);
//        !d($uri->toString());

    public function test() {

        $client = new Client();
        //$response = $client->request('GET', $uri->toString());
        $response = $client->request('GET', 'https://swapi.dev/api/people');
        $data = $response->getBody()->getContents();
        $data = json_decode($data, true);
        //dd($data); die;
        //s($data); die;


        foreach ($data['results'] as $character) {
            $tmName = $character['name'];

            $starNames = (new StarwarsMapper())
                ->addFilter(new FilterWhere('name', $tmName))
                ->getOne();

            if (!$starNames) {
                $starNames = new \App\Starwars\Starwars();
                $starNames->setName($character['name']);
                $starNames->setHeight($character['height']);
                $starNames->setGender($character['gender']);
                $starNames->save();
                return $data;
            }
        }
    }
    private function getChars(){
        return (new StarwarsMapper())
            ->getAll();
    }
}