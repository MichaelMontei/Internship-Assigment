<?php

namespace Main\Module\Teamleader\Controller;

use App\Teamleader\TeamleaderCompany;
use App\Teamleader\TeamleaderCompanyMapper;
use App\Teamleader\TeamleaderCredentials;
use App\Teamleader\TeamleaderCredentialsMapper;
use GuzzleHttp\Exception\GuzzleException;
use M\DataObject\FilterWhere;
use M\Server\Header;
use M\Server\Request;
use M\Uri\Uri;
use Main\Controller\Main;
use GuzzleHttp\Client;
/**
 * Class Home
 * @package Main\Module\teamleader\Controller
 */
class Teamleader extends Main
{

    public function authorize()
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

//    public function authorizeOk()
//    {
//        dd($_GET);
//    }

    /**
     * @throws GuzzleException
     */
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

        // @todo save the json in the database
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


    /**
     * @throws GuzzleException
     */
    public function companies()
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

//        foreach ($data['meta'] as $page){
//            $tmPage = $page['page'];
//        }
//
//        dd($tmPage);

        // @make a new array to store the data we want for the database
        $names = [];

        // @We need to loop through our $data array -> data -> and make the new columns.
        foreach ($data['data'] as $invoice) {
            //$names = [];
            //$names [] =  $tmName = $invoice['name'];

            $tmName = $invoice['name'];
            $tmVatNumber = $invoice['vat_number'];
            $tmPayment = $invoice['payment_term']['days'];
            $tmAddress = $invoice['address']['line_1'];
            $tmId = $invoice['business_type']['id'];
            $tmCountry = $invoice['address']['country'];
            //$tmUpdated = $invoice['updated_at'];
            $tmEmail = $invoice['emails'][0]['email'];

            // @Lets check if there is already data with the Filter
            $company = (new TeamleaderCompanyMapper())
                ->addFilter(new FilterWhere('teamLeaderId', $tmId))
                ->getOne();


            if ( ! $company) {
                $company = new TeamleaderCompany();
            }


            // @Here we can set all the values to store them in our database.
            $company->setName($invoice['name']);
            $company->setVatNumber($invoice['vat_number']);
            $company->setPaymentTerm($invoice['payment_term']['days']);
            $company->setAddress($invoice['address']['line_1']);
            $company->setTeamLeaderId($invoice['business_type']['id']);
            $company->setCountry($invoice['address']['country']);
            //$company->setUpdatedAt($invoice['updated_at']);
            $company->setEmail($invoice['emails'][0]['email']);
            $company->save();
            //s($names);
            dd($data);
        }
    }

//    public function users(){
//        $credentials = (new TeamleaderCredentialsMapper())->getOne();
//        $json = $credentials->getValue();
//        $array = json_decode($json, true);
//        $accessToken = $array['access_token'];
//        $client = new Client();
//        $res = $client->request('GET', 'https://api.focus.teamleader.eu/users.list', [
//            'headers' => [
//                'Authorization' => $accessToken,
//            ],
//        ]);
//
//        // @todo save the companies in the database
//        $message = $res->getBody()->getContents();
//
//        // @data needs to be seen as an array instead of objects, so we will need to json_decode!
//        $data = json_decode($message, true);
//        s($data);
//        die;
//
//
//        foreach ($data['data'] as $user) {
//            $nameUser = $user['email'];
//            dd($nameUser);die;
//        }
//    }
}







