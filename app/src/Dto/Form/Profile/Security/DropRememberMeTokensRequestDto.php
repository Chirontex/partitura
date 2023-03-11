<?php
declare(strict_types=1);

namespace Partitura\Dto\Form\Profile\Security;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DropRememberMeTokensRequestDto
 * @package Partitura\Dto\Form\Profile\Security
 */
class DropRememberMeTokensRequestDto extends SecurityRequestDto
{
    public const DROP_REMEMBERME_TOKENS_KEY = "drop_rememberme_tokens";

    /**
     * @Assert\IsTrue
     * 
     * @Serializer\Type("bool")
     * @Serializer\SerializedName(\Partitura\Dto\Form\Profile\Security\DropRememberMeTokensRequestDto::DROP_REMEMBERME_TOKENS_KEY)
     */
    protected bool $needToDropTokens = false;

    /**
     * @return bool
     */
    public function getNeedToDropTokens() : bool
    {
        return $this->needToDropTokens === true;
    }

    /**
     * @param bool $needToDropTokens
     *
     * @return $this
     */
    public function setNeedToDropTokens(bool $needToDropTokens) : static
    {
        $this->needToDropTokens = $needToDropTokens;

        return $this;
    }
}
