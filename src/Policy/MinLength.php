<?php
declare(strict_types=1);
namespace Horde\Passwd\Policy;
/**
 * Interface of a Password Policy
 */
class MinLength implements Policy
{
    private $minLength;

    public function __construct(int $minLength = 255)
    {
        $this->minLength = $minLength;
    }

    /**
     * Check a password for the policy
     *
     * @param string $password The password to check
     * @return string|null null if passed, String for issues
     */
    public function check(string $password): ?string
    {
        if (strlen($password) <= $this->minLength) {
            return _('Password must not be shorter than') . ' ' . $this->minLength;
        }
        return null;
    }
}