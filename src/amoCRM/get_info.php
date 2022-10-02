<?php

use App\Models\LeadsModel;
use App\Models\LossReasons;
use App\Models\teg_lead;
use App\Models\contact_lead;
use App\Models\Companies;
use App\Models\Tags;
use App\Models\teg_company;
use App\Models\teg_contact;
use App\Models\Contacts;

use AmoCRM\Helpers\EntityTypesInterface;

use AmoCRM\Exceptions\AmoCRMApiException;
use League\OAuth2\Client\Token\AccessTokenInterface;

use AmoCRM\Models\Customers\Transactions\TransactionModel;
use AmoCRM\Collections\Customers\Transactions\TransactionsCollection;

use AmoCRM\Models\LeadModel;
use AmoCRM\Filters\LeadsFilter;

use AmoCRM\Models\CatalogElementModel;
use AmoCRM\Collections\CatalogElementsCollection;

use AmoCRM\Models\AccountModel;

include_once __DIR__ . '/bootstrap.php';

$accessToken = getToken();

$apiClient->setAccessToken($accessToken)
    ->setAccountBaseDomain($accessToken->getValues()['baseDomain'])
    ->onAccessTokenRefresh(
        function (AccessTokenInterface $accessToken, string $baseDomain) {
            saveToken(
                [
                    'accessToken' => $accessToken->getToken(),
                    'refreshToken' => $accessToken->getRefreshToken(),
                    'expires' => $accessToken->getExpires(),
                    'baseDomain' => $baseDomain,
                ]
            );
        }
    );

$leadsCollection = $apiClient->leads()->get(new LeadsFilter(), [
                                                                    LeadModel::LOSS_REASON, 
                                                                    LeadModel::CONTACTS, 
                                                                    LeadModel::SOURCE_ID, 
                                                                    LeadModel::IS_PRICE_BY_ROBOT,
                                                                    LeadModel::CATALOG_ELEMENTS
                                                                ]);
$companiesCollection = $apiClient->companies()->get();
$contactsCollection = $apiClient->contacts()->get();

$tagsCollectionsArray = array(
                                0 => $apiClient->tags(EntityTypesInterface::LEADS)->get(),
                                1 => $apiClient->tags(EntityTypesInterface::CONTACTS)->get(),
                            );
// $tagsCollection = $apiClient->tags(EntityTypesInterface::CONTACTS )->get();

// dump($companiesCollection);
// dump($leadsCollection);
// dump($contactsCollection);
// dump($tagsCollectionsArray);

foreach($tagsCollectionsArray as $tagsCollection)
{
    foreach($tagsCollection as $tag)
    {
        $db_tag = new Tags();

        $db_tag->id = $tag->getId();
        $db_tag->name = $tag->getName();

        $db_tag->color = ($tag->getColor() != null) ? $tag->getColor() : 'null';
        $db_tag->requestId = ($tag->getRequestId() != null) ? $tag->getRequestId() : -1;

        try {
            $db_tag->save();
        } catch (Exception $e) {}

        // $db_tag->save();
    }
}

foreach($companiesCollection as $company)
{
    $db_company = new Companies();

    $db_company->id = $company->getId();
    $db_company->name = $company->getName();
    $db_company->groupId = $company->getGroupId();
    $db_company->createdBy = $company->getCreatedBy();
    $db_company->updatedBy = $company->getUpdatedBy();
    $db_company->createdAt = $company->getCreatedAt();
    $db_company->updatedAt = $company->getUpdatedAt();
    $db_company->accountId = $company->getAccountId();
    $db_company->closestTaskAt = ($company->getClosestTaskAt() != null) ? $company->getClosestTaskAt() : -1;
    $db_company->requestId = ($company->getRequestId() != null) ? $company->getRequestId() : -1;

    $Comp_customFields = $company->getCustomFieldsValues();
    if (!empty($Comp_customFields)) {
        $db_company->PHONE = ($Comp_customFields->getBy('fieldCode', "PHONE") != null) ? 
            $Comp_customFields->getBy('fieldCode', "PHONE")->getValues()[0]->getValue() : '';
        $db_company->EMAIL = ($Comp_customFields->getBy('fieldCode', "EMAIL") != null) ? 
            $Comp_customFields->getBy('fieldCode', "EMAIL")->getValues()[0]->getValue() : '';
        $db_company->WEB = ($Comp_customFields->getBy('fieldCode', "WEB") != null) ? 
            $Comp_customFields->getBy('fieldCode', "WEB")->getValues()[0]->getValue() : '';
        $db_company->ADDRESS = ($Comp_customFields->getBy('fieldCode', "ADDRESS") != null) ? 
            $Comp_customFields->getBy('fieldCode', "ADDRESS")->getValues()[0]->getValue() : '';
    }

    try {
        $db_company->save();
    } catch (Exception $e) {}

    // $db_company->save();
}

foreach($companiesCollection as $company)
{
    $comp_tags = $company->getTags();
    if (($comp_tags != null)) {
        foreach($comp_tags as $tag)
        {
            $db_tag_company = new teg_company();

            $db_tag_company->tegId =$tag->getId();
            $db_tag_company->companyId =$company->getId();

            try {
                $db_tag_company->save();
            } catch (Exception $e) {}

            // $db_tag_company->save();
        }
    }
}


