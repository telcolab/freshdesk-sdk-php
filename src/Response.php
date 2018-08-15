<?php
namespace TelcoLAB\Freshdesk\SDK;

use Laravie\Codex\Exceptions\HttpException;
use Laravie\Codex\Response as BaseResponse;
use TelcoLAB\Freshdesk\SDK\Exceptions\BadRequestException;
use TelcoLAB\Freshdesk\SDK\Exceptions\MethodNotAllowedException;
use TelcoLAB\Freshdesk\SDK\Exceptions\NotFoundException;

class Response extends BaseResponse
{
    public function validate()
    {
        parent::validate();

        $this->abortIfMethodNotAllowed();

        $this->abortIfNotFound();

        $this->abortIfBadRequest();

        $this->abortIfRequestFailed();

        return $this;
    }

    public function abortIfMethodNotAllowed()
    {
        if ($this->getStatusCode() === 405) {
            throw new MethodNotAllowedException($this, $this->getResponse()->message);
        }
    }

    public function abortIfNotFound()
    {
        if ($this->getStatusCode() === 404) {
            throw new NotFoundException($this, 'Resource requested is not found.');
        }
    }

    public function abortIfBadRequest()
    {
        if ($this->getStatusCode() === 400) {
            throw new BadRequestException($this, (string) $this->getBody());
        }
    }

    public function abortIfRequestFailed()
    {
        if (!$this->isSuccessful()) {
            throw new HttpException($this, (string) $this->getBody());
        }
    }

    public function getResponse()
    {
        return json_decode($this->getBody());
    }
}
