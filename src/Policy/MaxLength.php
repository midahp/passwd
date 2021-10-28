<?php
declare(strict_types=1);
namespace Horde\Passwd\Policy;
/**
 * Interface of a Password Policy
 */
class MaxLength implements Policy
{
    private $maxLength;
    public function __construct(int $maxLength = 255)
    {
        $this->maxLength = $maxLength;
    }

    /**
     * Check a password for the policy
     *
     * @param string $password The password to check
     * @return string|null null if passed, String for issues
     */
    public function check(string $password): ?string
    {
        if (strlen($password) >= $this->maxLength) {
            return _('Password must not be longer than') . ' ' . $this->maxLength;
        }
        return null;
    }
}