foreach($contactsCollection as $contact)
{
    $db_contact = new Contacts();

    $db_contact->id = $contact->getId();
    $db_contact->firstName = $contact->getFirstName();
    $db_contact->lastName = $contact->getLastName();
    $db_contact->responsibleUserId = $contact->getResponsibleUserId();
    $db_contact->groupId = $contact->getGroupId();
    $db_contact->createdBy = $contact->getCreatedBy();
    $db_contact->updatedBy = $contact->getUpdatedBy();
    $db_contact->createdAt = $contact->getCreatedAt();
    $db_contact->updatedAt = $contact->getUpdatedAt();
    $db_contact->accountId = $contact->getAccountId();
    $db_contact->isMain = $contact->getIsMain();

    $cont_customFields = $contact->getCustomFieldsValues();
    if (!empty($cont_customFields)) {
        $db_contact->PHONE = ($cont_customFields->getBy('fieldCode', "PHONE") != null) ? 
            $cont_customFields->getBy('fieldCode', "PHONE")->getValues()[0]->getValue() : '';
        $db_contact->EMAIL = ($cont_customFields->getBy('fieldCode', "EMAIL") != null) ? 
            $cont_customFields->getBy('fieldCode', "EMAIL")->getValues()[0]->getValue() : '';
        $db_contact->POSITION = ($cont_customFields->getBy('fieldCode', "POSITION") != null) ? 
            $cont_customFields->getBy('fieldCode', "POSITION")->getValues()[0]->getValue() : '';
    }

    $db_contact->closestTaskAt = ($contact->getClosestTaskAt() != null) ? $contact->getClosestTaskAt() : -1;
    $db_contact->requestId = ($contact->getRequestId() != null) ? $contact->getRequestId() : -1;

    $db_contact->companyId= ($contact->getCompany() != null) ? $contact->getCompany()->getId() : -1;

    try {
        $db_contact->save();
    } catch (Exception $e) {}

    // $db_contact->save();
}

foreach($contactsCollection as $contact)
{
    $cont_tags = $contact->getTags();
    if (($cont_tags != null)) {
        foreach($cont_tags as $tag)
        {
            $db_tag_contact = new teg_contact();

            $db_tag_contact->tegId =$tag->getId();
            $db_tag_contact->contactId =$contact->getId();

            try {
                $db_tag_contact->save();
            } catch (Exception $e) {}

            // $db_tag_contact->save();
        }
    }
}

foreach($leadsCollection as $lead)
{
    $db_lead = new LeadsModel();

    $db_lead->id = $lead->getId();
    $db_lead->name = $lead->getName();
    $db_lead->responsibleUserId = $lead->getResponsibleUserId();
    $db_lead->groupId = $lead->getGroupId();
    $db_lead->createdBy = $lead->getCreatedBy();
    $db_lead->updatedBy = $lead->getUpdatedBy();
    $db_lead->createdAt = $lead->getCreatedAt();
    $db_lead->updatedAt = $lead->getUpdatedAt();
    $db_lead->accountId = $lead->getAccountId();
    $db_lead->pipelineId = $lead->getPipelineId();
    $db_lead->statusId = $lead->getStatusId();
    $db_lead->closedAt = $lead->getClosedAt();
    $db_lead->price = $lead->getPrice();
    $db_lead->isDeleted = $lead->getIsDeleted();
    

    $db_lead->closestTaskAt = ($lead->getClosestTaskAt() != null) ? $lead->getClosestTaskAt() : -1;
    $db_lead->sourceId = ($lead->getSourceId() != null) ? $lead->getSourceId() : -1;
    $db_lead->sourceExternalId = ($lead->getSourceExternalId() != null) ? $lead->getSourceExternalId() : -1;
    $db_lead->score = ($lead->getScore() != null) ? $lead->getScore() : -1;
    $db_lead->isPriceModifiedByRobot = ($lead->getIsPriceModifiedByRobot() != null) ? $lead->getIsPriceModifiedByRobot() : 0;
    $db_lead->visitorUid = ($lead->getVisitorUid() != null) ? $lead->getVisitorUid() : -1;
    $db_lead->requestId = ($lead->getRequestId() != null) ? $lead->getRequestId() : -1;

    $lossReason = $lead->getLossReason();
    if($lossReason != null)
    {
        $db_lossReason = new LossReasons;

        $db_lossReason->id = $lossReason->getId();
        $db_lossReason->name = $lossReason->getName();
        $db_lossReason->sort = $lossReason->getSort();
        $db_lossReason->createdAt = $lossReason->getCreatedAt();
        $db_lossReason->updatedAt = $lossReason->getUpdatedAt();

        $db_lossReason->requestId = ($lossReason->getRequestId() != null) ? $lossReason->getRequestId() : -1;

        try {
            $db_lossReason->save();
        } catch (Exception $e) {}

        // $db_lossReason->save();
    }

    $db_lead->lossReasonId  = ($lead->getLossReason() != null) ? $lead->getLossReason()->getId() : null;
    $db_lead->companyId= ($lead->getCompany() != null) ? $lead->getCompany()->getId() : null;

    try {
        $db_lead->save();
    } catch (Exception $e) {
        // echo "Message : " . $e->getMessage();
        // echo "Code : " . $e->getCode();
    }

    // $db_lead->save();
}

foreach($leadsCollection as $lead)
{
    $l_tags = $lead->getTags();
    if (($l_tags != null)) {
        foreach($l_tags as $tag)
        {
            $db_tag_lead = new teg_lead();

            $db_tag_lead->tegId =$tag->getId();
            $db_tag_lead->leadId =$lead->getId();

            try {
                $db_tag_lead->save();
            } catch (Exception $e) {
                // echo "Message : " . $e->getMessage();
                // echo "Code : " . $e->getCode();
            }

            // $db_tag_lead->save();
        }
    }

    $l_contacts = $lead->getContacts();
    if (($l_contacts != null)) {
        foreach($l_contacts as $contact)
        {
            $db_contact_lead = new contact_lead();

            $db_contact_lead->contactId =$contact->getId();
            $db_contact_lead->leadId =$lead->getId();

            try {
                $db_contact_lead->save();
            } catch (Exception $e) {}

            // $db_contact_lead->save();
        }
    }
}

