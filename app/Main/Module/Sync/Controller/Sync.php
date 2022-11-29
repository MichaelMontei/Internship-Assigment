<?php

namespace Main\Module\Sync\Controller;


use App\Teamleader\TeamleaderCompanyMapper;
use App\Teamleader\TeamleaderCredentials;
use App\Teamleader\TeamleaderCredentialsMapper;
use GuzzleHttp\Client;
use M\DataObject\FilterLimit;
use M\Exception\InvalidArgumentException;
use M\Exception\RuntimeErrorException;
use M\Server\Request;
use M\Uri\Uri;
use Main\Controller\Main;
use Main\Module\Sync\Module\SyncClients;



/**
 * Class Home
 * @package Main\Module\teamleader\Controller
 */
class Sync extends Main
{
    /**
     * @throws InvalidArgumentException
     */
    public function index()
    {
        (new \Main\Module\Sync\View\Sync())
            ->setTeamLeaderId($this->getTeamLeaderId())
            ->addWrap($this->_getWrap(
                t('FAQ'),
                ''
            ))
            ->display();
    }
    /**
     * @throws RuntimeErrorException
     */
    public function sync()
    {
        $t0 = microtime(true);
        $i = 1;
        while (count($data = $this->getBatch($i)) > 0) {
            // logging
            // @For now 5 because we get a crash if we ask for all data, rate limit reached
            if ($i === 15) {
                break;
            }
            $handler = new SyncClients($data);
            $handler->handle();
            $i++;
        }

        $t1 = microtime(true);
        $total = $t1 - $t0;
        d($total);
    }

    public function authorize()
    {
        // @The uri is just to manipulate the domain name url! examples ?page=1 ?language=en
        $uri = new Uri('https://focus.teamleader.eu/oauth2/authorize');
        $uri->setQueryVariables([
            'client_id' => TEAMLEADER_CLIENT_ID,
            'response_type' => 'code',
            'state' => '1234',
            'redirect_uri' => href('sync/access'),
            'grant_type' => 'authorization_code',
        ]);
        !d($uri->toString());
        redirect($uri->toString());
    }

    public function access()
    {
        $client = new Client();
        $response = $client->request('POST', 'https://focus.teamleader.eu/oauth2/access_token', [
            'json' => [
                'client_id' => TEAMLEADER_CLIENT_ID,
                'client_secret' => TEAMLEADER_CLIENT_SECRET,
                'grant_type' => 'authorization_code',
                'code' => Request::getVariable('code'),
                'redirect_uri' => href('sync/getbatch'),
            ],
            'http_errors' => false
        ]);

        // @todo save the json in the database
        $credentials = (new TeamleaderCredentialsMapper())->getOne();
        if (!$credentials) {
            $credentials = new TeamleaderCredentials();
        }
        $credentials->setValue($response->getBody()->getContents());

        $json = $credentials->getValue();
        $array = json_decode($json, true);

        !d($array);
        $credentials->save();
        dd($response->getBody()->getContents());
    }

    protected function getBatch(int $page): array
    {
        $credentials = (new TeamleaderCredentialsMapper())->getOne();
        $json = $credentials->getValue();
        $array = json_decode($json, true);

        // @We need to get the accessToken out of the json file to use it in out GET Request as a header => authorization parameter.
        $accessToken = $array['access_token'];

        // @Here we set the ?page[number]=1 and the &page[size]=100
        $uri = new Uri('https://api.focus.teamleader.eu/companies.list');
        $uri->setQueryVariables([
            'page' => [
                'number' => $page,
                'size' => 100,
            ]
        ]);
        !d($uri->toString());

        // @After we set the URI we make the API call with the converted Uri->toString() method
        $client = new Client();
        $res = $client->request('GET', $uri->toString(), [
            'headers' => [
                'Authorization' => $accessToken,
            ]
        ]);
        $data = $res->getBody()->getContents();

        // @data needs to be seen as an array instead of objects, so we will need to json_decode!
        $data = json_decode($data, true);
        return $data['data'];
    }

    private function getTeamLeaderId()
    {
        return (new TeamleaderCompanyMapper())
            ->addFilter(new FilterLimit(0, 1000))
            ->getAll();
    }
}


