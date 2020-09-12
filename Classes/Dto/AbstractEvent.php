<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api\Dto;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

use DateTime;
use PunktDe\Zoom\Api\Resource\WebinarRegistrantResource;
use PunktDe\Zoom\Api\ResultCollection;

abstract class AbstractEvent implements ApiDtoInterface
{
    /** @var int|null */
    protected $id;

    /** @var string */
    protected $topic;

    /** @var int */
    protected $type = 0;

    /**
     * Format this according to API:
     * To set GMT time, use 1970-01-01T12:00:00Z
     * To set to specific timezone, use 1970-01-01T12:00:00
     *
     * Note: To use a custom timezone, $timezone SHOULD be set, if it is omitted,
     * the timezone configured in the zoom account will be used.
     *
     * @var string
     */
    protected $start_time;

    /**
     * The duration in minutes
     *
     * @var int
     */
    protected $duration;

    /** @var string */
    protected $timezone;

    /** @var string */
    protected $password;

    /** @var string */
    protected $agenda;

    /** @var string[] */
    protected $settings;

    /** @var string*/
    protected $host_email;

    /** @var string */
    protected $join_url;

    /**
     * Meeting constructor.
     * We need to set certain settings as default to ensure, participants can be registered correctly
     */
    public function __construct()
    {
        $this->settings = $this->getDefaultSettings();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): AbstractEvent
    {
        $this->id = $id;
        return $this;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): AbstractEvent
    {
        $this->topic = $topic;
        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): AbstractEvent
    {
        $this->type = $type;
        return $this;
    }

    public function getStartTime(): string
    {
        return $this->start_time;
    }

    /**
     * @param DateTime|string $start_time
     * @return Meeting
     */
    public function setStartTime($start_time): AbstractEvent
    {
        if ($start_time instanceof DateTime) {
            $this->start_time = $start_time->format('Y-m-d\TH:i:s\Z');
        } else {
            $this->start_time = $start_time;
        }
        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): AbstractEvent
    {
        $this->duration = $duration;
        return $this;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): AbstractEvent
    {
        $this->timezone = $timezone;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): AbstractEvent
    {
        $this->password = $password;
        return $this;
    }

    public function getAgenda(): string
    {
        return $this->agenda;
    }

    public function setAgenda(string $agenda): AbstractEvent
    {
        $this->agenda = $agenda;
        return $this;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function setSettings(array $settings): AbstractEvent
    {
        $this->settings = $settings;
        return $this;
    }

    public function getHostEmail(): string
    {
        return $this->host_email;
    }

    public function setHostEmail(string $host_email): AbstractEvent
    {
        $this->host_email = $host_email;
        return $this;
    }

    public function getJoinUrl(): string
    {
        return $this->join_url;
    }

    public function setJoinUrl(string $join_url): AbstractEvent
    {
        $this->join_url = $join_url;
        return $this;
    }

    /**
     * Convenience method to retrieve all registered participants of a meeting
     * @return ResultCollection
     */
    public function findRegistrants(): ResultCollection
    {
        return (new WebinarRegistrantResource())->getAll([], 100, [], $this->getIdentifier());
    }

    public function getIdentifier(): string
    {
        return (string)$this->id;
    }

    /**
     * @return mixed[]
     */
    protected function getDefaultSettings(): array
    {
        return [
            'approval_type' => 1,
            'registration_type' => 2,
            'use_pmi' => false
        ];
    }
}
