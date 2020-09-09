<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Dto;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

class Registrant implements ApiDtoInterface
{
    /** @var string */
    protected $email;

    /** @var string */
    protected $first_name;

    /** @var string */
    protected $last_name;

    /** @var string */
    protected $address;

    /** @var string */
    protected $city;

    /** @var string */
    protected $country;

    /** @var string */
    protected $zip;

    /** @var string */
    protected $state;

    /** @var string */
    protected $phone;

    /** @var string */
    protected $industry;

    /** @var string */
    protected $org;

    /** @var string */
    protected $job_title;

    /** @var string */
    protected $purchasing_time_frame;

    /** @var string */
    protected $role_in_purchase_process;

    /** @var string */
    protected $no_of_employees;

    /** @var string */
    protected $comments;

    /** @var string */
    protected $language;

    /**
     * A users e-mail is used as the identifier in accordance with the zoom API-docs
     * @see https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingregistrantcreate
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): Registrant
    {
        $this->email = $email;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): Registrant
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): Registrant
    {
        $this->last_name = $last_name;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): Registrant
    {
        $this->address = $address;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): Registrant
    {
        $this->city = $city;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): Registrant
    {
        $this->country = $country;
        return $this;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip(string $zip): Registrant
    {
        $this->zip = $zip;
        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): Registrant
    {
        $this->state = $state;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): Registrant
    {
        $this->phone = $phone;
        return $this;
    }

    public function getIndustry(): string
    {
        return $this->industry;
    }

    public function setIndustry(string $industry): Registrant
    {
        $this->industry = $industry;
        return $this;
    }

    public function getOrg(): string
    {
        return $this->org;
    }

    public function setOrg(string $org): Registrant
    {
        $this->org = $org;
        return $this;
    }

    public function getJobTitle(): string
    {
        return $this->job_title;
    }

    public function setJobTitle(string $job_title): Registrant
    {
        $this->job_title = $job_title;
        return $this;
    }

    public function getPurchasingTimeFrame(): string
    {
        return $this->purchasing_time_frame;
    }

    public function setPurchasingTimeFrame(string $purchasing_time_frame): Registrant
    {
        $this->purchasing_time_frame = $purchasing_time_frame;
        return $this;
    }

    public function getRoleInPurchaseProcess(): string
    {
        return $this->role_in_purchase_process;
    }

    public function setRoleInPurchaseProcess(string $role_in_purchase_process): Registrant
    {
        $this->role_in_purchase_process = $role_in_purchase_process;
        return $this;
    }

    public function getNoOfEmployees(): string
    {
        return $this->no_of_employees;
    }

    public function setNoOfEmployees(string $no_of_employees): Registrant
    {
        $this->no_of_employees = $no_of_employees;
        return $this;
    }

    public function getComments(): string
    {
        return $this->comments;
    }

    public function setComments(string $comments): Registrant
    {
        $this->comments = $comments;
        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): Registrant
    {
        $this->language = $language;
        return $this;
    }
}
