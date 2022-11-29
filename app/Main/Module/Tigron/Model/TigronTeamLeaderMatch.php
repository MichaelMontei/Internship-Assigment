<?php

namespace Main\Module\Tigron\Model;

use App\Teamleader\TeamleaderCredentials;
use App\Teamleader\TeamleaderCredentialsMapper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use M\Server\Request;
use M\Uri\Uri;

class TigronTeamLeaderMatch
{
    public function getAuthorization()
    {
        $uri = new Uri('https://focus.teamleader.eu/oauth2/authorize');
        $uri->setQueryVariables([
            'client_id' => TEAMLEADER_CLIENT_ID,
            'response_type' => 'code',
            'state' => '1234',
            'redirect_uri' => href('teamleader/access'),
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
                'redirect_uri' => href('teamleader/access'),
            ],
            'http_errors' => false
        ]);

        $credentials = (new TeamleaderCredentialsMapper())->getOne();
        if ( ! $credentials) {
            $credentials = new TeamleaderCredentials();
        }
        $credentials->setValue($response->getBody()->getContents());

        $json = $credentials->getValue();
        $array = json_decode($json, true);

        !d($array);

        $credentials->save();

        dd($response->getBody()->getContents());
    }


    public function getTeamLeaderId()
    {
        $credentials = (new TeamleaderCredentialsMapper())->getOne();
        $json = $credentials->getValue();
        $array = json_decode($json, true);

        // @We need to get the accessToken out of the json file to use it in out GET Request as a header => authorization parameter.
        $accessToken = $array['access_token'];

        $client = new Client();
        $res = $client->request('GET', 'https://api.focus.teamleader.eu/companies.list?page[number]=1&page[size]=100', [
            'headers' => [
                'Authorization' => $accessToken,
            ],
        ]);

        $pageArray = [];
        
        // @todo save the companies in the database
        $data = $res->getBody()->getContents();

        // @data needs to be seen as an array instead of objects, so we will need to json_decode!
        $data = json_decode($data, true);
        dd($data);
        die;
    }

    public function getTeamLeaderEmailOrName()
    {
        // Get the Email / Name for comparison with the domain name from Tigron
    }

    public function compareDomainWithNameOrEmail()
    {

    }
}