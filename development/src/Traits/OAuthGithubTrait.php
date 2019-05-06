<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Traits;

trait OAuthGithubTrait
{
    /**
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    private $githubId;

    public function getGithubId(): ?string
    {
        return $this->githubId;
    }

    public function setGithubId(string $githubId): void
    {
        $this->githubId = $githubId;
    }
}
