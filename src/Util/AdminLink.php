<?php

declare(strict_types=1);

namespace Bone\View\Util;

class AdminLink
{
    public function __construct(
        private string $name,
        private string $url,
        private ?string $iconClass = null,
        private ?string $aClass = null,
        private ?string $liClass = null,
    ) {}

    public function getAClass(): ?string
    {
        return $this->aClass;
    }

    public function getIconClass(): ?string
    {
        return $this->iconClass;
    }

    public function getLiClass(): ?string
    {
        return $this->liClass;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
