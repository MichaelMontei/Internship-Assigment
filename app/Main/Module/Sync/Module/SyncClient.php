<?php
namespace Main\Module\Sync\Module;


use App\Teamleader\TeamleaderCompany;
use App\Teamleader\TeamleaderCompanyMapper;
use M\DataObject\FilterWhere;
use M\Exception\RuntimeErrorException;

class SyncClient
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @throws RuntimeErrorException
     */
    public function handle(): void
    {
        $clientData = $this->data;

        \M\Debug\Console::getInstance('client-sync')->write('--');
        \M\Debug\Console::getInstance('client-sync')->write(sprintf(
            'About to sync client. Data: [%s]',
            json_encode($this->data)
        ));

        $tmId = $clientData['id'];

        // @Lets check if there is already data with the Filter
        $company = (new TeamleaderCompanyMapper())
            ->addFilter(new FilterWhere('teamLeaderId', $tmId))
            ->getOne();

        //@ Check if company does not exist, lets make a new company and set the Unique teamleader ID.
        if ( ! $company) {
            $company = new TeamleaderCompany();
            $company->setTeamLeaderId($tmId);
        }

        //@ Set all the values to store in the database, we do not duplicate the setTeamLeaderId
        $company->setName($clientData['name']);
        $company->setVatNumber($clientData['vat_number']);
        $company->setPaymentTerm($clientData['payment_term']['days']);
        $company->setAddress($clientData['address']['line_1']);
        $company->setCountry($clientData['address']['country']);
        $company->setEmail($clientData['emails'][0]['email']);
        $company->save();

    }
}
